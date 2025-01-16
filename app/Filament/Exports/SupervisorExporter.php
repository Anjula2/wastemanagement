<?php

namespace App\Filament\Exports;

use App\Models\Supervisor;
use App\Filament\Exports\SupervisorExporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Notifications\Notifiable;

class SupervisorExporter extends Exporter
{
    protected static ?string $model = Supervisor::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('supervisor_id')->label('Supervisor ID'),
            ExportColumn::make('zone_id')->label('Zone'),
            ExportColumn::make('name')->label('Name'),
            ExportColumn::make('phone')->label('Phone Number'),
            ExportColumn::make('nic_no')->label('NIC Number'),
            ExportColumn::make('address')->label('Address'),
            ExportColumn::make('date')->label('Joined Date'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your supervisor export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
