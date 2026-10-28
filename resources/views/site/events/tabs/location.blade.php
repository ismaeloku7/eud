<div class="container-md">
    <h2 class="text-center uppercase mb-12 title-theme-900-space theme-text-black--important">{{ $event->location_title ?: __('events.tabs.location') }}</h2>
    @php($map = $event->location_url ?: ($event->lat && $event->long ? "https://maps.google.com/maps?q={$event->lat},{$event->long}&z=14&output=embed" : null))
    <div class="flex flex-wrap pt-24 -mx-16 desktop:-mx-7 m-0-auto">
        <div class="{{ $map ? 'w-1/2 tablet:w-full' : 'w-full' }} mobile:mb-8 px-0 desktop:px-7 mobile:px-0 location-info theme-text-black--important a-href-theme table-theme theme_content_description">
            @if ($event->location)
                <h4 class="theme-color-title mb-4"><b>{{ $event->location }}</b></h4>
            @endif
            {!! $event->location_description !!}
        </div>
        @if ($map)
            <div class="w-1/2 tablet:w-full px-14 desktop:px-7 tablet:px-0">
                @if (\Illuminate\Support\Str::contains($map, ['maps.google', 'google.com/maps', 'openstreetmap', 'embed']))
                    <iframe src="{{ $map }}" style="width: 100%; border: 0;" height="500" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="{{ __('events.tabs.location') }}"></iframe>
                @else
                    <a class="btn hover:bg-primary hover:text-white" href="{{ $map }}" target="_blank" rel="noopener">{{ __('events.tabs.location') }}</a>
                @endif
            </div>
        @endif
    </div>
    @php($photos = collect($event->location_images ?? [])->filter(fn ($photo) => filled($photo['image'] ?? null)))
    @if ($photos->isNotEmpty())
        <div id="location-photos-{{ $event->id }}" data-lightbox class="flex flex-wrap -mx-3 pt-16 mobile:pt-8">
            @foreach ($photos as $photo)
                @php($caption = \App\Pages\Translate::resolve($photo['caption'] ?? null))
                <a class="w-1/3 px-3 mb-6 tablet:w-1/2 mobile:w-full" href="{{ \App\Support\Media::url($photo['image']) }}" title="{{ $caption }}" wire:key="location-photo-{{ $loop->index }}">
                    <img src="{{ \App\Support\Media::url($photo['image']) }}" class="w-full rounded-xl" style="height: 240px; object-fit: cover;" alt="{{ $caption ?: $event->location }}" loading="lazy">
                    @if ($caption !== '')
                        <span class="block mt-2 text-center theme-text-black--important">{{ $caption }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
    @include('site.events.tabs.partials.blocks', ['blocks' => $event->location_recursive ?? []])
</div>
