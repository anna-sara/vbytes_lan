<?php

namespace App\Filament\Resources\Volunteers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Mail;
use App\Mail\LanMail;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextInputColumn;
use App\Models\Volunteer;
use App\Models\Mailtemplate;

class VolunteersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordAction(null)
            ->columns([
               TextInputColumn::make('lan_id')
                    ->label('ID')
                    ->searchable()
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
                TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('areas')
                    ->label('Areas')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('gdpr')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('comment')
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
                ->action(function (array $data, Volunteer $record) {
                    $mailContent = Mailtemplate::where('id', $data['mailtemplate'])->get();
                    Mail::to($record->email)
                        ->queue(new LanMail($mailContent, $record));
                    Volunteer::where('id', $record->id)->update(['emailed' => true]);
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
                ->action(function (array $data, Volunteer $record) {
                    $mailContent = Mailtemplate::where('id', $data['mailtemplate'])->get();
                    Mail::to($record->email)
                        ->send(new LanMail($mailContent, $record));
                    Volunteer::where('id', $record->id)->update(['emailed' => true]);
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
