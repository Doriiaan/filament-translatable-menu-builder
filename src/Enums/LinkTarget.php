<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder\Enums;

use Filament\Support\Contracts\HasLabel;

enum LinkTarget: string implements HasLabel
{
    case Self = '_self';

    case Blank = '_blank';

    case Parent = '_parent';

    case Top = '_top';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Self => __('filament-translatable-menu-builder::menu-builder.open_in.options.self'),
            self::Blank => __('filament-translatable-menu-builder::menu-builder.open_in.options.blank'),
            self::Parent => __('filament-translatable-menu-builder::menu-builder.open_in.options.parent'),
            self::Top => __('filament-translatable-menu-builder::menu-builder.open_in.options.top'),
        };
    }
}
