<?php

namespace App\Filament\Imports;

use App\Models\Participant;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class ParticipantImporter extends Importer
{
    protected static ?string $model = Participant::class;


    public static function getColumns(): array
    {
        return [
             ImportColumn::make('member')
                ->requiredMapping()
                ->boolean(),
            
            ImportColumn::make('first_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('status')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            
            ImportColumn::make('surname')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            
             ImportColumn::make('grade')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            
             ImportColumn::make('phone')
                ->requiredMapping()
                ->rules(['max:255']),
            
             ImportColumn::make('email')
                ->requiredMapping()
             ->rules(['max:255']),
            
             ImportColumn::make('guardian_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
             ImportColumn::make('guardian_phone')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('guardian_email')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('is_visiting')
                ->requiredMapping()
                 ->boolean(),
            ImportColumn::make('gdpr')
                ->requiredMapping()
                ->boolean(),
                 ImportColumn::make('friends')
                ->requiredMapping()
                ->rules([ 'max:255']),
                 ImportColumn::make('special_diet')
                ->requiredMapping()
                ->rules([ 'max:255']),
        ];
           
    }

    public function resolveRecord(): Participant
    {
        return new Participant();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your participant import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
