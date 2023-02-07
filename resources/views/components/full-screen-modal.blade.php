@props(['id' => null, 'maxWidth' => null])

<x-full-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="min-h-full px-6 py-4">
        <div class="text-lg">
            {{ $title }}
        </div>

        <div class="w-full h-screen frameHolder">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
        {{ $footer }}
    </div>
</x-full-modal>
