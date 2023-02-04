
@if(isset($row->glMaster->id))

    <a wire:click="$emit('manageGlMaster', '{{$row->glMaster->id}}')" href="#" class="text-blue-600 underline hover:text-blue-800 visited:text-purple-600">
        {{ $value }}
    </a>
@else

<a wire:click="$emit('manageGlMaster', '{{$row->id}}')" href="#" class="text-blue-600 underline hover:text-blue-800 visited:text-purple-600">
    {{ $value }}
</a>
@endif