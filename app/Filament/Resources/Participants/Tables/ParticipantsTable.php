<?php

namespace App\Filament\Resources\Participants\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\EmailLog;
use App\Models\Participant;
use App\Models\Mailtemplate;
use Filament\Tables\Columns\SelectColumn;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Mail;
use App\Mail\LanMail;
use App\Mail\SmsMail;
use Filament\Support\Icons\Heroicon;
use App\Filament\Exports\ParticipantExporter;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Validation\Rule;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\ToggleColumn;

class ParticipantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated([10, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(100)
            ->groups([
                Group::make('status')
                    ->label('Status')
                    ->getTitleFromRecordUsing(fn ($record) => ucfirst($record->status))
                    ->collapsible(),
            ])
             ->defaultGroup('status')
            //->groupsOnly()
            ->recordAction(null)
            ->headerActions([
                ExportAction::make()
                    ->exporter(ParticipantExporter::class),
                ])
            ->columns([
                TextInputColumn::make('lan_id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->rules(fn ($record) => [
                        Rule::unique('participants', 'lan_id')->ignore($record->id),
                    ])
                    ->validationMessages([
                        'unique' => 'LAN ID is already assigned to another participant.',
                    ]),
                TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'lan' => 'success',
                    'reserv' => 'warning',
                    'besök' => 'gray'
                })
              ->formatStateUsing(fn (string $state): string => __(ucfirst($state))),
                TextColumn::make('ssn')
                    ->label('SSN')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('first_name')
                    ->searchable()
                    ->sortable()
                    ->summarize(Count::make()->label('')),
                TextColumn::make('surname')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('grade')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('guardian_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('guardian_phone')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('guardian_email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('is_visiting')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => $state?'visit':'lan')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('paid')
                    ->sortable(),
                ToggleColumn::make('member')
                    ->sortable(),
                IconColumn::make('emailed')
                    ->boolean()
                    ->sortable()
                    ->tooltip(function ($record) {
                        $logs = $record->emailLogs()->with(['mailtemplate', 'smstemplate'])->latest()->get();
                        if ($logs->isEmpty()) {
                            return 'No emails sent';
                        }
                        return $logs->map(fn($log) =>
                            ' Mail: ' . ($log->mailtemplate?->title ?? '—')
                        )->join("\n");
                    }),
                TextColumn::make('comment')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('gdpr')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('friends')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('special_diet')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'lan' => 'Ordinarie',
                        'reserv' => 'Reserv',
                        'besök' => 'Besök',
                    ])
                    ->multiple(),
            ])
            ->recordActions([
                EditAction::make()
                ->modalWidth()
                ->slideOver(),
                Action::make('sendEmail')
                ->label('Send email')
                ->icon(Heroicon::Envelope)
                ->schema([
                    Select::make('mailtemplate')
                    ->label('Mailtemplate')
                    ->options(Mailtemplate::where('draft', false)->pluck('title', 'id'))
                ])
                ->action(function (array $data, Participant $record) {
                    $mailtemplate = Mailtemplate::with('smstemplate')->find($data['mailtemplate']);
                    if ($record->guardian_email) {
                        $error = null;
                        try {
                            Mail::to($record->guardian_email)
                                ->send(new LanMail(collect([$mailtemplate]), $record));
                            Participant::where('id', $record->id)->update(['emailed' => true]);
                            if ($mailtemplate->smstemplate && config('app.smsUrl')) {
                                Mail::to(config('app.smsUrl'))
                                    ->send(new SmsMail($record, $mailtemplate->smstemplate->content));
                            }
                        } catch (\Throwable $e) {
                            $error = $e->getMessage();
                        }
                        EmailLog::create([
                            'participant_id'  => $record->id,
                            'lan_id'          => $record->lan_id,
                            'guardian_email'  => $record->guardian_email,
                            'mailtemplate_id' => $mailtemplate->id,
                            'smstemplate_id'  => $mailtemplate->smstemplate?->id,
                            'error'           => $error,
                        ]);
                    }
                }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('bulkSendEmail')
                        ->label('Send email')
                        ->icon(Heroicon::Envelope)
                        ->schema([
                            Select::make('mailtemplate')
                                ->label('Mailtemplate')
                                ->options(Mailtemplate::where('draft', false)->pluck('title', 'id'))
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $mailtemplate = Mailtemplate::with('smstemplate')->find($data['mailtemplate']);
                            foreach ($records as $record) {
                                if (!$record->guardian_email) {
                                    continue;
                                }
                                $error = null;
                                try {
                                    Mail::to($record->guardian_email)
                                        ->queue(new LanMail(collect([$mailtemplate]), $record));
                                    if ($mailtemplate->smstemplate && config('app.smsUrl')) {
                                        Mail::to(config('app.smsUrl'))
                                            ->queue(new SmsMail($record, $mailtemplate->smstemplate->content));
                                    }
                                } catch (\Throwable $e) {
                                    $error = $e->getMessage();
                                }
                                EmailLog::create([
                                    'participant_id'  => $record->id,
                                    'lan_id'          => $record->lan_id,
                                    'guardian_email'  => $record->guardian_email,
                                    'mailtemplate_id' => $mailtemplate->id,
                                    'smstemplate_id'  => $mailtemplate->smstemplate?->id,
                                    'error'           => $error,
                                ]);
                            }
                            $records->toQuery()->whereDoesntHave('emailLogs', fn ($q) => $q->whereNotNull('error'))->update(['emailed' => true]);
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
