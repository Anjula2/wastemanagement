<?php

namespace App\Filament\Exports;

use App\Models\Worker;
use App\Filament\Exports\WorkerExporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Notifications\Notifiable;

class WorkerExporter extends Exporter
{
    protected static ?string $model = Worker::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('worker_id')->label('Worker ID'),
            ExportColumn::make('name')->label('Worker Name'),
            ExportColumn::make('phone'),
            ExportColumn::make('nic_no')->label('NIC No'),
            ExportColumn::make('type'),
            ExportColumn::make('address'),
            ExportColumn::make('date')->label('Joined Date'),
            ExportColumn::make('status'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your worker export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
