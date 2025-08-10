<?php

declare(strict_types=1);

use Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin;

it('can enable indent actions', function () {
    $plugin = FilamentTranslatableMenuBuilderPlugin::make()
        ->enableIndentActions();

    expect($plugin->isIndentActionsEnabled())->toBeTrue();
});

it('can disable indent actions', function () {
    $plugin = FilamentTranslatableMenuBuilderPlugin::make()
        ->enableIndentActions(false);

    expect($plugin->isIndentActionsEnabled())->toBeFalse();
});

it('has indent actions enabled by default', function () {
    $plugin = FilamentTranslatableMenuBuilderPlugin::make();

    expect($plugin->isIndentActionsEnabled())->toBeTrue();
});

it('can configure custom text panel', function () {
    $plugin = FilamentTranslatableMenuBuilderPlugin::make()
        ->showCustomTextPanel(true);

    expect($plugin->isShowCustomTextPanel())->toBeTrue();
});
