<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Filament\Exports\ProductExporter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Notifications\Notifiable;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('category')
                ->required()
                ->label('Category')
                ->options([
                    'Bins' => 'Bins',
                    'Compost Bins' => 'Compost Bins',
                    'Compost & Fertilizer' => 'Compost & Fertilizer',
                    'Recyclables' => 'Recyclables',
                    'Waste Bags' => 'Waste Bags',
                ])
                ->default(fn ($record) => $record?->delivery_option),
                Forms\Components\Textarea::make('description'),
                Forms\Components\TextInput::make('price')->numeric()->required(),
                Forms\Components\TextInput::make('stock_level')->numeric()->required(),
                Forms\Components\FileUpload::make('image_path')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('category'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('stock_level'),
                Tables\Columns\ImageColumn::make('image_path')
                       ->label('Image')
                       ->size(50, 50)
                       ->url(fn ($record) => asset('storage/' . $record->image_path)),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(ProductExporter::class),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
