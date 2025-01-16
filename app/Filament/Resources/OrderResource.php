<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Filament\Exports\OrderExporter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Notifications\Notifiable;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Customer Name')
                ->required(),
                
            Forms\Components\TextInput::make('address')
                ->label('Address')
                ->required(),
                
            Forms\Components\Select::make('delivery_option')
                ->label('Delivery Option')
                ->options([
                    'Pickup' => 'Pickup',
                    'Delivery' => 'Delivery',
                ])
                ->default(fn ($record) => $record?->delivery_option)
                ->required(),
                
            Forms\Components\TextInput::make('total')
                ->label('Total Amount')
                ->numeric()
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Order Id'),
                Tables\Columns\TextColumn::make('name')->label('Customer Name'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('delivery_option')->label('Delivery Option'),
                Tables\Columns\TextColumn::make('total'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\BooleanColumn::make('is_completed')->label('Completed')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('Complete')->label('Complete')
                        ->action(function ($record){
                            $record->update(['is_completed' => true]);
                            Notification::make()
                               ->success()
                               ->title('Order Completed')
                               ->body('The Order has been marked as completed')
                               ->send();
                        })
                        ->requiresConfirmation()
                        ->color('success')
                        ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('Cancelled')->label('Cancelled')
                        ->action(function ($record){
                            $record->update(['is_completed' => false]);
                            Notification::make()
                               ->danger()
                               ->title('Order Cancelled')
                               ->body('The Order has been marked as Cancelled')
                               ->send();
                        })
                        ->requiresConfirmation()
                        ->color('danger')
                        ->icon('heroicon-o-x-mark'),
            ])
            ->headerActions([
                ExportAction::make()->exporter(OrderExporter::class),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
