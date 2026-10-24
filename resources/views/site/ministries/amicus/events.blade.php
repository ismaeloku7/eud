@php($events = \App\Models\Event::query()->published()->orderByDesc('date_start')->take(12)->get())
<div class="pt-16 pb-16">
    <div class="container mobile:px-6">
        <h2 class="mb-12 text-center"><strong>{{ __('amicus.events_title') }}</strong></h2>
        @if ($events->isEmpty())
            <p class="text-center text-light_grey">{{ __('amicus.no_events') }}</p>
        @else
            <div class="flex flex-wrap -mx-4">
                @foreach ($events as $event)
                    <div class="w-1/3 px-4 mb-9 tablet:w-1/2 mobile:w-full">
                        <div class="amicus-event overflow-hidden rounded-xl h-full">
                            <a href="{{ route('events.show', ['slug' => $event->slug]) }}">
                                <div class="amicus-event-image relative">
                                    <img class="w-full" src="{{ \App\Support\Media::url($event->photo_portada, 'images/event_v2.jpg') }}" alt="{{ $event->title }}">
                                    <div class="amicus-event-title absolute right-0 top-0 z-10 flex h-full w-full items-end bg-opacity-60">
                                        <h5 class="relative font-bold tracking-normal text-white">{{ $event->title }}</h5>
                                    </div>
                                </div>
                            </a>
                            <div class="py-4">
                                <p class="mb-2 text-light_grey">{{ $event->date_start->translatedFormat('d M Y') }} – {{ $event->date_end->translatedFormat('d M Y') }}@if ($event->location) · {{ $event->location }}@endif</p>
                                <a class="text-medium_blue hover:text-blue font-bold" href="{{ route('events.show', ['slug' => $event->slug]) }}">{{ __('amicus.see_event') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
