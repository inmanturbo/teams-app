<div x-data="{openFolder : false} ">
    <div class="inline-flex flex-row w-full">
        <button @click="openFolder = !openFolder"
            class="flex items-center float-right w-full py-3 text-gray-600 cursor-pointer justify-left hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path x-show="!openFolder" stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    <path x-show="openFolder"  stroke-linecap="round" stroke-linejoin="round" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                </svg>
            </span>
            <span class="flex items-center">
                {{ $header ?? '' }}
            </span>
    </div>
    </button>
    <div x-show="openFolder">
        {{ $slot ?? '' }}
    </div>
</div>
