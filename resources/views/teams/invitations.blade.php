<x-guest-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Join Team') }}
        </h2>
    </x-slot>

    <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
        <div class="py-10 mx-auto max-w-7xl">
            <div role="alert">
                <div class="px-4 py-2 font-bold text-white bg-indigo-500 rounded-t">
                    Joining an existing Team
                </div>
                <div class="px-4 py-2 text-indigo-700 bg-indigo-100 border border-t-0 border-indigo-400 rounded-b">
                    <p class="py-4 font-bold">Invited to join a team?</p>
                    <p>To join an existing team, click the "accept invitation" button in the team invitation mail.</p>

                    <p>Didn't get a team invitation mail? Ask a member of an existing team to invite you to their team.</p>

                    <p class="py-4">
                        Why not try  <a class="underline" href="{{ config('app.url') . route('teams.create', [], false) }}">creating</a> an team of your own?
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
