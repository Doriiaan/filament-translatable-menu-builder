<div>
    @if($this->menuItems->isNotEmpty())
        <ul
            ax-load
            ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-translatable-menu-builder', 'doriiaan/filament-translatable-menu-builder') }}"
            x-data="menuBuilder({ parentId: 0 })"
            class="space-y-2"
        >
            @foreach($this->menuItems as $menuItem)
                <x-filament-translatable-menu-builder::menu-item
                    :item="$menuItem"
                />
            @endforeach
        </ul>
    @else
        <x-filament-tables::empty-state
            icon="heroicon-o-document"
            :heading="trans('filament-translatable-menu-builder::menu-builder.items.empty.heading')"
        />
    @endif

    <x-filament-actions::modals />
</div>
