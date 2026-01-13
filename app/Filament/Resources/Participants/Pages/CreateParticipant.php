<?php

namespace App\Filament\Resources\Participants\Pages;

use App\Filament\Resources\Participants\ParticipantResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Participant;
use App\Models\Version;

class CreateParticipant extends CreateRecord
{
    protected static string $resource = ParticipantResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $count = Participant::where('is_visiting', false)->count();
        if ($count < config('app.lanplace_amount') && !$data['is_visiting']) {
             $data['status'] = "lan";
        }

        else if ($data['is_visiting']) {
            $data['status'] = "besök";
        }

        else {
             $data['status'] = "reserv";
        }

        return $data;
    }
}
