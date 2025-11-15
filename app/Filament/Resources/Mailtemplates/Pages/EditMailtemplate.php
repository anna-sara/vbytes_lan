<?php

namespace App\Filament\Resources\Mailtemplates\Pages;

use App\Filament\Resources\Mailtemplates\MailtemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMailtemplate extends EditRecord
{
    protected static string $resource = MailtemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
