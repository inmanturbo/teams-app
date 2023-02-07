<div style="height: 300px;" class="w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
    <aside class="flex flex-col flex-shrink-0 w-48">
    <nav class="flex flex-col flex-1 bg-white border-r border-gray-100">
    <x-accordian-dropdown value="navigation-menu">

        <x-sidebar-link href="#">
            <x-icon-label icon="fas fa-home" label="Home" />
        </x-sidebar-link>
    </x-accordian-dropdown>
    </nav>
    </aside>
    @json($state ?? [])
</div>
