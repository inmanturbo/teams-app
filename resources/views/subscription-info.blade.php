<x-jet-form-section submit="subscribeByPromoCode">
    <x-slot name="title">
        {{ __('Subscription Details') }}
    </x-slot>

    <x-slot name="description">
        @if(auth()->user()->onTrial())
            {{ __('You are currently on a trial. Your trial ends in ') }} {{ auth()->user()->trial_ends_at->diffForHumans() }}, {{ __(' at which point you may subcribe again with a valid promo code.') }}
        @endif
    </x-slot>

    <x-slot name="form">

        @if(auth()->user()->type !== \App\Models\UserType::User)

        <p>
            You are not required to subscribe to use this application.
        </p>

        @else

        <!-- Team Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="subscription-type" value="{{ __('Subscription Type') }}" />

            <x-jet-input :value="auth()->user()->subscribed('default') ? 'Default' : 'Trial'" id="subscription-type"
                        type="text"
                        class="block w-full mt-1"
                        readonly
                         />
        </div>
        
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="subscription-end" value="{{ __('Expiration Date') }}" />

            <x-jet-input :value="auth()->user()->subscribed('default') ? auth()->user()->subscription('default')->asStripeSubscription()->current_period_end->format('m-d-Y') : auth()->user()->trialEndsAt()->format('m-d-Y')" id="subscription-type"
                        type="text"
                        class="block w-full mt-1"
                        readonly
                         />
        </div>
        @endif
    </x-slot>

    <x-slot name="actions">
    </x-slot>
</x-jet-form-section>
