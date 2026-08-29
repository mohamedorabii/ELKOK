<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_en')
                    ->required(),
                TextInput::make('name_ar')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->minValue(1)
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('code')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn('edit'),
                FileUpload::make('image')
                    ->label('Product Image')
                    ->disk('public')
                    ->directory('products')
                    ->image()
                    ->default('products/default.png')
                    ->required(),
                Repeater::make('images')
                    ->relationship()
                    ->label('Gallery Images')
                    ->defaultItems(0)
                    ->schema([
                        FileUpload::make('image')
                            ->label('Image')
                            ->disk('public')
                            ->directory('products/gallery')
                            ->image()
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columnSpanFull(),
                Textarea::make('desc_en')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('desc_ar')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->live()
                    ->helperText(function (Get $get) {
                        $variants = collect($get('variants') ?? []);
                        $total = $variants->sum(fn($v) => (int) ($v['stock'] ?? 0));
                        return $total > 0 ? "مجموع الستوك الحالي في الفاريانتس: {$total}" : null;
                    }),
                Select::make('status')
                    ->label('Status')
                    ->required()
                    ->options([
                        1 => 'Active',
                        0 => 'Not Active',
                    ]),
                Select::make('subcategory_id')
                    ->label('Subcategory')
                    ->relationship('subcategory', 'name_en')
                    ->default(null),
                Select::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'name_en')
                    ->default(null),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name_en')
                    ->required(),
                Repeater::make('variants')
                    ->relationship()
                    ->label('Variants')
                    ->defaultItems(0)
                    ->schema([
                        Select::make('color_id')
                            ->label('Color')
                            ->relationship('color', 'name_en')
                            ->searchable()
                            ->required(),
                        Select::make('size_id')
                            ->label('Size')
                            ->relationship('size', 'name_en')
                            ->searchable()
                            ->required(),
                        TextInput::make('stock')
                            ->label('Stock')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->required()
                            ->live(onBlur: true)
                            ->rule(function (Get $get) {
                                return function (string $attribute, $value, \Closure $fail) use ($get) {
                                    $quantity = (int) ($get('../../quantity') ?? 0);
                                    $variants = collect($get('../../variants') ?? []);
                                    $total    = $variants->sum(fn($v) => (int) ($v['stock'] ?? 0));

                                    if ($total > $quantity) {
                                        $fail("مجموع الستوك في كل الفاريانتس ({$total}) أكبر من الكمية الكلية المسموحة ({$quantity}).");
                                    }
                                };
                            }),
                        TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('$'),
                        TextInput::make('sku')
                            ->label('SKU')
                            ->disabled()
                            ->dehydrated(false)
                            ->visibleOn('edit'),
                    ])
                    ->columnSpanFull()
            ]);
    }
}
