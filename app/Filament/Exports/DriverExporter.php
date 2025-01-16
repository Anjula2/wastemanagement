<?php

namespace App\Filament\Exports;

use App\Models\Driver;
use App\Filament\Exports\DriverExporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Notifications\Notifiable;

class DriverExporter extends Exporter
{
    protected static ?string $model = Driver::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('driver_id')->label('Driver Id'),
            ExportColumn::make('name')->label('Driver Name'),
            ExportColumn::make('phone'),
            ExportColumn::make('licence_no')->label('Licence No'),
            ExportColumn::make('date')->label('Joined Date'),
            ExportColumn::make('status')->label('Status'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your driver export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
