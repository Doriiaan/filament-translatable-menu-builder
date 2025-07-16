<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder\Resources\MenuResource\Pages;

use Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMenus extends ListRecords
{
    public static function getResource(): string
    {
        return FilamentTranslatableMenuBuilderPlugin::get()->getResource();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->after(function ($record) {
                    $record->translateOrNew();
                }),
        ];
    }
}
