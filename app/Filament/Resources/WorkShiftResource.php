<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkShiftResource\Pages;
use App\Filament\Resources\WorkShiftResource\RelationManagers;
use Carbon\Carbon;
use App\Models\WorkShift;
use App\Models\Worker;
use App\Models\Driver;
use App\Models\Supervisor;
use App\Models\Vehicle;
use App\Models\WasteCollectionZone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Notifications\Notifiable;

class WorkShiftResource extends Resource
{
    protected static ?string $model = WorkShift::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Select::make('worker_ids')
                ->label('Workers')
                ->options(Worker::all()->pluck('name', 'id'))
                ->multiple()
                ->required()
                ->getSearchResultsUsing(function ($search) {
                    return Worker::all()
                        ->mapWithKeys(function ($worker) {
                            return [
                                $worker->id => $worker->name . ($worker->is_available ? '' : ' (Unavailable)'),
                            ];
                        })
                        ->toArray();
                })
                ->disableOptionWhen(function ($value) {
                    return !Worker::find($value)->is_available;
                }),

            Forms\Components\Select::make('driver_id')
                ->label('Driver')
                ->options(Driver::all()->pluck('name', 'id')) 
                ->required()
                ->disableOptionWhen(function ($value) {
                    return !Driver::find($value)->is_available;
                }),

            Forms\Components\Select::make('supervisor_id')
                ->label('Supervisor')
                ->options(Supervisor::all()->pluck('name', 'id')) 
                ->required()
                ->disableOptionWhen(function ($value) {
                    return !Supervisor::find($value)->is_available; 
                }),

            Forms\Components\Select::make('vehicle_id')
                ->label('Vehicle')
                ->options(Vehicle::all()->pluck('vehicle_no', 'id')) 
                ->required()
                ->disableOptionWhen(function ($value) {
                    return !Vehicle::find($value)->is_available; 
                }),

            Forms\Components\Select::make('waste_collection_zone_id')
                ->label('Waste Collection Zone')
                ->options(WasteCollectionZone::all()->pluck('zone_name', 'id'))
                ->required(),

            Forms\Components\Select::make('shift_type')
                ->label('Shift Type')
                ->options([
                    'Morning' => 'Morning',
                    'Afternoon' => 'Afternoon',
                    'Night' => 'Night',
                ])
                ->required(),

            Forms\Components\DateTimePicker::make('shift_start')
                ->label('Shift Start')
                ->required()
                ->minDate(today()),

            Forms\Components\DateTimePicker::make('shift_end')
                ->label('Shift End')
                ->required()
                ->minDate(today()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TagsColumn::make('worker_ids')
                ->label('Workers')
                ->getStateUsing(fn ($record) => Worker::whereIn('id', (array) $record->worker_ids)->pluck('name')->toArray()),
            
            Tables\Columns\TextColumn::make('driver_id')
                ->label('Driver')
                ->getStateUsing(fn ($record) => optional($record->driver)->name),

            Tables\Columns\TextColumn::make('supervisor_id')
                ->label('Supervisor')
                ->getStateUsing(fn ($record) => optional($record->supervisor)->name),

            Tables\Columns\TextColumn::make('vehicle_id')
                ->label('Vehicle')
                ->getStateUsing(fn ($record) => optional($record->vehicle)->vehicle_no),

            Tables\Columns\TextColumn::make('waste_collection_zone_id')
                ->label('Waste Collection Zone')
                ->getStateUsing(fn ($record) => optional($record->wasteCollectionZone)->zone_name),

            Tables\Columns\TextColumn::make('shift_type')
                ->label('Shift Type'),

            Tables\Columns\TextColumn::make('shift_start')
                ->label('Shift Start')
                ->getStateUsing(fn ($record) => Carbon::parse($record->shift_start)->format('Y-m-d H:i:s')),

           Tables\Columns\TextColumn::make('shift_end')
                ->label('Shift End')
                ->getStateUsing(fn ($record) => Carbon::parse($record->shift_end)->format('Y-m-d H:i:s')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkShifts::route('/'),
            'create' => Pages\CreateWorkShift::route('/create'),
            'edit' => Pages\EditWorkShift::route('/{record}/edit'),
        ];
    }
}
