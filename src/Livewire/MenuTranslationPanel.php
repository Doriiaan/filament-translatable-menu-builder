<?php

namespace Doriiaan\FilamentTranslatableMenuBuilder\Livewire;

use Doriiaan\FilamentTranslatableMenuBuilder\Models\Menu;
use CactusGalaxy\FilamentAstrotomic\Forms\Components\TranslatableTabs;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class MenuTranslationPanel extends Component implements HasForms
{
    use InteractsWithForms;

    public Menu $record;

    public function mount(Menu $record): void
    {
        $this->record = $record;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TranslatableTabs::make()
                    ->persistTab()
                    ->localeTabSchema(function (TranslatableTab $tab) {
                        /** @var string $locale */
                        $locale = $tab->getLocale();

                        return [
                            Actions::make([
                                Action::make("create-{$locale}")
                                    ->label(__('Create translation'))
                                    ->color('primary')
                                    ->hidden(fn () => $this->record->getTranslation($locale, false))
                                    ->requiresConfirmation()
                                    ->action(fn () => $this->createTranslation($locale)),

                                Action::make("delete-{$locale}")
                                    ->label(__('Delete translation'))
                                    ->color('danger')
                                    ->extraAttributes(['class' => 'ms-auto'])
                                    ->visible(fn () => $this->record->getTranslation($locale, false))
                                    ->requiresConfirmation()
                                    ->action(fn () => $this->deleteTranslation($locale)),
                            ])
                                ->columnSpanFull()
                                ->hidden($locale === app()->getLocale()),

                            Grid::make(4)
                                ->visible(fn () => $this->record->getTranslation($locale, false))
                                ->schema([
                                    Grid::make(1)
                                        ->columnSpan(1)
                                        ->schema([
                                            ViewField::make("section_builder_$locale")
                                                ->view('filament-translatable-menu-builder::menu-component')
                                                ->viewData([
                                                    'record' => $this->record,
                                                    'locale' => $locale,
                                                    'component' => 'section',
                                                ]),

                                            ViewField::make("section_builder_$locale")
                                                ->view('filament-translatable-menu-builder::menu-component')
                                                ->viewData([
                                                    'record' => $this->record,
                                                    'locale' => $locale,
                                                    'component' => 'model',
                                                ]),
                                        ]),

                                    Grid::make(3)
                                        ->columnSpan(3)
                                        ->schema([
                                            ViewField::make("section_builder_$locale")
                                                ->columnSpanFull()
                                                ->view('filament-translatable-menu-builder::menu-component')
                                                ->viewData([
                                                    'record' => $this->record,
                                                    'locale' => $locale,
                                                    'component' => 'tree',
                                                ]),
                                        ]),

                                ]),
                        ];
                    })
                    ->extraAttributes([
                        'style' => 'background-color: transparent !important; box-shadow: none !important; border: none !important;',
                    ]),
            ]);
    }

    public function createTranslation(string $locale): void
    {
        $this->record->getNewTranslation($locale)->save();

        $this->record->refresh();
        $this->dispatch('$refresh');
    }

    public function deleteTranslation(string $locale): void
    {
        $this->record->getTranslation($locale)->delete();

        $this->record->refresh();
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('filament-translatable-menu-builder::livewire.menu-translation-panel');
    }
}