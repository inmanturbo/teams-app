<x-guest-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Subscribe') }}
        </h2>
    </x-slot>

    <div>
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

            @if(auth()->user()->subscribed('default') || auth()->user()->onTrial())
                
                @include('subscription-info')


                <x-jet-section-border />

            @endif
                @if(config('services.stripe.key') && config('services.stripe.secret'))
                    @include('credit-card-form')
                    
                    <x-jet-section-border />
                @endif

                @livewire('enter-promo-code-form')

                <x-jet-section-border />

        </div>
    </div>
</x-guest-layout>
