<x-jet-confirmation-modal wire:model="confirmingMark">
    <x-slot name="title">
        @if($this->active)
            {{ __('Mark as Inactive') }}
        @else
            {{ __('Mark as Active') }}
        @endif
    </x-slot>

    <x-slot name="content">
        @if($this->active)
            {{ __('Are you sure you want to mark this link as inactive?') }}
        @else
            {{ __('Are you sure you want to mark this link as active?') }}
        @endif
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('confirmingMark')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-3" wire:click="markLink" wire:loading.attr="disabled">
            @if($this->active)
                {{ __('Deactivate') }}
            @else
                {{ __('Activate') }}
            @endif
        </x-jet-danger-button>
    </x-slot>
</x-jet-confirmation-modal>
