<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                GazeBanner::make()
                ->pollTimer(10)
                ->hideOnCreate(),
                TextInput::make('name'),
                TextInput::make('email'),
                TextInput::make('password')
            ]);
    }
}
