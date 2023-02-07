<div x-data="{openFolder : false} ">
    <div class="inline-flex flex-row w-full text-gray-600">
        <button @click="openFolder = !openFolder"
            class="flex items-center float-right w-full py-3 text-gray-600 cursor-pointer justify-left hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
            @isset($icon)
            {{ $icon }}
            @else
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path x-show="!openFolder"
                        d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                    <path x-show="openFolder" fill-rule="evenodd"
                        d="M2 6a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1H8a3 3 0 00-3 3v1.5a1.5 1.5 0 01-3 0V6z"
                        clip-rule="evenodd" />
                    <path x-show="openFolder" d="M6 12a2 2 0 012-2h8a2 2 0 012 2v2a2 2 0 01-2 2H2h2a2 2 0 002-2v-2z" />
                </svg>
            </span>
            @endisset
            <span class="flex items-center selector">
                {{ $header ?? '' }}
            </span>
    </div>
    </button>
    <div x-show="openFolder">
        {{ $slot ?? '' }}
    </div>
</div>
