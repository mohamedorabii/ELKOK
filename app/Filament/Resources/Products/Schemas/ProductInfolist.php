<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name_en'),
                TextEntry::make('name_ar'),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('code'),
                ImageEntry::make('image')
                    ->label('Image')
                    ->disk('public')                  
                    ->default('products/default.png'),
                TextEntry::make('stock_quantity')
                    ->label('Available Stock')
                    ->numeric(),
                TextEntry::make('desc_en')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('desc_ar')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('status')
                    ->numeric(),
                TextEntry::make('category_id')
                    ->numeric(),
                TextEntry::make('brand_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
