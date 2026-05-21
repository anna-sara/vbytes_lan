<?php

namespace App\Filament\Resources\Participants\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;
use Illuminate\Support\HtmlString;

class ParticipantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([  
            GazeBanner::make()
            ->pollTimer(10)
            ->hideOnCreate(),
            Grid::make()
                ->columnSpan('full')
                ->columns(2)
                ->schema([
                    Grid::make()
                    ->columns(1)
                    ->schema([
                        Radio::make('is_visiting')
                        ->label('Participating type')
                        ->boolean(falseLabel: 'LAN', trueLabel: 'Visit'),
                    ]),
                    Grid::make()
                    ->columns(2)
                    ->schema([
                         Grid::make()
                    ->columns(1)
                    ->schema([
                        Toggle::make('emailed')
                            ->required()
                            ->onColor('success')
                            ->offColor('danger'),
                        Toggle::make('member')
                            ->required()
                            ->onColor('success')
                            ->offColor('danger'),
                        ]),
                    Grid::make()
                    ->columns(1)
                    ->schema([
                        Toggle::make('paid')
                            ->required()
                            ->onColor('success')
                            ->offColor('danger'),
                        Toggle::make('gdpr')
                            ->required()
                            ->onColor('success')
                            ->offColor('danger'),
                        ])
                    ]),
                ]),
                TextInput::make('lan_id')
                ->integer(),
                Select::make('status')
                    ->options([
                        'lan' => 'Ordinarie',
                        'reserv' => 'Reserv',
                        'besök' => 'Besök',
                    ]),
                TextInput::make('ssn')
                    ->label('SSN')
                    ->default(null)
                    ->length(12)
                    ->columnSpan('full'),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('surname')
                    ->required(),
                TextInput::make('grade')
                    ->columnSpan('full')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),
                TextInput::make('guardian_name')
                    ->required(),
                TextInput::make('guardian_phone')
                    ->tel()
                    ->required(),
                TextInput::make('guardian_email')
                    ->required(),
                TextInput::make('special_diet')
                    ->default(null),
                TextInput::make('friends')
                    ->default(null)
                    ->columnSpan('full'),
                Textarea::make('comment')
                    ->columnSpan('full'),
                Placeholder::make('email_log')
                    ->label('Emails sent')
                    ->columnSpan('full')
                    ->hidden(fn ($record) => $record === null)
                    ->content(function ($record) {
                        if (!$record) {
                            return '—';
                        }
                        $logs = $record->emailLogs()->with(['mailtemplate', 'smstemplate'])->latest()->get();
                        if ($logs->isEmpty()) {
                            return new HtmlString('<span class="text-gray-400 text-sm">No emails sent</span>');
                        }
                        $rows = $logs->map(function ($log) {
                            $date = $log->created_at->format('Y-m-d H:i');
                            $mail = e($log->mailtemplate?->title ?? '—');
                            $sms = $log->smstemplate ? ' + SMS: ' . e($log->smstemplate->title) : '';
                            $error = $log->error
                                ? ' <span class="text-red-500 font-medium">&#9888; ' . e($log->error) . '</span>'
                                : '';
                            return "<li class=\"text-sm py-1 border-b border-gray-100 last:border-0\"><span class=\"text-gray-400\">{$date}</span> &mdash; {$mail}{$sms}{$error}</li>";
                        })->join('');
                        return new HtmlString("<ul class=\"divide-y divide-gray-100\">{$rows}</ul>");
                    }),
            ]);
    }
}
