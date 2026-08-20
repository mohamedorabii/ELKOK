<?php

namespace App\Filament\Resources\Sizes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SizeForm
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

            Toggle::make('status')
                ->label('Active')
                ->default(true),
        ]);
    }
}