<div class="container-md">
    <div class="flex flex-wrap -mx-12 desktop:-mx-7">
        <div class="w-1/2 px-12 desktop_medium:w-full tablet:mb-16 desktop:px-7 desktop_medium:mb-30 grey-paraghaph">
            <h2 class="mb-2"><strong>{{ $event->title }}</strong></h2>
            @if ($event->subtitle)
                <h6 class="mb-6"><strong>{!! $event->subtitle !!}</strong></h6>
            @endif
            <div class="theme_content_description">{!! $event->description !!}</div>

            @if ($event->downloads->isNotEmpty())
                <h5 class="uppercase text-primary mt-11 desktop_medium:mt-10"><strong>{{ __('events.downloads') }}</strong></h5>
                <div class="flex items-center mb-18 download-document mobile:flex-wrap mobile:mb-11">
                    <div style="font-size: 18px;">
                        @foreach ($event->downloads as $download)
                            <div style="margin-top: 10px; margin-bottom: 10px;" wire:key="download-{{ $download->id }}">
                                {{ $download->name }}
                                @if ($download->language)
                                    <span class="text-light_grey">({{ strtoupper($download->language) }})</span>
                                @endif
                                &ensp;
                                <a class="mr-3 btn hover:bg-primary hover:text-white mobile:mb-2" href="{{ \App\Support\Media::url($download->document) }}" target="_blank" rel="noopener" download>{{ __('events.download') }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="w-1/2 px-12 desktop_medium:w-full desktop:px-7">
            @if ($event->image_about)
                <div class="relative mb-20 desktop_medium:mb-32 video-poster mobile:mb-12">
                    <img src="{{ \App\Support\Media::url($event->image_about) }}" style="height: 360px; width: 100%; object-fit: contain; margin: 0 auto;" alt="">
                </div>
            @endif
            @if ($embed = $this->youtubeEmbed($event->url_youtube))
                <div class="relative mb-20 desktop_medium:mb-32 video-poster mobile:mb-12">
                    <iframe src="{{ $embed }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen height="360" style="width: 100%;"></iframe>
                </div>
            @endif
            @if ($event->quote)
                <blockquote class="ml-0"><h2>{!! $event->quote !!}</h2></blockquote>
            @endif
        </div>
    </div>
</div>
