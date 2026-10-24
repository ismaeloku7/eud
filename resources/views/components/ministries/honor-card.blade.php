@props(['honor', 'color' => null])
<div class="honor-block mb-6 w-1/5 px-3 desktop_medium:w-1/3 mobile:w-1/2 mobile-small:w-full">
    <div class="h-full cursor-pointer overflow-hidden rounded-xl border-solid bg-white px-4 pb-6 pt-0 text-center" style="border-color: {{ $color }}" wire:click="showHonor({{ $honor->id }})">
        @if ($honor->classHonor && $honor->classHonor->name !== 'Not required')
            <span class="mb-6 inline-block bg-grey_300 px-5 py-3 text-xs font-black">{{ $honor->classHonor->name }}</span>
        @endif
        <br>
        <img class="mb-8 inline-block" src="{{ \App\Support\Media::url($honor->image) }}" alt="{{ $honor->name }}">
        <h6 class="mb-0 text-primary"><strong>{{ $honor->name }}</strong></h6>
    </div>
</div>
