<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(' order_info')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('order_number')
                                    ->label(" order_number"),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->colors([
                                        'primary' => 'pending',
                                        'info'    => 'shipped',
                                        'success' => 'delivered',
                                        'danger'  => 'cancelled',
                                    ]),
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ]),
                    ]),

                Section::make('Customer Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Name'),
                                TextEntry::make('phone')
                                    ->label('Phone'),
                                TextEntry::make('address')
                                    ->label('Address'),
                                TextEntry::make('city')
                                    ->label('City'),
                                TextEntry::make('governorate')
                                    ->label('Governorate'),
                            ]),
                    ]),

                Section::make('Products')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                TextEntry::make('product.name_en')
                                    ->label('Product'),
                                TextEntry::make('variant_label')
                                    ->label('Variant')
                                    ->placeholder('-'),
                                TextEntry::make('variant_sku')
                                    ->label('SKU')
                                    ->placeholder('-'),
                                TextEntry::make('quantity')
                                    ->label('Quantity'),
                                TextEntry::make('price')
                                    ->label('Price')
                                    ->money(),
                                TextEntry::make('total_price')
                                    ->label('Total')
                                    ->money(),
                            ])
                            ->columns(6),
                    ]),

                Section::make('Invoice')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('products_total')
                                    ->label('Products Total')
                                    ->money()
                                    ->getStateUsing(
                                        fn($record) => $record->items->sum('total_price')
                                    ),
                                TextEntry::make('shipping_price')
                                    ->label('Shipping Costs')
                                    ->money(),
                                TextEntry::make('total_price')
                                    ->label('Grand Total')
                                    ->money()
                                    ->weight('bold'),
                            ]),
                    ]),
            ]);
    }
}
