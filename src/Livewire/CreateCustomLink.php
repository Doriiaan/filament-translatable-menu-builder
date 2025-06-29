<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder\Livewire;

use Doriiaan\FilamentTranslatableMenuBuilder\Enums\LinkTarget;
use Doriiaan\FilamentTranslatableMenuBuilder\Models\Menu;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateCustomLink extends Component implements HasForms
{
    use InteractsWithForms;

    public Menu $menu;

    public string $title = '';

    public string $url = '';


    public function save(): void
    {
        $this->validate([
            'title' => ['required', 'string'],
            'url' => ['required', 'string'],
        ]);

        $this->menu
            ->menuItems()
            ->create([
                'title' => $this->title,
                'url' => $this->url,
                'order' => $this->menu->menuItems->max('order') + 1,
            ]);

        Notification::make()
            ->title(__('filament-translatable-menu-builder::menu-builder.notifications.created.title'))
            ->success()
            ->send();

        $this->reset('title', 'url');
        $this->dispatch('menu:created');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('filament-translatable-menu-builder::menu-builder.form.title'))
                    ->required(),
                TextInput::make('url')
                    ->label(__('filament-translatable-menu-builder::menu-builder.form.url'))
                    ->required(),
            ]);
    }

    public function render(): View
    {
        return view('filament-translatable-menu-builder::livewire.create-custom-link');
    }
}
