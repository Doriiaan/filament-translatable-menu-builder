# Filament Translatable Menu Builder

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
        'menu_tarnslations' => 'menu_tarnslations',
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

## License

The MIT License (MIT). Please see [License File](https://github.com/doriiaan/filament-translatable-menu-builder/raw/main/LICENSE.md) for more information.
