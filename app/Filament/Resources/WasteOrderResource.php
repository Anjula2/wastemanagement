<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WasteOrderResource\Pages;
use App\Filament\Resources\WasteOrderResource\RelationManagers;
use App\Models\WasteOrder;
use App\Models\User;
use App\Models\SellableWaste;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Notifications\Notifiable;

class WasteOrderResource extends Resource
{
    protected static ?string $model = WasteOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Select::make('user_id')
                ->label('User')
                ->options(User::all()->pluck('name', 'id')) 
                ->required()
                ->searchable(),
            Forms\Components\Select::make('waste_type')
                ->label('Waste Type')
                ->options(SellableWaste::all()->pluck('waste_type', 'waste_type_id'))
                ->required()
                ->searchable()
                ->default(fn ($record) => $record?->waste_type)
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $sellableWaste = SellableWaste::where('waste_type_id', $state)->first();
                    if ($sellableWaste) {
                        $set('waste_type', $sellableWaste->waste_type);
                        $set('waste_type_id', $sellableWaste->waste_type_id);  
                        $set('price_per_ton', $sellableWaste->price);
                    }
                }
            ),

            Forms\Components\Hidden::make('waste_type_id')
                ->required()
                ->reactive(),


            Forms\Components\TextInput::make('company_name')
                ->label('Company Name')
                ->required(),
                
            Forms\Components\TextInput::make('address')
                ->label('Address')
                ->required(),
                
            Forms\Components\TextInput::make('contact_number')
                ->label('Contact Number')
                ->tel()
                ->required(),
            Forms\Components\TextInput::make('quantity')
                ->label('Quantity')
                ->numeric()
                ->required()
                ->reactive() 
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $pricePerTon = $get('price_per_ton');
                      if ($pricePerTon && $state) {
                    $totalPrice = $state * $pricePerTon;
                    $set('total_price', $totalPrice);
                }
            }),

            Forms\Components\TextInput::make('price_per_ton')
            ->required()
            ->reactive(), 

            Forms\Components\TextInput::make('total_price')
            ->required()
            ->reactive()
                ->afterStateUpdated(function (callable $get, callable $set) {
                    $quantity = $get('quantity');
                    $pricePerTon = $get('price_per_ton');
            if ($quantity && $pricePerTon) {
                $totalPrice = $quantity * $pricePerTon;
                $set('total_price', $totalPrice);
            }
        }),
            
            ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                ->label('User')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('waste_type')
                ->label('Waste Type')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('company_name')
                ->label('Company Name')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('address')
                ->label('Address')
                ->sortable(),

            Tables\Columns\TextColumn::make('contact_number')
                ->label('Contact Number'),

            Tables\Columns\BadgeColumn::make('quantity')
                ->label('Quantity')
                ->sortable()
                ->color('success'),

            Tables\Columns\TextColumn::make('price_per_ton')
                ->label('Price per Ton')
                ->sortable(),

            Tables\Columns\TextColumn::make('total_price')
                ->label('Total Price')
                ->sortable(),
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
            'index' => Pages\ListWasteOrders::route('/'),
            'create' => Pages\CreateWasteOrder::route('/create'),
            'edit' => Pages\EditWasteOrder::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
    
}
