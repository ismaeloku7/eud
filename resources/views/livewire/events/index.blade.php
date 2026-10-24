<div x-data="{ list: false }">
    <div class="mb-6 pt-9 ressources-searchbar">
        <div class="container-xl">
            <div class="flex flex-wrap items-center justify-between mb-18 mobile:mb-8">
                <h2 class="mb-0">
                    <strong>{{ __('events.title') }}</strong>
                </h2>
                <div class="flex items-center search-bar">
                    <div class="search-field">
                        <input type="search" placeholder="{{ __('events.search') }}" wire:model.live.debounce.400ms="search" aria-label="{{ __('events.search') }}">
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap items-center justify-between filter-bar">
                <div class="flex items-center sort-by">
                    <p>{{ __('events.sort') }}</p>
                    <select wire:model.live="sort" class="cursor-pointer" aria-label="{{ __('events.sort') }}">
                        <option value="">{{ __('events.ascending') }}</option>
                        <option value="desc">{{ __('events.descending') }}</option>
                    </select>
                    @if ($search !== '' || $sort !== '')
                        <a class="clear-filter" href="javascript:void(0);" wire:click="resetFilters">{{ __('events.clean_filters') }}</a>
                    @endif
                </div>
                <div class="flex items-center view mobile:hidden">
                    <p>{{ __('events.design') }}</p>
                    <ul class="flex items-center">
                        <li class="grid-view" :class="{ active: !list }">
                            <a href="javascript:void(0);" @click="list = false">
                                <img class="normal-view" src="{{ asset('images/grid-view.svg') }}" alt="">
                                <img class="active-view" src="{{ asset('images/grid-view-active.svg') }}" alt="">
                            </a>
                        </li>
                        <li class="list-view" :class="{ active: list }">
                            <a href="javascript:void(0);" @click="list = true">
                                <img class="normal-view" src="{{ asset('images/list-view.svg') }}" alt="">
                                <img class="active-view" src="{{ asset('images/list-view-active.svg') }}" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="event-section event-section-wrapper pb-44" :class="{ 'list-view-format': list }">
        <div class="container-xl">
            <div class="relative flex flex-wrap -mx-3">
                @forelse ($events as $event)
                    @php($url = route('events.show', ['slug' => $event->slug]))
                    <div class="relative w-1/4 px-3 mb-6 events-block mobile:w-full cursor-pointer" wire:key="event-{{ $event->id }}" onclick="window.location.href = '{{ $url }}'">
                        <div class="events full-rounded">
                            <div class="event-image">
                                <img src="{{ \App\Support\Media::url($event->photo_portada, 'images/event_v2.jpg') }}" alt="{{ $event->title }}" style="height: 350px">
                                <div class="absolute top-0 left-0 z-10 w-full h-full">
                                    <h5>{{ $event->title }}</h5>
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
                                    <a class="white-circle-arrow" href="{{ $url }}" aria-label="{{ $event->title }}">
                                        <img src="{{ asset('images/circle-arrow.png') }}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="flex items-center justify-between list-view-block">
                                <h2>{{ $event->title }}</h2>
                                <h5>{{ $event->subtitle }}</h5>
                                <div>{!! $event->description !!}</div>
                                <div class="flex items-center ressources-feachers">
                                    <div>
                                        <img src="{{ asset('images/calender-ic.png') }}" alt="">
                                        <p>{{ $event->date_start->format('d.m.Y') }} - {{ $event->date_end->format('d.m.Y') }}</p>
                                    </div>
                                    @if ($event->location)
                                        <div>
                                            <img src="{{ asset('images/map-ic.png') }}" alt="">
                                            <p>{{ $event->location }}</p>
                                        </div>
                                    @endif
                                    @if ($event->speakers->isNotEmpty())
                                        <div>
                                            <img src="{{ asset('images/user-ic.png') }}" alt="">
                                            <p>{{ $event->speakers->map(fn ($speaker) => $speaker->name)->join(', ') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="w-full px-3 text-center text-primary">{{ __('events.none') }}</p>
                @endforelse
            </div>
            <div class="mt-8">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</div>
