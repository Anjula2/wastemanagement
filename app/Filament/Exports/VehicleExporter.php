<?php

namespace App\Filament\Exports;

use App\Models\Vehicle;
use App\Filament\Exports\VehicleExporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Notifications\Notifiable;

class VehicleExporter extends Exporter
{
    protected static ?string $model = Vehicle::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('vehicle_no')->label('Vehicle No'),
            ExportColumn::make('type')->label('Type'),
            ExportColumn::make('date')->label('Date of joining the service'),
            ExportColumn::make('status')->label('Status'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your vehicle export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
