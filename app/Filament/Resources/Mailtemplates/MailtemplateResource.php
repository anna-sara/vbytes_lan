<?php

namespace App\Filament\Resources\Mailtemplates;

use App\Filament\Resources\Mailtemplates\Pages\CreateMailtemplate;
use App\Filament\Resources\Mailtemplates\Pages\EditMailtemplate;
use App\Filament\Resources\Mailtemplates\Pages\ListMailtemplates;
use App\Filament\Resources\Mailtemplates\Schemas\MailtemplateForm;
use App\Filament\Resources\Mailtemplates\Tables\MailtemplatesTable;
use App\Models\Mailtemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MailtemplateResource extends Resource
{
    protected static ?string $model = Mailtemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MailtemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MailtemplatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMailtemplates::route('/'),
            'create' => CreateMailtemplate::route('/create'),
            'edit' => EditMailtemplate::route('/{record}/edit'),
        ];
    }
}
