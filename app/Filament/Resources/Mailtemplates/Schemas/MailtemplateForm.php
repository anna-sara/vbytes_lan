<?php

namespace App\Filament\Resources\Mailtemplates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Filament\Forms\Components\MarkdownEditor;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;

class MailtemplateForm
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
                TextInput::make('type')
                    ->label('Greeting')
                    ->required()
                    ->columnSpanFull(),
                MarkdownEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
