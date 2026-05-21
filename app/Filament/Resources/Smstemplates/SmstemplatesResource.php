<?php

namespace App\Filament\Resources\Smstemplates;

use App\Filament\Resources\Smstemplates\Pages\CreateSmstemplates;
use App\Filament\Resources\Smstemplates\Pages\EditSmstemplates;
use App\Filament\Resources\Smstemplates\Pages\ListSmstemplates;
use App\Filament\Resources\Smstemplates\Schemas\SmstemplatesForm;
use App\Filament\Resources\Smstemplates\Tables\SmstemplatesTable;
use App\Models\Smstemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SmstemplatesResource extends Resource
{
    protected static ?string $model = Smstemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $navigationLabel = 'SMS templates';

    protected static \UnitEnum|string|null $navigationGroup = 'Templates';

    protected static ?int $navigationSort = 99;

    public static function form(Schema $schema): Schema
    {
        return SmstemplatesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SmstemplatesTable::configure($table);
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
            'index' => ListSmstemplates::route('/'),
            'create' => CreateSmstemplates::route('/create'),
            'edit' => EditSmstemplates::route('/{record}/edit'),
        ];
    }
}
