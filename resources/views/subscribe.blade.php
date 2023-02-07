<x-guest-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Subscribe') }}
        </h2>
    </x-slot>

    <div>
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

            @if($onTrial = auth()->user()->onTrial() && auth()->user()->trialEndsAt()->isToday())
                <div class="px-4 py-2 font-bold text-white bg-red-500 rounded-t">
                    Trial Ending Today.
                </div>
                <div class="px-4 py-2 text-red-700 bg-red-100 border border-t-0 border-red-400 rounded-b">
                    <p>Your trial ends today. Please enter your promo code to continue using the application.</p>
                </div>

                <x-jet-section-border />
            @elseif($trialEndsAt = auth()->user()->trial_ends_at && auth()->user()->trial_ends_at->isPast())
                <div class="px-4 py-2 font-bold text-white bg-red-500 rounded-t">
                    Trial Expired.
                </div>
                <div class="px-4 py-2 text-red-700 bg-red-100 border border-t-0 border-red-400 rounded-b">
                    <p>Your trial has expired. Please enter your promo code to continue using the application.</p>
                </div>

                <x-jet-section-border />
            @endif

            @if(auth()->user()->subscribed('default') || $onTrial)
                
                @include('subscription-info')

                <x-jet-section-border />

            @endif
                @if(config('services.stripe.key') && config('services.stripe.secret'))
                    @include('credit-card-form')
                    
                    <x-jet-section-border />
                @endif

                @livewire('enter-promo-code-form')
        </div>
    </div>
</x-guest-layout>
