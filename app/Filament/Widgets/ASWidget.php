<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Order;
use App\Models\Complaint;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ASWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Users',User::count())
               ->description('New users that have joined')
               ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
               ->chart([1,10,40,8,28,6,15])
               ->color('success'),

            Stat::make('New Complaint',Complaint::count())
               ->description('New complaints that have came')
               ->descriptionIcon('heroicon-m-exclamation-circle', IconPosition::Before)
               ->chart([1,40,5])
               ->color('danger'),

            Stat::make('New Orders',Order::count())
               ->description('New orders that have came')
               ->descriptionIcon('heroicon-m-arrow-path-rounded-square', IconPosition::Before)
               ->chart([1,40,20,8,58,6,5])
               ->color('success')
        ];
    }

}
