<x-jet-dialog-modal wire:model="editingLink">
    <x-slot name="title">
        {{ __('Add Bookmark') }}
    </x-slot>

    <x-slot name="content">
        <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
            <x-jet-label class="w-12 mt-4 mr-2" for="Label" value="{{ __('Name') }}" />

            <x-jet-input id="label" type="text" class="block w-full mt-1" wire:model="state.label" {{--
                :disabled="! Gate::check('update', $team)" --}} />

            <x-jet-input-error for="label" class="mt-2" />
        </div>

        <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
            <x-jet-label class="w-12 mt-4 mr-2" for="url" value="{{ __('URL  ') }}" />

            <x-jet-input id="url" type="text" class="w-full mt-1" wire:model.defer="state.url" {{--
                :disabled="! Gate::check('update', $team)" --}} />

            <x-jet-input-error for="url" class="w-full mt-2" />
        </div>

        <div x-data="{open : true} ">
            <div class="inline-flex flex-row justify-end">
                <button @click="open = !open"
                    class="flex items-center float-right w-full py-3 text-gray-600 cursor-pointer justify-left hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                    <span>
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path x-cloak x-show="! open" d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" style="display: none;"></path>
                            <path x-cloak x-show="open" d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <span class="flex items-center selector">
                        {{__('Advanced')}}
                    </span>
            </div>
            </button>
            <div x-show="open">

                <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
                    <x-jet-label class="w-12 mt-4 mr-2" for="type" value="{{ __('Active') }}" />

                    {{-- @json($state) --}}
                    <x-select id="type" class="block w-full mt-1" wire:model="state.active">
                        <option value="true">Yes</option>
                        <option value="false">No</option>
                    </x-select>

                    <x-jet-input-error for="active" class="w-full mt-2" />
                </div>

                <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
                    <x-jet-label class="w-12 mt-4 mr-2" for="type" value="{{ __('Type') }}" />


                    <x-select id="type" class="block w-full mt-1" wire:model="state.type">

                        @foreach(\App\Models\LinkType::cases() as $type)
                        @if($type->value !== \App\Models\LinkType::Link->value)')
                        <option value="{{ $type->value }}">{{ $type->prettyName() }}</option>
                        @endif
                        @endforeach

                    </x-select>

                    <x-jet-input-error for="type" class="w-full mt-2" />
                </div>

                <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
                    <x-jet-label class="w-12 mt-4 mr-2" for="Target" value="{{ __('Target') }}" />

                    <x-select id="target" class="block w-full mt-1" wire:model.defer="state.target">

                        @foreach(\App\Models\LinkTarget::cases() as $target)
                        <option value="{{ $target->value }}">{{ $target->name }}</option>
                        @endforeach

                    </x-select>

                    <x-jet-input-error for="description" class="w-full mt-2" />
                </div>

                <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
                    <x-jet-label class="w-12 mt-4 mr-2" for="description" value="{{ __('Title') }}" />

                    <x-vanilla-textarea id="title" class="block w-full mt-1" wire:model.defer="state.title" {{--
                        :disabled="! Gate::check('update', $team)" --}} />

                    <x-jet-input-error for="title" class="w-full mt-2" />
                </div>

                <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
                    <x-jet-label class="w-12 mt-4 mr-2" for="role" value="{{ __('Role') }}" />

                    <x-select id="role" class="block w-full mt-1" wire:model.defer="state.role">

                        @foreach(config('roles') as $role => $options)
                        <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach

                    </x-select>

                    <x-jet-input-error for="role" class="w-full mt-2" />
                </div>

                <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
                    <x-jet-label class="w-12 mt-4 mr-2" for="View" value="{{ __('Menu') }}" />

                    <x-select id="view" class="block w-full mt-1" wire:model.defer="state.view">

                        @foreach(\App\Models\LinkMenu::cases() as $view)
                        <option value="{{ $view->value }}">{{ $view->prettyName() }}</option>
                        @endforeach

                    </x-select>

                    <x-jet-input-error for="view" class="w-full mt-2" />
                </div>

                <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
                    <x-jet-label class="w-12 mt-4 mr-2" for="order_column" value="{{ __('Sort') }}" />

                    <x-select id="view" class="block w-full mt-1" wire:model.defer="state.order_column">

                        @php $linkIndex = 1; @endphp
                        @foreach(\App\Models\Link::ordered()->get() as $link)
                        @if(Gate::allows('view', $link))
                        <option value="{{ $link->order_column }}">{{ $linkIndex }}</option>
                        @php $linkIndex++; @endphp
                        @endif
                        @endforeach

                    </x-select>

                    <x-jet-input-error for="order_column" class="w-full mt-2" />
                </div>

                <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
                    <x-jet-label class="w-12 mt-4 mr-2" for="icon" value="{{ __('Icon') }}" />

                    <x-jet-input id="icon" type="text" class="block w-full mt-1"
                        wire:model.defer="state.icon" {{-- :disabled="! Gate::check('update', $team)" --}} />

                    <x-jet-input-error for="icon" class="mt-2" />
                </div>

                <div class="inline-flex flex-row justify-between w-full sm:col-span-4">

                    <x-form-help-text class="w-full mt-2">
                      Need help finding an Icon? go <a class="underline" href="{{ route('internal-iframe', ['path' => route('blade-icons')]) }}" target="_blank">here</a>
                    </x-form-help-text>
                </div>
            </div>
        </div>

    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('editingLink', false)" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-3" wire:click="updateLink" wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
