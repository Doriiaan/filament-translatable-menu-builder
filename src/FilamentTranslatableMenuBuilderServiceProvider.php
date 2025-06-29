<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder;

use Doriiaan\FilamentTranslatableMenuBuilder\Livewire\MenuTranslationPanel;
use Doriiaan\FilamentTranslatableMenuBuilder\Livewire\CreateCustomLink;
use Doriiaan\FilamentTranslatableMenuBuilder\Livewire\CreateCustomText;
use Doriiaan\FilamentTranslatableMenuBuilder\Livewire\MenuItems;
use Doriiaan\FilamentTranslatableMenuBuilder\Livewire\MenuPanel;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTranslatableMenuBuilderServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-translatable-menu-builder';

    public static string $viewNamespace = 'filament-translatable-menu-builder';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('doriiaan/filament-translatable-menu-builder');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName(),
        );

        Livewire::component('menu-builder-items', MenuItems::class);
        Livewire::component('menu-builder-panel', MenuPanel::class);
        Livewire::component('create-custom-link', CreateCustomLink::class);
        Livewire::component('create-custom-text', CreateCustomText::class);
        Livewire::component('menu-translation-panel', MenuTranslationPanel::class);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'doriiaan/filament-translatable-menu-builder';
    }

    protected function getAssets(): array
    {
        return [
            AlpineComponent::make('filament-translatable-menu-builder', __DIR__ . '/../resources/dist/filament-translatable-menu-builder.js'),
            Css::make('filament-translatable-menu-builder-styles', __DIR__ . '/../resources/dist/filament-translatable-menu-builder.css'),
        ];
    }

    protected function getMigrations(): array
    {
        return [
            'create_menus_table',
        ];
    }
}
