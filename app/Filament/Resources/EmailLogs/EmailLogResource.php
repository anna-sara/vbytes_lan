<?php

namespace App\Filament\Resources\EmailLogs;

use App\Filament\Resources\EmailLogs\Pages\ListEmailLogs;
use App\Models\EmailLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmailLogResource extends Resource
{
    protected static ?string $model = EmailLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Email log';

    protected static \UnitEnum|string|null $navigationGroup = 'Logs';

    protected static ?int $navigationSort = 100;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Sent at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('lan_id')
                    ->label('LAN ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('guardian_email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('mailtemplate.title')
                    ->label('Mail template')
                    ->searchable(),
                TextColumn::make('smstemplate.title')
                    ->label('SMS template')
                    ->default('—'),
                TextColumn::make('participant.first_name')
                    ->label('First name')
                    ->searchable(),
                TextColumn::make('participant.surname')
                    ->label('Surname')
                    ->searchable(),
                TextColumn::make('error')
                    ->label('Error')
                    ->wrap()
                    ->color('danger')
                    ->default('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->recordActions([])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmailLogs::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
