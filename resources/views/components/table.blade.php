@props([
    'id' => null
])
<div class="overflow-auto">
    <table class="mc-table-basic" id="{{$id}}">
        {{ $slot }}
    </table>
</div>
