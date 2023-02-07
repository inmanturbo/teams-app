<x-jet-form-section submit="updateUserType">
    <x-slot name="title">
        {{ __('User Type') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The User\'s type.') }}
    </x-slot>

    <x-slot name="form">

        <!-- Team Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label class="w-12 mt-4 mr-2" for="type" value="{{ __('Type') }}" />


            <x-select id="user_type" class="block w-full mt-1" wire:model="state.user_type">

                @foreach(\App\Models\UserType::cases() as $type)
                <option value="{{ $type->value }}">{{ $type->name }}</option>
                @endforeach

            </x-select>

            <x-jet-input-error for="state.user_type" class="w-full mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>

</x-jet-form-section>
