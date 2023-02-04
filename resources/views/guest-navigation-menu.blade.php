<nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="/">
                        <x-application-logo class="block w-auto h-9" />
                    </a>
                </div>
            </div>

            <div class="relative ml-3">
                @if (Route::has('login'))

                @auth
                <div class="inline-flex flex-row items-center">

                    <a href="{{ url('/dashboard') }}"
                        class="p-2 text-sm text-gray-700 underline dark:text-gray-500">Dashboard</a>

                    <form method="POST" class="inline-flex" action="{{ route('logout') }}" x-data>
                        @csrf

                        <a href="{{ route('logout') }}" class="p-2 text-sm text-gray-700 underline dark:text-gray-500"
                            @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
                @else
                @if (request()->route()->getName() !== 'login')
                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline dark:text-gray-500">Login</a>
                @endif

                @if (Route::has('register') && request()->route()->getName() !== 'register')
                <a href="{{ route('register') }}"
                    class="ml-4 text-sm text-gray-700 underline dark:text-gray-500">Register</a>
                @endif
                @endauth

                @endif

            </div>
        </div>
    </div>
</nav>
