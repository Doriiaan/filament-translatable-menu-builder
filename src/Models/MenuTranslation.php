<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder\Models;

use Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $locale
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Doriiaan\FilamentTranslatableMenuBuilder\Models\MenuItem[] $menuItems
 * @property-read int|null $menuItems_count
 */
class MenuTranslation extends Model
{
    protected $guarded = [];

    public function getTable(): string
    {
        return config('filament-translatable-menu-builder.tables.menu_translations', parent::getTable());
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(FilamentTranslatableMenuBuilderPlugin::get()->getMenuItemModel())
            ->whereNull('parent_id')
            ->orderBy('parent_id')
            ->orderBy('order')
            ->with('children');
    }
}
