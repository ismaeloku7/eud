@php($groups = $this->workshopGroups)
<div class="container-md text-black">
    <h2 class="text-center mb-12 title-theme-900-space theme-text-black--important">{{ $event->workshop_title ?: __('events.tabs.workshops') }}</h2>
    @if ($event->workshop_description)
        <div class="theme-text-black--important theme_content_description" style="color: rgb(110, 110, 110);">{!! $event->workshop_description !!}</div>
        <br><br>
    @endif

    <div class="flex flex-wrap">
        <div class="w-1/2 mobile:w-full mobile:text-center mobile:pb-14">
            @if ($this->workshopLines->isNotEmpty())
                <select wire:model.live="workshopLine" aria-label="{{ __('events.select_track') }}"
                    class="rounded-full border border-medium_blue py-2 px-4 w-60 bg-transparent appearance-none h-10 self-center theme-color-subtitle fw-bold mobile:w-full"
                    style="background-image: url({{ asset('images/down-arrow-blue.svg') }}); background-size: 13px auto; background-position-x: calc(100% - 15px); background-position-y: center; background-repeat: no-repeat; padding-right: 40px; font-size: 18px; text-transform: capitalize; border-width: 2px; max-width: 400px;">
                    <option value="">{{ __('events.all') }}</option>
                    @foreach ($this->workshopLines as $line)
                        <option value="{{ $line->id }}">{{ $line->title }}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="w-1/2 mobile:w-full">
            @include('site.events.tabs.partials.day-switcher', ['items' => $groups, 'selected' => $workshopGroup, 'select' => 'selectWorkshopGroup'])
        </div>
    </div>

    <div class="flex flex-wrap custom-workshops mobile:mt-20">
        @foreach ($this->workshopsOfGroup as $workshop)
            <div class="w-1/2 mobile:w-full {{ $loop->index % 2 === 0 ? 'index-1' : 'index-2' }}" id="workshops-{{ $workshop->id }}" wire:key="workshop-{{ $workshop->id }}">
                <div class="pr-40 tablet:pr-0 mobile:pr-0 pt-28 {{ $loop->first ? 'mobile:pt-0' : 'mobile:pt-20' }}">
                    @if ($workshop->line)
                        <span class="text-medium_blue block mb-6" @if ($workshop->line->color) style="color: {{ $workshop->line->color }} !important;" @endif>
                            <b style="text-transform: capitalize;">{{ $workshop->line->title }}</b>
                        </span>
                    @endif
                    <div style="display: inline-block;">
                        @forelse ($workshop->speakers as $speaker)
                            @if ($speaker->photo)
                                <img src="{{ \App\Support\Media::url($speaker->photo) }}" alt="{{ $speaker->name }}" class="{{ $workshop->speakers->count() > 2 ? 'w-24 h-24' : 'w-32 h-32' }} rounded-full my-4 bg-secondary" style="object-fit: cover; display: inline-block;">
                            @endif
                        @empty
                            <div class="w-32 h-32 rounded-full my-4"></div>
                        @endforelse
                    </div>
                    <h4><b class="theme-color-title">{{ $workshop->title }}</b></h4>
                    <span class="block">
                        @foreach ($workshop->speakers as $speaker)
                            <b class="theme-color-subtitle">{{ $speaker->name }}{{ $speaker->type ? ' - '.$speaker->type : '' }}</b><br>
                        @endforeach
                    </span>
                    <div class="my-4">
                        @foreach ($workshop->schedules as $pivot)
                            @if ($pivot->schedule)
                                <span class="text-medium_blue block">
                                    <b>
                                        {{ $pivot->schedule->date_start->locale(app()->getLocale())->isoFormat('ddd., DD MMM') }}
                                        / {{ $pivot->schedule->date_start->format('H:i') }} - {{ $pivot->schedule->date_end->format('H:i') }}
                                        @if ($pivot->localization)
                                            <br>{{ __('events.room') }}: {{ $pivot->localization->name }}
                                            @if ($pivot->localization->capacity)
                                                // {{ __('events.capacity') }}: {{ $pivot->localization->capacity }}
                                            @endif
                                        @endif
                                    </b>
                                </span>
                            @endif
                        @endforeach
                    </div>
                    <span class="block theme-text-black">{!! $workshop->description !!}</span>
                    @if ($workshop->video_url)
                        <div class="text-left mt-6">
                            <a class="mr-3 btn hover:bg-primary hover:text-white mobile:mb-2 cursor-pointer" @click="video = '{{ $this->youtubeEmbed($workshop->video_url) }}'">{{ __('events.show_video') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

                </a>
            </div>
        </div>
    @endif
</div>
