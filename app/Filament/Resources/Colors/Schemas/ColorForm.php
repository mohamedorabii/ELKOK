<?php

namespace App\Filament\Resources\Colors\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ColorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name_en')
                ->label('Name (English)')
                ->required()
                ->maxLength(255),

            TextInput::make('name_ar')
                ->label('Name (Arabic)')
                ->maxLength(255),

            ColorPicker::make('hex_code')
                ->label('Color'),

            Toggle::make('status')
                ->label('Active')
                ->default(true),
        ]);
    }
}