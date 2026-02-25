<?php

namespace App\Filament\Resources\Volunteers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\CheckboxList;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;

class VolunteerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                GazeBanner::make()
                ->pollTimer(10)
                ->hideOnCreate(),
                 TextInput::make('lan_id')
                ->integer(),
                Toggle::make('gdpr')
                ->columnSpan('full')
                    ->required(),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('surname')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                
                CheckboxList::make('areas')
                 ->required()
                 ->columnSpan('full')
                ->options([
                    'Kiosk & Kök' => 'Kiosk & Kök',
                    'Säkerhet' => 'Säkerhet',
                    'Städning' => 'Städning',
                    'Entré & Incheckning' => 'Entré & Incheckning',
                    'Teknisk Support' => 'Teknisk Support',
                    'Rådda' => 'Rådda',
                    'Turneringar' => 'Turneringar'
                ]),
                Textarea::make('comment')
                    ->columnSpan('full'),
            ]);
    }
}
