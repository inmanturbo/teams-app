<x-jet-dialog-modal wire:model="creatingNewDatabase">
    <x-slot name="title">
        {{ __('Add Database') }}
    </x-slot>

    <x-slot name="content">
        <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
            <x-jet-label class="w-12 mt-4 mr-2" for="name" value="{{ __('Name') }}" />

            <div class="w-full col">

                <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model="state.name" {{--
                    :disabled="! Gate::check('update', $team)" --}} />

                <x-jet-input-error for="name" class="mt-2" />
            </div>
        </div>

    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('creatingNewDatabase', false)" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-3" wire:click="createDatabase" wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
