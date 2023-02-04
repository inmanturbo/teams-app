<div>
    <x-jet-form-section submit="updateTeam">
        <x-slot name="title">
            {{ __('Team Info') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The team\'s address and contact details that will be shown on invoices and other documents.') }}
        </x-slot>

        <x-slot name="form">

            <!-- Team Phone -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="phone" value="{{ __('Team Phone') }}" />

                <x-jet-input id="phone"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="state.phone"
                            :disabled="! Gate::check('update', $team)" />

                <x-jet-input-error for="phone" class="mt-2" />
            </div>

            <!-- Team Phone -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="fax" value="{{ __('Team Fax') }}" />

                <x-jet-input id="fax"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="state.fax"
                            :disabled="! Gate::check('update', $team)" />

                <x-jet-input-error for="fax" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="email" value="{{ __('Team Email') }}" />

                <x-jet-input id="email"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="state.email"
                            :disabled="! Gate::check('update', $team)" />

                <x-jet-input-error for="email" class="mt-2" />
            </div>

            <!-- Team Address -->

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="street" value="{{ __('Team Address Line One') }}" />

                <x-jet-input id="street"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="state.address.street"
                            :disabled="! Gate::check('update', $team)" />

                <x-jet-input-error for="street" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="lineTwo" value="{{ __('Team Address Line Two') }}" />

                <x-jet-input id="lineTwo"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="state.address.lineTwo"
                            :disabled="! Gate::check('update', $team)" />

                <x-jet-input-error for="lineTwo" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">

                <x-jet-label for="lineTwo" value="{{ __('Team City') }}" />

                <x-jet-input id="city"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="state.address.city"
                            :disabled="! Gate::check('update', $team)" />

                <x-jet-input-error for="city" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">

                <x-jet-label for="state" value="{{ __('Team State') }}" />

                <x-jet-input id="state"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="state.address.state"
                            :disabled="! Gate::check('update', $team)" />

                <x-jet-input-error for="state" class="mt-2" />

            </div>

            <div class="col-span-6 sm:col-span-4">

                <x-jet-label for="zip" value="{{ __('Team Zip') }}" />

                <x-jet-input id="zip"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="state.address.zip"
                            :disabled="! Gate::check('update', $team)" />

                <x-jet-input-error for="zip" class="mt-2" />

            </div>

            <div class="col-span-6 sm:col-span-4">

                <x-jet-label for="country" value="{{ __('Team Country') }}" />

                <x-jet-input id="country"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="state.address.country"
                            :disabled="! Gate::check('update', $team)" />

                <x-jet-input-error for="country" class="mt-2" />

            </div>


        </x-slot>

        @if (Gate::check('update', $team))
            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        @endif
    </x-jet-form-section>

</div>
