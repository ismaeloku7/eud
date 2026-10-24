<div>
    <div class="container-md">
        <div class="flex items-center justify-between tablet:flex-wrap mb-14 mobile:mb-7">
            <h2 class="mb-0 tablet:w-full tablet:mb-3 mobile:mb-8 text-center"><strong>{{ $event->gallery_title ?: __('events.tabs.gallery') }}</strong></h2>
        </div>
    </div>
    <div class="container-lg">
        @if ($event->galleries->isNotEmpty())
            <div id="gallery-{{ $event->id }}" data-lightbox class="flex flex-wrap -mx-3 mb-10">
                @foreach ($event->galleries as $photo)
                    <a class="w-1/4 px-3 mb-6 desktop:w-1/3 mobile:w-full" href="{{ \App\Support\Media::url($photo->image) }}" title="{{ $event->title }} {{ $loop->iteration }}" wire:key="photo-{{ $photo->id }}">
                        <img src="{{ \App\Support\Media::url($photo->image) }}" class="gallery-img w-full" style="height: 225px; object-fit: cover;" alt="{{ $event->title }} {{ $loop->iteration }}">
                    </a>
                @endforeach
            </div>
        @endif
        @if ($event->url_gallery)
            <iframe src="{{ $event->url_gallery }}" style="width: 100%; height: 100vh; margin-bottom: 50px;" frameborder="0" title="{{ __('events.tabs.gallery') }}"></iframe>
        @endif
        @if ($embed = $this->youtubeEmbed($event->url_video))
            <iframe src="{{ $embed }}" style="width: 100%; height: 500px; margin-top: 20px;" frameborder="0" allowfullscreen title="{{ __('events.tabs.gallery') }}"></iframe>
            @if ($event->playlist_video)
                <div class="text-center w-full" style="margin-top: 15px; margin-bottom: 15px;">
                    <a class="btn hover:bg-primary hover:text-white mobile:mb-2" target="_blank" rel="noopener" href="{{ $event->playlist_video }}">{{ __('events.go_to_youtube') }}</a>
                </div>
            @endif
        @endif
    </div>
</div>
