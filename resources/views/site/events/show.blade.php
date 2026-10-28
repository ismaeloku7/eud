<x-layouts.site :title="$event->title" :description="\Illuminate\Support\Str::limit(strip_tags((string) $event->description), 160)">
    <div class="mb-4 pt-9 ressources-searchbar">
        <div class="container-xl">
            <div class="flex flex-wrap items-center justify-between mb-18 tablet:mb-14 mobile:mb-8">
                <h2 class="mb-0 tablet:w-full tablet:mb-7">
                    <strong>
                        <span>
                            <a href="{{ route('events.index') }}">{{ __('events.title') }}</a>
                            <span>/</span>
                        </span>
                        {{ $event->title }}
                    </strong>
                </h2>
                <div class="flex items-center mobile-small:flex-wrap pro-share tablet:w-full">
                    <div class="post-navigation back-to-overview mobile-small:w-full mobile-small:mt-4">
                        <ul>
                            <li>
                                <a href="{{ route('events.index') }}">
                                    <img src="{{ asset('images/blue-prev-arrow.png') }}" alt="">
                                    {{ __('events.back') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="resources-detail-wrapper">
        <div class="container-xl">
            <div class="flex flex-wrap mb-24 overflow-hidden desktop_medium:mb-8 rounded-xl">
                <div class="w-1/2 tablet:w-full row-container-image-event">
                    <div class="relative h-full single-image tablet:mb-0 single-image-round">
                        <img class="object-contain object-center w-full" style="height: 600px;background-color: whitesmoke;" src="{{ \App\Support\Media::url($event->photo_portada, 'images/event_v2.jpg') }}" alt="{{ $event->title }}">
                        @php($tags = array_values(array_filter(array_map('trim', explode(',', (string) $event->tags)))))
                        @if ($tags !== [])
                            <div class="event-category fix-list-ul">
                                <ul>
                                    @foreach ($tags as $tag)
                                        <li><div>{{ $tag }}</div></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="w-1/2 tablet:w-full">
                    <div class="h-full px-20 pt-10 pb-6 desktop_large:px-10 bg-medium_blue/20">
                        <div class="mb-16 desktop_large:mb-11 mobile:mb-8">
                            <h2 class="mb-0 text-4xl mobile:text-5xl text-medium_blue">
                                <strong>{{ $event->date_start->format('d.m.Y') }} - {{ $event->date_end->format('d.m.Y') }}</strong>
                            </h2>
                            <span class="block text-xl font-black text-medium_blue">{{ __('events.date') }}</span>
                        </div>
                        @php($mainSpeakers = $event->mainSpeakers())
                        @if ($mainSpeakers->isNotEmpty())
                            <div class="mb-16 desktop_large:mb-11 mobile:mb-8">
                                <h2 class="mb-0 text-4xl mobile:text-5xl text-medium_blue">
                                    <strong>{{ $mainSpeakers->map(fn ($speaker) => $speaker->name)->join(', ') }}</strong>
                                </h2>
                                <span class="block text-xl font-black text-medium_blue">{{ __('events.main_speakers') }}</span>
                            </div>
                        @endif
                        @if ($event->location)
                            <div class="mb-16 desktop_large:mb-11 mobile:mb-8">
                                <h2 class="mb-0 text-4xl mobile:text-5xl text-medium_blue">
                                    <strong>{{ $event->location }}</strong>
                                </h2>
                                <span class="block text-xl font-black text-medium_blue">{{ __('events.location') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:events.detail :event="$event" />
</x-layouts.site>
