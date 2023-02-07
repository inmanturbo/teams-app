@if(App\Charter::currentTeam())

<img class="block w-auto rounded-full h-9" src="{{ App\Charter::currentTeam()->profile_photo_url }}"
    alt="{{ App\Charter::currentTeam()->name }}" />

@else

<x-jet-application-logo {{ $attributes }} />

@endif
