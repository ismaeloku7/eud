@if ($events->isNotEmpty())
    <section class="event-section bg-secondary px-4 pb-24 pt-12 tablet:pb-18 mobile:px-6 mobile:pb-13">
        <div class="container-lg px-0">
            <h5 class="mb-12 text-center mobile:mb-6">{{ Str::upper($site->settings('navigation')->text('events', __('home.events'))) }}</h5>
            <div class="relative flex flex-wrap">
                @foreach ($events as $event)
                    <div class="events relative w-1/2 mobile:w-full">
                        <div class="event-image">
                            <img class="w-full" src="{{ App\Support\Media::url($event->photo_portada, 'images/event_v2.jpg') }}" alt="{{ $event->title }}">
                            <div class="absolute left-0 top-0 z-10 h-full w-full">
                                <h5>{{ $event->title }}</h5>
                                <div class="event-category">
                                    <ul>
                                        @if ($event->type)
                                            <li>{{ $event->type }}</li>
                                        @endif
                                        <li>{{ $event->date_start->translatedFormat('d M Y') }}</li>
                                    </ul>
                                </div>
                                <a class="white-circle-arrow" href="{{ route('events.show', ['slug' => $event->slug]) }}" aria-label="{{ $event->title }}">
                                    <img src="{{ asset('images/circle-arrow.png') }}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
