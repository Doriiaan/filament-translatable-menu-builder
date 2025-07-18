<?php

declare(strict_types=1);

namespace Doriiaan\FilamentTranslatableMenuBuilder\Livewire;

use Doriiaan\FilamentTranslatableMenuBuilder\Concerns\ManagesMenuItemHierarchy;
use Doriiaan\FilamentTranslatableMenuBuilder\FilamentTranslatableMenuBuilderPlugin;
use Doriiaan\FilamentTranslatableMenuBuilder\Models\Menu;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Component as FormComponent;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class MenuItems extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    use ManagesMenuItemHierarchy;

    public Menu $menu;

    public string $locale;

    protected Collection $indexed;

    public function mount(Menu $menu, string $locale): void
    {
        $this->menu = $menu;
        $this->locale = $locale;
    }

    #[Computed]
    #[On('menu:created')]
    public function menuItems(): Collection
    {
        return $this->menu->translate($this->locale)->menuItems()->get()->keyBy('id');
    }

    public function booted()
    {
        $this->indexed = FilamentTranslatableMenuBuilderPlugin::get()
            ->getMenuItemModel()::query()
            ->where('menu_translation_id', $this->menu->translate($this->locale)->id)
            ->with('linkable')
            ->orderBy('order')
            ->get()
            ->keyBy('id');
    }

    public function reorder(array $order, ?string $parentId = null): void
    {
        $this->getMenuItemService()->updateOrder($order, $parentId);
    }

    public function reorderAction(): Action
    {
        return Action::make('reorder')
            ->label(__('filament-forms::components.builder.actions.reorder.label'))
            ->icon(FilamentIcon::resolve('forms::components.builder.actions.reorder') ?? 'heroicon-m-arrows-up-down')
            ->color('gray')
            ->iconButton()
            ->extraAttributes(['data-sortable-handle' => true, 'class' => 'cursor-move'])
            ->livewireClickHandlerEnabled(false)
            ->size(ActionSize::Small);
    }

    public function indent(int $itemId): void
    {
        $item = $this->indexed->get($itemId);

        if (! $item) {
            return;
        }

        $previousSibling = FilamentTranslatableMenuBuilderPlugin::get()->getMenuItemModel()::query()
            ->where('menu_translation_id', $item->menu_translation_id)
            ->where('parent_id', $item->parent_id)
            ->where('order', '<', $item->order)
            ->orderByDesc('order')
            ->first();

        if (! $previousSibling) {
            return;
        }

        $maxOrder = FilamentTranslatableMenuBuilderPlugin::get()->getMenuItemModel()::query()
            ->where('parent_id', $previousSibling->id)
            ->max('order') ?? 0;

        $item->update([
            'parent_id' => $previousSibling->id,
            'order' => $maxOrder + 1,
        ]);

        $this->reorderSiblings($item->getOriginal('parent_id'));
    }

    public function unindent(int $itemId): void
    {
        $item = $this->indexed->get($itemId);

        if (! $item || ! $item->parent_id) {
            return;
        }

        $parent      = $item->parent;
        $grandParent = $parent->parent;

        $targetOrder = $parent->order + 1;

        FilamentTranslatableMenuBuilderPlugin::get()->getMenuItemModel()::query()
            ->where('menu_translation_id', $item->menu_translation_id)
            ->where('parent_id', $grandParent?->id)
            ->where('order', '>=', $targetOrder)
            ->increment('order');

        $item->update([
            'parent_id' => $grandParent?->id,
            'order'     => $targetOrder,
        ]);

        $this->reorderSiblings($parent->id);

        $this->indexed->put($item->id, $item->fresh());
    }

    private function reorderSiblings(?int $parentId): void
    {
        $siblings = FilamentTranslatableMenuBuilderPlugin::get()->getMenuItemModel()::query()
            ->where('parent_id', $parentId)
            ->orderBy('order')
            ->get();

        $siblings->each(function ($sibling, $index) {
            $sibling->update(['order' => $index + 1]);
        });
    }

    public function indentAction(): Action
    {
        return Action::make('indent')
            ->label(__('filament-translatable-menu-builder::menu-builder.actions.indent'))
            ->icon('heroicon-o-arrow-right')
            ->color('gray')
            ->iconButton()
            ->size(ActionSize::Small)
            ->action(fn (array $arguments) => $this->indent($arguments['id']))
            ->visible(
                fn (array $arguments): bool => FilamentTranslatableMenuBuilderPlugin::get()->isIndentActionsEnabled() &&
                    $this->canIndent($arguments['id']),
            );
    }

    public function unindentAction(): Action
    {
        return Action::make('unindent')
            ->label(__('filament-translatable-menu-builder::menu-builder.actions.unindent'))
            ->icon('heroicon-o-arrow-left')
            ->color('gray')
            ->iconButton()
            ->size(ActionSize::Small)
            ->action(fn (array $arguments) => $this->unindent($arguments['id']))
            ->visible(
                fn (array $arguments): bool => FilamentTranslatableMenuBuilderPlugin::get()->isIndentActionsEnabled() &&
                    $this->canUnindent($arguments['id']),
            );
    }

    public function canIndent(int $itemId): bool
    {
        $item = $this->indexed->get($itemId);

        if (! $item) {
            return false;
        }

        return $this->indexed
            ->where('parent_id', $item->parent_id)
            ->where('order', '<', $item->order)
            ->isNotEmpty();
    }

    public function canUnindent(int $itemId): bool
    {
        return ($this->indexed[$itemId]->parent_id ?? null) !== null;
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->label(__('filament-actions::edit.single.label'))
            ->iconButton()
            ->size(ActionSize::Small)
            ->modalHeading(fn (array $arguments): string => __('filament-actions::edit.single.modal.heading', ['label' => $arguments['title']]))
            ->icon('heroicon-m-pencil-square')
            ->fillForm(fn (array $arguments): array => $this->getMenuItemService()->findByIdWithRelations($arguments['id'])->toArray())
            ->form($this->getEditFormSchema())
            ->action(fn (array $data, array $arguments) => $this->getMenuItemService()->update($arguments['id'], $data))
            ->modalWidth(MaxWidth::Medium)
            ->slideOver();
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->label(__('filament-actions::delete.single.label'))
            ->color('danger')
            ->groupedIcon(FilamentIcon::resolve('actions::delete-action.grouped') ?? 'heroicon-m-trash')
            ->icon('heroicon-s-trash')
            ->iconButton()
            ->size(ActionSize::Small)
            ->requiresConfirmation()
            ->modalHeading(fn (array $arguments): string => __('filament-actions::delete.single.modal.heading', ['label' => $arguments['title']]))
            ->modalSubmitActionLabel(__('filament-actions::delete.single.modal.actions.delete.label'))
            ->modalIcon(FilamentIcon::resolve('actions::delete-action.modal') ?? 'heroicon-o-trash')
            ->action(function (array $arguments): void {
                $this->getMenuItemService()->delete($arguments['id']);
            });
    }

    public function render(): View
    {
        return view('filament-translatable-menu-builder::livewire.menu-items');
    }

    protected function getEditFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label(__('filament-translatable-menu-builder::menu-builder.form.title'))
                ->required(),
            TextInput::make('url')
                ->hidden(fn (?string $state, Get $get): bool => blank($state) || filled($get('linkable_type')))
                ->label(__('filament-translatable-menu-builder::menu-builder.form.url'))
                ->required(),
            Placeholder::make('linkable_type')
                ->label(__('filament-translatable-menu-builder::menu-builder.form.linkable_type'))
                ->hidden(fn (?string $state): bool => blank($state))
                ->content(fn (string $state) => $state),
            Placeholder::make('linkable_id')
                ->label(__('filament-translatable-menu-builder::menu-builder.form.linkable_id'))
                ->hidden(fn (?string $state): bool => blank($state))
                ->content(fn (string $state) => $state),
            Group::make()
                ->visible(fn (FormComponent $component) => $component->evaluate(FilamentTranslatableMenuBuilderPlugin::get()->getMenuItemFields()) !== [])
                ->schema(FilamentTranslatableMenuBuilderPlugin::get()->getMenuItemFields()),
        ];
    }
}
