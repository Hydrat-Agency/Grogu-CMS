<x-filament-panels::page.simple>
    <form wire:submit="resetPassword" class="space-y-6">
        {{ $this->form }}

        <x-filament::actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </form>

    <x-filament-actions::modals />
</x-filament-panels::page.simple>
