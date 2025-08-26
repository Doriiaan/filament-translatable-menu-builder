<div class="fi-ta-empty-state">
    <div class="fi-ta-empty-state-content">
        <div class="fi-ta-empty-state-icon-bg">
            @if ($icon instanceof \BladeUI\Icons\Svg)
                {!! $icon->toHtml() !!}
            @else
                <x-filament::icon
                    :icon="$icon ?? 'heroicon-o-link-slash'"
                    :size="\Filament\Support\Enums\IconSize::Large"
                />
            @endif
        </div>

        <h3 class="fi-ta-empty-state-heading">
            {{ $heading ?? __('No items yet') }}
        </h3>

        @if(!empty($description))
            <p class="fi-ta-empty-state-description">{{ $description }}</p>
        @endif

        @isset($actions)
            <div class="fi-ta-actions fi-align-center fi-wrapped">
                {{ $actions }}
            </div>
        @endisset
    </div>
</div>