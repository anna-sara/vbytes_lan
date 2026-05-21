<?php

namespace App\Filament\Resources\Smstemplates\Pages;

use App\Filament\Resources\Smstemplates\SmstemplatesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSmstemplates extends ListRecords
{
    protected static string $resource = SmstemplatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
