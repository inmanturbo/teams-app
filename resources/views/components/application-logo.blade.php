@if(App\Charter::currentTeam())

    <img {{ $attributes }} src="{{ App\Charter::currentTeam()->profile_photo_url }}" alt="{{ App\Charter::currentTeam()->name }}" />

@else
  <x-jet-application-logo {{ $attributes }} />
@endif
