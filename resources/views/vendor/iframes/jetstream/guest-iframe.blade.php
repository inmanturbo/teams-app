<x-guest-layout>
    @if(!empty($_GET))

        <div class="w-full h-screen frameHolder">
            <iframe
                name='mainFrame'
                id="mainFrame"
                class="w-full h-screen mainFrame"
                frameborder="0"
                noresize='noresize'
                scrolling='none'
                src="{{ $iframeSource . '?' . http_build_query($_GET) }}"
                class="mainFrame">
            </iframe>
        </div>
    @else

        <div class="w-screen h-screen overflow-hidden frameHolder">
            <iframe
                name='mainFrame'
                id="mainFrame"
                style="width: 100%; height:100vh; overflow:hidden"
                {{-- class="w-full h-screen mainFrame"
                frameborder="0"
                noresize='noresize'
                scrolling="none" --}}
                src="{{ $iframeSource }}"
                class="mainFrame">
            </iframe>
        </div>

    @endif
</x-guest-layout>
