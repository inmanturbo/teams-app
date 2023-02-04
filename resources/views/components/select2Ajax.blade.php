<select {{$attributes->merge(['class' => 'js-basic-select-'.$type]) }}>
        {{$slot}}
    </select>
      @push('after_scripts')
      <script src="/qwoffice/js/select2/dist/js/select2.min.js"></script>
      @endpush
@isset($url)
<script>
// A $( document ).ready() block.
$( document ).ready(function() {
    console.log( "ready!" );
    $('.js-basic-select-{{$type}}').select2({
        ajax:{
            dataType:"json",
            url:"{!!$url!!}"
        },
        placeholder: "{{$placeholder??"Type to search ..."}}"
        @isset($select2Options)
        ,{!! $select2Options !!}
        @endisset
    });
});
</script>
@else
<script>
$( document ).ready(function() {
    console.log( "ready!" );
    $('.js-basic-select-{{$type}}').select2({
        ajax:{
            dataType:"json",
            url:"/select/{{$type}}"},
        placeholder: "{{$placeholder??"Type to search ..."}}"
        @isset($select2Options)
            ,{!! $select2Options !!}
        @endisset
        });
});
</script>
@endisset

