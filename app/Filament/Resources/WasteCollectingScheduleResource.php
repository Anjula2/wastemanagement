<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WasteCollectingScheduleResource\Pages;
use App\Filament\Resources\WasteCollectingScheduleResource\RelationManagers;
use App\Models\WasteCollectingSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WasteCollectingScheduleResource extends Resource
{
    protected static ?string $model = WasteCollectingSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('schedule_id')
                    ->label('Schedule ID')
                    ->unique('waste_collecting_schedules', 'schedule_id') 
                    ->nullable()
                    ->required(),

                Forms\Components\Select::make('date')
                    ->label('Date')
                    ->options([
                       'Monday' => 'Monday',
                       'Tuesday' => 'Tuesday',
                       'Wednesday' => 'Wednesday',
                       'Thursday' => 'Thursday',
                       'Friday' => 'Friday',
                       'Saturday' => 'Saturday',
                       'Sunday' => 'Sunday',
                    ])
                    ->required(),

                Forms\Components\TimePicker::make('start_time')
                    ->label('Start Time')
                    ->required(),

                Forms\Components\TimePicker::make('end_time')
                    ->label('End Time')
                    ->required(),

                Forms\Components\Select::make('waste_collection_zone_id')
                    ->label('Waste Collection Zone')
                    ->relationship('wasteCollectionZone', 'zone_name')
                    ->required(),

                Forms\Components\Select::make('waste_type')
                   ->label('Waste Type')
                   ->options([
                    'Organic Waste' => 'Organic Waste',
                    'Recyclable Waste' => 'Recyclable Waste',
                    'Non-Recyclable Waste' => 'Non-Recyclable Waste',
                    'Hazardous Waste' => 'Hazardous Waste',
                    'Construction and Demolition Waste' => 'Construction and Demolition Waste',
                    'Special Waste' => 'Special Waste',
                    'All' => 'All',
                    ])
                   ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('schedule_id')
                   ->label('Schedule ID'),

                Tables\Columns\TextColumn::make('date')
                   ->label('Date'),

                Tables\Columns\TextColumn::make('start_time')
                   ->label('Start Time')
                   ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('g:i A')),

                Tables\Columns\TextColumn::make('end_time')
                   ->label('End Time')
                   ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('g:i A')),

                Tables\Columns\TextColumn::make('waste_collection_zone')
                   ->label('Waste Collection Zone')
                   ->sortable()
                   ->searchable()
                   ->getStateUsing(fn ($record) => optional($record->wasteCollectionZone)->zone_name),

                Tables\Columns\TextColumn::make('waste_type')
                   ->label('Waste Type'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListWasteCollectingSchedules::route('/'),
            'create' => Pages\CreateWasteCollectingSchedule::route('/create'),
            'edit' => Pages\EditWasteCollectingSchedule::route('/{record}/edit'),
        ];
    }
}
