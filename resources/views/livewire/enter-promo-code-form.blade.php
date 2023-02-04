<x-jet-form-section submit="subscribeByPromoCode">
    <x-slot name="title">
        {{ __('Subscribe by Promo Code') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Enter Your Promo Code to subscribe.') }}
    </x-slot>

    <x-slot name="form">

        <!-- Team Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="promo_code" value="{{ __('Promo Code') }}" />

            <x-jet-input id="promo_code"
                        type="text"
                        class="block w-full mt-1"
                        wire:model.defer="state.promo_code" />

            <x-jet-input-error for="state.promo_code" class="mt-2" />
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
