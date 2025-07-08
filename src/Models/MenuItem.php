<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder\Models;

use Doriiaan\FilamentTranslatableMenuBuilder\Contracts\MenuPanelable;
use Doriiaan\FilamentTranslatableMenuBuilder\Enums\LinkTarget;
use Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $menu_translation_id
 * @property int|null $parent_id
 * @property string $title
 * @property string|null $url
 * @property string|null $type
 * @property int $order
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|MenuItem[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Model|MenuPanelable|null $linkable
 * @property-read \Doriiaan\FilamentTranslatableMenuBuilder\Models\Menu $menu
 * @property-read \Doriiaan\FilamentTranslatableMenuBuilder\Models\MenuItem|null $parent
 */
class MenuItem extends Model
{
    protected $guarded = [];

    protected $with = ['linkable'];

    public function getTable(): string
    {
        return config('filament-translatable-menu-builder.tables.menu_items', parent::getTable());
    }

    protected function casts(): array
    {
        return [
            'order' => 'int',
        ];
    }

    protected static function booted(): void
    {
        static::deleted(function (self $menuItem) {
            $menuItem->children->each->delete();
        });
    }

    public function menuTranslation()
    {
        return $this->belongsTo(FilamentTranslatableMenuBuilderPlugin::get()->getMenuTranslationModel());
    }

    public function parent()
    {
        return $this->belongsTo(static::class);
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id')
            ->with('children')
            ->orderBy('order');
    }

    public function linkable()
    {
        return $this->morphTo();
    }

    protected function url(): Attribute
    {
        return Attribute::get(function (?string $value) {
            return match (true) {
                $this->linkable instanceof MenuPanelable => $this->linkable->getMenuPanelUrlUsing()($this->linkable),
                default => $value,
            };
        });
    }

    protected function type(): Attribute
    {
        return Attribute::get(function () {
            return match (true) {
                $this->linkable instanceof MenuPanelable => $this->linkable->getMenuPanelName(),
                is_null($this->linkable) && is_null($this->url) => __('filament-translatable-menu-builder::menu-builder.custom_text'),
                default => __('filament-translatable-menu-builder::menu-builder.custom_link'),
            };
        });
    }
}
