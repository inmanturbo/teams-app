<x-jet-confirmation-modal wire:model="confirmingLinkDeletion">
    <x-slot name="title">
        {{ __('Delete Bookmark') }}
    </x-slot>

    <x-slot name="content">
        {{ __('Are you sure you want to delete this link?') }}
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('confirmingLinkDeletion')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-3" wire:click="deleteLink" wire:loading.attr="disabled">
            {{ __('Delete') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-confirmation-modal>
