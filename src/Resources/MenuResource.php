<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder\Resources;

use Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin;
use Filament\Forms\Components;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class MenuResource extends Resource
{
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

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Components\Grid::make(4)
                    ->schema([
                        Components\TextInput::make('name')
                            ->label(__('filament-translatable-menu-builder::menu-builder.resource.name.label'))
                            ->required()
                            ->columnSpan(2),
                    ]),

                Components\Group::make()
                    ->visible(fn (Component $component) => $component->evaluate(FilamentTranslatableMenuBuilderPlugin::get()->getMenuFields()) !== [])
                    ->schema(FilamentTranslatableMenuBuilderPlugin::get()->getMenuFields()),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament-translatable-menu-builder::menu-builder.resource.name.label')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => MenuResource\Pages\ListMenus::route('/'),
            'edit' => MenuResource\Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
