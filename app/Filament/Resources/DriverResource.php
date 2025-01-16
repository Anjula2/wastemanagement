<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Resources\DriverResource\RelationManagers;
use App\Models\Driver;
use App\Filament\Exports\DriverExporter;
use Filament\Notifications\Notification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Notifications\Notifiable;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('driver_id')
                ->label('Driver Id')
                ->unique(ignorable: fn ($record) => $record)
                ->required(),
            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required(),
            Forms\Components\TextInput::make('phone')
                ->label('Phone')
                ->tel()
                ->required(),
            Forms\Components\TextInput::make('licence_no')
                ->label('Licence No')
                ->required(),
            Forms\Components\TextInput::make('address')
                ->label('Address')
                ->maxLength(255)
                ->required(),
            Forms\Components\DatePicker::make('date')
                ->label('Joined Date')
                ->maxDate(today())
                ->default(now())
                ->required(),
            Forms\Components\Toggle::make('is_available')
                ->label('Is Available')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('driver_id')->label('Driver Id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('licence_no'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('date')
                      ->label('Joined Date')
                      ->dateTime('Y-m-d'),
                Tables\Columns\TextColumn::make('status')->default('Available'),
                Tables\Columns\BooleanColumn::make('is_available')
                      ->label('Availability')
                      ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Available')->label('Available')
                    ->action(function ($record) {
                        $record->update(['is_available' => true]);
                        Notification::make()
                            ->success()
                            ->title('Driver is Available')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('Unavailable')->label('Unavailable')
                    ->action(function ($record) {
                        $record->update(['is_available' => false]);
                        Notification::make()
                            ->danger()
                            ->title('Driver is Unavailable')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-mark'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->headerActions([
                ExportAction::make()->exporter(DriverExporter::class),
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
