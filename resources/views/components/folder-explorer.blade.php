<div x-data="{ open: false }">
    <button @click="open = !open" wire:click="$set('state.label', document.getElementById('{{$value}}').innerText)"
        class="flex items-center w-full px-2 py-3 text-gray-600 cursor-pointer @if(isset($this->state['label']) && $this->state['label'] == $value)   @endif justify-left hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path x-show="!open" d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                <path x-show="open" fill-rule="evenodd" d="M2 6a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1H8a3 3 0 00-3 3v1.5a1.5 1.5 0 01-3 0V6z" clip-rule="evenodd" />
                <path x-show="open" d="M6 12a2 2 0 012-2h8a2 2 0 012 2v2a2 2 0 01-2 2H2h2a2 2 0 002-2v-2z" />
            </svg>
        </span>
        <span id="{{$value}}" class="flex items-center selector">
            @isset($value)
                {{ $value }}
            @endisset
        </span>
    </button>
    <div x-cloak x-show="open" class="ml-4">
        {{ $slot ?? '' }}
    </div>
</div>
