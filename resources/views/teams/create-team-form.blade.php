<x-jet-form-section submit="createTeam">
    <x-slot name="title">
        {{ __('Team Details') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create a new team to collaborate with others on projects.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            <x-jet-label value="{{ __('Team Owner') }}" />

            <div class="flex items-center mt-2">
                <img class="object-cover w-12 h-12 rounded-full" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}">

                <div class="ml-4 leading-tight">
                    <div>{{ $this->user->name }}</div>
                    <div class="text-sm text-gray-700">{{ $this->user->email }}</div>
                </div>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="team_database_id" value="{{ __('Database') }}" />
            <div class="inline-flex flex-row items-center w-full space-x-2">
                <x-select id="team_database_id" class="block w-full mt-1" wire:model.defer="state.team_database_uuid">

                    <option value="" >Select a database</option>
                    @foreach(auth()->user()->teamDatabases as $database)
                        <option value="{{ $database->uuid }}">{{ $database->name }}</option>
                    @endforeach

                </x-select>
                <x-jet-nav-link wire:click="$emit('showCreateDatabaseModal')" class="w-1/3 cursor-pointer">
                   {{ __('Add Database') }}
                </x-jet-nav-link>
            </div>
            <x-jet-input-error for="team_database_uuid" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Team Name') }}" />
            <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="state.name" autofocus />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>

