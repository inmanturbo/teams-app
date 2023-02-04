<x-jet-form-section submit="updateTeamLandingPage">
    <x-slot name="title">
        {{ __('Team Landing Page') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Your Team\'s Landing Page. You may customize it by uploading an html file.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{pageName: null, pagePreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                @if(Gate::allows('update', $this->team))
                <input type="file" class="hidden"
                            wire:model="state.landing_page"
                            x-ref="page"
                            x-on:change="
                                    pageName = $refs.page.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        pagePreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.page.files[0]);
                            " />
                @endif

                <x-jet-label for="landing_page" value="{{ __('Landing Page') }}" />
                <div class="">

                    <!-- Current Profile Photo -->
                    <div class="mt-2" x-show="! pagePreview">
                        <iframe src="{{ $this->team->landing_page_url }}" alt="{{ $this->team->name }}" class="w-full h-screen"></iframe>
                    </div>
                    
                    <!-- New Profile Photo Preview -->
                    <div class="mt-2" x-show="pagePreview" style="display: none;">
                        <iframe class="w-100" :src="pagePreview">
                        </iframe>
                    </div>

                    {{-- <a class="inline-flex flex-row items-center px-2 space-x-1 text-xs text-blue-500 hover:text-indigo-700" target="_blank" href="{{ $this->team->url }}">
                        @svg('fas-arrow-up-right-from-square', 'h-5 w-5') <span>Visit</span>
                    </a> --}}
                </div>
                    
                <div class="flex items-center">

                    @if(Gate::check('update', $this->team))
                    <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.page.click()">
                        @svg('heroicon-o-upload', 'h-4 w-4') <span>{{ __('Replace') }}</span>
                    </x-jet-secondary-button>
                    
                    @endif
                    
                    @if ($this->team->team_data->landingPage())
                    <x-jet-secondary-button type="button" class="mt-2 mr-2" wire:click="downloadLandingPage" x-on:click="pagePreview=false" >
                        @svg('heroicon-o-download', 'h-4 w-4') <span>{{ __('Download') }}</span>
                    </x-jet-secondary-button>

                    <x-jet-secondary-button type="button" class="mt-2 mr-2" wire:click="deleteLandingPage" x-on:click="pagePreview=false" >
                        @svg('heroicon-o-trash', 'h-4 w-4 text-red-500')
                    </x-jet-secondary-button>
                    @endif
                    
                    <x-secondary-button-link class="mt-2 mr-2" target="_blank" href="/template">
                        @svg('heroicon-o-download', 'h-4 w-4') <span>Template</span>
                    </x-secondary-button-link>

                    <x-secondary-button-link class="mt-2" target="_blank" href="{{ $this->team->url }}">
                        @svg('fas-arrow-up-right-from-square', 'h-4 w-4') <span>Visit</span>
                    </x-secondary-button-link>
                </div>

                <x-jet-input-error for="landing_page" class="mt-2" />
            </div>
        @endif

    </x-slot>

    <x-slot name="actions">
        @if(Gate::check('update', $this->team))
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="page">
            {{ __('Save') }}
        </x-jet-button>
        @endif
    </x-slot>
</x-jet-form-section>
