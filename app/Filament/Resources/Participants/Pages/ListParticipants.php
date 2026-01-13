<?php

namespace App\Filament\Resources\Participants\Pages;

use App\Filament\Resources\Participants\ParticipantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Imports\ParticipantImporter;
use Filament\Actions\ImportAction;

class ListParticipants extends ListRecords
{

    protected static string $resource = ParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ImportAction::make()
            ->importer(ParticipantImporter::class)
            ->maxRows(100000)
        ];
    }
}
