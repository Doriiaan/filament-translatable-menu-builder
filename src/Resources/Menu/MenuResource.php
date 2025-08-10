<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder\Resources\Menu;

use Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin;
use Doriiaan\FilamentTranslatableMenuBuilder\Models\Menu;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    public static function getModel(): string
    {
        return FilamentTranslatableMenuBuilderPlugin::get()->getMenuModel();
    }

    public static function getNavigationLabel(): string
    {
        return FilamentTranslatableMenuBuilderPlugin::get()->getNavigationLabel() ?? Str::title(static::getPluralModelLabel()) ?? Str::title(static::getModelLabel());
    }

    public static function getNavigationIcon(): string
    {
        return FilamentTranslatableMenuBuilderPlugin::get()->getNavigationIcon();
    }

    public static function getNavigationSort(): ?int
    {
        return FilamentTranslatableMenuBuilderPlugin::get()->getNavigationSort();
    }

    public static function getNavigationGroup(): ?string
    {
        return FilamentTranslatableMenuBuilderPlugin::get()->getNavigationGroup();
    }

    public static function getNavigationBadge(): ?string
    {
        return FilamentTranslatableMenuBuilderPlugin::get()->getNavigationCountBadge() ? number_format(static::getModel()::count()) : null;
    }

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return Schemas\MenuForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Tables\MenusTable::configure($table);
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
            'index' => Pages\ListMenus::route('/'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
