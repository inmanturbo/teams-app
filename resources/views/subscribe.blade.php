<x-guest-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Subscribe') }}
        </h2>
    </x-slot>

    <div>
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

            @include('credit-card-form')

            <x-jet-section-border />

            @livewire('enter-promo-code-form')

            <x-jet-section-border />
        </div>
    </div>
</x-guest-layout>
