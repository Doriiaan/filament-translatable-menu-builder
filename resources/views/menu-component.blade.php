<div>
@if ($component === 'section')
    <livewire:create-custom-text
        :menu="$record"
        :locale="$locale"
        wire:key="section-builder-{{ $record->id }}-{{ $locale }}"
    />
@elseif($component === 'model')
    <div class="grid grid-cols-1 gap-6">
    @foreach (\Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin::get()->getMenuPanels() as $menuPanel)
        <livewire:menu-builder-panel
            :menu="$record"
            :menuPanel="$menuPanel"
            :locale="$locale"
            wire:key="model-builder-{{ $record->id }}-{{ $locale }}-{{ $menuPanel::class }}"
        />
    @endforeach
    </div>
@elseif($component === 'tree')
    <livewire:menu-builder-items
        :menu="$record"
        :locale="$locale"
        wire:key="tree-{{ $record->id }}-{{ $locale }}"
    />
@endif
</div>
