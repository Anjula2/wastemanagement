<?php

namespace App\Filament\Exports;

use App\Models\Complaint;
use App\Filament\Exports\ComplaintExporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Notifications\Notifiable;

class ComplaintExporter extends Exporter
{
    protected static ?string $model = Complaint::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('user_id'),
            ExportColumn::make('category')->label('Category'),
            ExportColumn::make('details')->label('Details'),
            ExportColumn::make('address')->label('Address'),
            ExportColumn::make('status')->label('Status'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your complaint export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
