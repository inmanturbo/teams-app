<x-guest-layout>

    @if(session()->has('url.intended') && Str::contains(session('url.intended'), 'team-invitations') )
    @php
        $invitationId = explode( '?' ,Str::after(session('url.intended'), 'team-invitations/'))[0];
        $teamInvitation = \App\Models\TeamInvitation::query()->whereUuid($invitationId)->first();
        $teamName = $teamInvitation->team->name ?? null;
    @endphp

   
    <x-slot name="header">
        <div class="grid place-items-center">
            <h1 class="text-lg">
                Log in or <a class="underline hover:text-gray-900" href="{{ route('register') }}">register</a>
                to join <strong class="text-blue-800">{{ $teamName }}</strong>.
            </h1>
        </div>
    </x-slot>

    @endif
    
    <x-jet-authentication-card>

        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-full h-auto"/>
            </a>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif
      
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-between block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>

            <div class="flex items-center justify-center mt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="block mt-4 text-center">
                <span class="ml-2 text-sm text-gray-600">{{ __('New around here?') }}</span>
                <a class="underline hover:text-gray-900" href="{{ route('register') }}">Sign Up!</a>
            </div>
        </form>

        @if (JoelButcher\Socialstream\Socialstream::show())
            <x-socialstream />
        @endif
    </x-jet-authentication-card>
</x-guest-layout>
