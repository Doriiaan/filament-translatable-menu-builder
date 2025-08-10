<?php

namespace Doriiaan\FilamentTranslatableMenuBuilder\Resources\Menu\Schemas;

use Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make(4)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament-translatable-menu-builder::menu-builder.resource.name.label'))
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Group::make()
                    ->visible(fn () => FilamentTranslatableMenuBuilderPlugin::get()->getMenuFields() !== [])
                    ->schema(FilamentTranslatableMenuBuilderPlugin::get()->getMenuFields()),
            ]);
    }
}
