<?php

namespace App\Filament\Resources\Smstemplates\Pages;

use App\Filament\Resources\Smstemplates\SmstemplatesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSmstemplates extends EditRecord
{
    protected static string $resource = SmstemplatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
