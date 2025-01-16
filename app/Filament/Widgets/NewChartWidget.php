<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class NewChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Users Join Summary';

    protected function getData(): array
    {
            $data = Trend::model(User::class)
        ->between(
            start: now()->subMonths(6),
            end: now(),
        )
        ->perMonth()
        ->count();

        return [
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];

    }

    protected function getType(): string
    {
        return 'line';
    }
}
