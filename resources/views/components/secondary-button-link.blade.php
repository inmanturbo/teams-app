<a {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-blue-500 uppercase transition bg-white border border-gray-300 rounded-md shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25']) }}>
    {{ $slot }}
</a>