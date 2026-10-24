<div class="container-md">
    <h2 class="text-center pb-28 m-0 title-theme-900-space theme-text-black--important">
        {{ $event->speaker_title ?: __('events.speakers_title') }}
    </h2>
    <div class="flex flex-wrap">
        @foreach ($this->speakers as $speaker)
            @php($description = strip_tags((string) $speaker->description))
            <div class="mobile:w-full tablet:w-1/2 w-1/3 pb-16 tablet:speaker-custom desktop:speaker-custom" wire:key="speaker-{{ $speaker->id }}">
                <div class="border pt-6 px-8 pb-12 border-width-3 mobile:mx-0 custom-mx {{ ['index-1', 'index-2', 'index-3'][$loop->index % 3] }}" style="height: 100%;">
                    @if ($speaker->photo)
                        <img src="{{ \App\Support\Media::url($speaker->photo) }}" wire:click="openSpeaker({{ $speaker->id }})" class="rounded-full my-4 mx-auto w-44 h-44 c-pointer hover:opacity-80" alt="{{ $speaker->name }}" style="object-fit: cover;">
                    @else
                        <div class="rounded-full my-4 mx-auto w-44 h-44 bg-secondary"></div>
                    @endif
                    <h3 class="text-center pt-2 mb-2 fw-bold theme-color-title">{{ $speaker->name }}</h3>
                    <h6 class="text-center mb-8 theme-color-subtitle">{{ $speaker->type }}</h6>
                    <div class="text-center theme-text-black--important">{{ \Illuminate\Support\Str::limit($description, 250) }}</div>
                    <span class="text-center text-medium_blue block text-xl cursor-pointer" wire:click="openSpeaker({{ $speaker->id }})">{{ __('events.see_more') }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
