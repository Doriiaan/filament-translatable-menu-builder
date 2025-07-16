<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Doriiaan\FilamentTranslatableMenuBuilder\Models\MenuItem[] $menuItems
 * @property-read int|null $menuItems_count
 */
class Menu extends Model implements TranslatableContract
{
    use Translatable;

    public $timestamps = false;

    protected $guarded = [];

    public $translatedAttributes = ['created_at', 'updated_at'];

    /**
     * @internal will change to protected
     */
    public function getTranslationModelName(): string
    {
        return FilamentTranslatableMenuBuilderPlugin::get()->getMenuTranslationModel();
    }

    public function getTable(): string
    {
        return config('filament-translatable-menu-builder.tables.menus', parent::getTable());
    }
}
