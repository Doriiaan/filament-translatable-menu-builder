<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder\Resources\Menu\Pages;

use Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMenu extends EditRecord
{
    protected string $view = 'filament-translatable-menu-builder::edit-record';

    public static function getResource(): string
    {
        return FilamentTranslatableMenuBuilderPlugin::get()->getResource();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
