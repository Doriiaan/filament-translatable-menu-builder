<x-filament-panels::page @class([
    'fi-resource-edit-record-page',
    'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
    'fi-resource-record-' . $this->getRecord()->getKey(),
])>
    <x-filament::section>
        {{ $this->content }}
    </x-filament::section>

    <livewire:menu-translation-panel
        :record="$this->getRecord()"
        :wire:key="'menu-translation-panel-' . $this->getRecord()->getKey()"
    />
        
</x-filament-panels::page>
