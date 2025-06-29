<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder\Livewire;

use Doriiaan\FilamentTranslatableMenuBuilder\Models\Menu;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreateCustomText extends Component implements HasForms
{
    use InteractsWithForms;

    public Menu $menu;

    public string $locale;

    public string $title = '';

    public function mount(Menu $menu, string $locale): void
    {
        $this->menu = $menu;
        $this->locale = $locale;
    }

    public function save(): void
    {
        $this->validate([
            'title' => ['required', 'string'],
        ]);

        $this->menu
            ->translate($this->locale)
            ->menuItems()
            ->create([
                'title' => $this->title,
                'order' => $this->menu->translate($this->locale)->menuItems->max('order') + 1,
            ]);

        Notification::make()
            ->title(__('filament-translatable-menu-builder::menu-builder.notifications.created.title'))
            ->success()
            ->send();

        $this->reset('title');
        $this->dispatch('menu:created');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('filament-translatable-menu-builder::menu-builder.form.title'))
                    ->required(),
            ]);
    }

    public function render(): View
    {
        return view('filament-translatable-menu-builder::livewire.create-custom-text');
    }
}
