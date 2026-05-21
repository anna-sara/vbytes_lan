<?php

namespace App\Filament\Resources\Smstemplates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\MarkdownEditor;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;

class SmstemplatesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                GazeBanner::make()
                    ->pollTimer(10)
                    ->hideOnCreate(),
                TextInput::make('title')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('draft')
                    ->default(false)
                    ->onColor('warning')
                    ->columnSpanFull(),
            ]);
    }
}
