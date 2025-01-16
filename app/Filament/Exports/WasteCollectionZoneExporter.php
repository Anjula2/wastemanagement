<?php

namespace App\Filament\Exports;

use App\Models\WasteCollectionZone;
use App\Filament\Exports\WasteCollectionZoneExporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Notifications\Notifiable;


class WasteCollectionZoneExporter extends Exporter
{
    protected static ?string $model = WasteCollectionZone::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('zone_id')->label('Zone ID'),
            ExportColumn::make('zone_name')->label('Zone Name'),
            ExportColumn::make('areas')->label('NIC No'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your waste collection zone export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
