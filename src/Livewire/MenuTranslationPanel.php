<?php

namespace Doriiaan\FilamentTranslatableMenuBuilder\Livewire;

use Doriiaan\FilamentAstrotomic\Schemas\Components\TranslatableTabs;
use Doriiaan\FilamentAstrotomic\TranslatableTab;
use Doriiaan\FilamentTranslatableMenuBuilder\Models\Menu;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\View as ViewField;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;

class MenuTranslationPanel extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Menu $record;

    public function mount(Menu $record): void
    {
        $this->record = $record->loadMissing('translations');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                                    ->hidden(fn () => $this->record->translations->firstWhere('locale', $locale))
                                    ->requiresConfirmation()
                                    ->action(fn () => $this->createTranslation($locale)),

                                Action::make("delete-{$locale}")
                                    ->label(__('Delete translation'))
                                    ->color('danger')
                                    ->extraAttributes(['class' => 'ms-auto'])
                                    ->visible(fn () => $this->record->translations->firstWhere('locale', $locale))
                                    ->requiresConfirmation()
                                    ->action(fn () => $this->deleteTranslation($locale)),
                            ])
                                ->columnSpanFull()
                                ->hidden($locale === app()->getLocale()),

                            Grid::make(4)
                                ->visible(fn () => $this->record->translations->firstWhere('locale', $locale))
                                ->schema([
                                    Grid::make(1)
                                        ->columnSpan(1)
                                        ->schema([
                                            ViewField::make("section_builder_custom-text_$locale")
                                                ->view('filament-translatable-menu-builder::menu-component')
                                                ->viewData([
                                                    'record' => $this->record,
                                                    'locale' => $locale,
                                                    'component' => 'custom-text',
                                                ]),

                                            ViewField::make("section_builder_model_$locale")
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
                                            ViewField::make("section_builder_tree_$locale")
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
        $this->dispatch('menu-translation:create');
    }

    public function deleteTranslation(string $locale): void
    {
        $this->record->getTranslation($locale)->delete();

        $this->record->refresh();
        $this->dispatch('menu-translation:create');
    }

    public function render()
    {
        return view('filament-translatable-menu-builder::livewire.menu-translation-panel');
    }
}
