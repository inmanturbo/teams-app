<x-buku-icons::layout title="Blade Icons">
    <div>
        <div class="px-4 mx-auto mt-16 max-w-screen-2xl sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <x-buku-icons::h3>
                    Search for an icon
                </x-buku-icons::h3>
                <x-buku-icons::p>
                    With {{ HeaderX\BukuIcons\Models\IconSet::count() }} different icon sets, we probably can find the right one for you.
                </x-buku-icons::p>
            </div>
        </div>

        <div id="search" class="relative flex items-center justify-between p-8 px-4 mx-auto mt-6 max-w-screen-2xl sm:mt-0 sm:px-6">
            <livewire:buku-icons::icon-search/>
        </div>
    </div>
    {{-- <x-buku-icons::footer/> --}}
</x-buku-icons::layout>
