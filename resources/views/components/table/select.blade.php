<div class="relative w-[105px] md:w-14 ed-form-select">
    <select {{$attributes->wire('model')}} class="ed-form-select-input dark:active:text-black peer">
        <option value="15" selected>15</option>
        <option value="30">30</option>
        <option value="60">60</option>
    </select>
    <span class="material-symbols-rounded absolute right-0 top-2 -z-[1] select-none text-gray-400">
        expand_more
    </span>
</div>
