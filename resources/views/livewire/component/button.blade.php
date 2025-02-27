<div>
    <a x-on:click="$dispatch('open-side-modal{{$level}}', { componentName: '{{$component}}', params: { {{$params}} }, events:[] })" class="{{$classList}}">{{$text}}</a>
</div>
