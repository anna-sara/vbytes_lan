<?php

namespace App\Filament\Exports;

use App\Models\Participant;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ParticipantExporter extends Exporter
{
    protected static ?string $model = Participant::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('participant_id'),
            ExportColumn::make('first_name'),
            ExportColumn::make('surname'),
            ExportColumn::make('grade'),
            ExportColumn::make('phone'),
            ExportColumn::make('email'),
            ExportColumn::make('guardian_name'),
            ExportColumn::make('guardian_phone'),
            ExportColumn::make('guardian_email'),
            ExportColumn::make('friends'),
            ExportColumn::make('special_diet'),
            ExportColumn::make('status')
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your participant export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
