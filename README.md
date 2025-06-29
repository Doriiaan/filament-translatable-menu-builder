# Filament Translatable Menu Builder

This Filament package allows you to create and manage translatable menus in your Filament application.

This package is a fork from [datlechin/filament-menu-builder](https://github.com/datlechin/filament-menu-builder) and integrates [Astrotomic/laravel-translatable](https://github.com/Astrotomic/laravel-translatable) for translations with [CactusGalaxy/FilamentAstrotomic](https://github.com/CactusGalaxy/FilamentAstrotomic) for translations tabs.

## Installation

You can install the package via composer:

```bash
composer require doriiaan/filament-translatable-menu-builder
```

You need to publish the migrations and run them:

```bash
php artisan vendor:publish --tag="filament-translatable-menu-builder-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-translatable-menu-builder-config"
```

Optionally, if you want to customize the views, you can publish them with:

```bash
php artisan vendor:publish --tag="filament-translatable-menu-builder-views"
```

This is the contents of the published config file:

```php
return [
    'tables' => [
        'menus' => 'menus',
        'menu_tarnslations' => 'menu_translations',
        'menu_items' => 'menu_items',
    ],
];
```

Add the plugin to `AdminPanelProvider`:

```php
use Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin;

$panel
    ...
    ->plugin(FilamentTranslatableMenuBuilderPlugin::make())
```

## Usage

If one day someone uses this package, I could fill in this section and make the package as customizable as: [datlechin/filament-menu-builder](https://github.com/datlechin/filament-menu-builder).

Custom links don't work.

## License

The MIT License (MIT). Please see [License File](https://github.com/doriiaan/filament-translatable-menu-builder/raw/main/LICENSE.md) for more information.
