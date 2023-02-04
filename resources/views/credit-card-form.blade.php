<x-jet-form-section submit="Save">
    <x-slot name="title">
        {{ __('Subscribe by Credit Card') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Enter Credit card details to purchase a new subscription.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            <x-jet-label value="{{ __('Card Holder Name') }}" />

            <div class="flex items-center mt-2">
                <x-jet-input class="border-none" placeholder="Jane Doe" id="card-holder-name" type="text" />
            </div>

            <div class="mt-2" >
                Credit Card Info
            </div>
            <div class="mt-2">

                <div class="w-1/2" id="card-element"></div>

            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button disabled id="card-button" data-secret="{{ Auth::user()->createSetupIntent() }}">
            {{ __('Update Payment Method') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('{{ config('services.stripe.key') }}');

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');
</script>
@endpush
