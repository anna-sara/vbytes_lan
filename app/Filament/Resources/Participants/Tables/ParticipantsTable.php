<?php

namespace App\Filament\Resources\Participants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Participant;
use App\Models\Mailtemplate;
use Filament\Tables\Columns\SelectColumn;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Mail;
use App\Mail\LanMail;
use Filament\Support\Icons\Heroicon;
use App\Filament\Exports\ParticipantExporter;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Columns\Summarizers\Count;

class ParticipantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                 Group::make('status')
                ->label('Status')
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
                TextColumn::make('lan_id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->summarize(Count::make()->label(''))
                ->color(fn (string $state): string => match ($state) {
                    'lan' => 'success',
                    'reserv' => 'warning',
                    'besök' => 'gray'
                })
              ->formatStateUsing(fn (string $state): string => __(ucfirst($state))),
                IconColumn::make('paid')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('emailed')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
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
                   
                IconColumn::make('member')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                //
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
                    ->options(Mailtemplate::all()->pluck('title', 'id'))
                ])
                ->action(function (array $data, Participant $record) {
                    $mailContent = Mailtemplate::where('id', $data['mailtemplate'])->get();
                    Mail::to($record->guardian_email)
                        ->send(new LanMail($mailContent, $record));
                    Participant::where('id', $record->id)->update(['emailed' => true]);
                })
                ->hidden(fn($record) => $record->emailed),
                Action::make('sendRemindEmail')
                ->label('Send remind email')
                ->icon(Heroicon::Envelope)
                ->schema([
                    Select::make('mailtemplate')
                    ->label('Mailtemplate')
                    ->options(Mailtemplate::all()->pluck('title', 'id'))
                ])
                ->action(function (array $data, Participant $record) {
                    $mailContent = Mailtemplate::where('id', $data['mailtemplate'])->get();
                    Mail::to($record->guardian_email)
                        ->queue(new LanMail($mailContent, $record));
                    Participant::where('id', $record->id)->update(['emailed' => true]);
                })
                ->hidden(fn($record) => !$record->emailed)
                
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
