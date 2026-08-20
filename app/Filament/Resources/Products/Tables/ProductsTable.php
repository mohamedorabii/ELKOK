<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_en')
                    ->searchable(),
                TextColumn::make('name_ar')
                    ->searchable(),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                TextColumn::make('code')
                    ->searchable(),
                 ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')                  
                    ->default('products/default.png'), 
                TextColumn::make('variants_count')
                    ->counts('variants')
                    ->label('Variants')
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label('Base Qty')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_quantity')
                    ->label('Available Stock')
                    ->numeric(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state == 1 ? 'Active' : 'Not Active')
                    ->badge()
                    ->color(fn($state) => $state == 1 ? 'success' : 'danger')
                    ->sortable(),
               TextColumn::make('category.name_en')
                    ->label('Category'),
                TextColumn::make('brand.name_en')
                    ->label('Brand'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
