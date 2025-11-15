<?php

namespace App\Filament\Resources\Mailtemplates\Pages;

use App\Filament\Resources\Mailtemplates\MailtemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMailtemplates extends ListRecords
{
    protected static string $resource = MailtemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
