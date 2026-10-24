<div class="event-container" x-data="{ video: null }"
    x-on:scroll-to.window="(e) => { const el = document.getElementById(e.detail.id); if (el) setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'start' }), 150) }"
    x-on:tab-changed.window="() => { const el = document.getElementById('tabContainer'); if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' }) }">
    @php($tabs = $this->tabs)
    <div class="container-md">
        <div id="tabContainer"></div>
        <div class="tabs-nav border-0 mobile:hidden">
            <ul>
                @foreach ($tabs as $key => $label)
                    <li class="tabs-li-active {{ $key === $tab ? 'active' : '' }}" wire:key="tab-{{ $key }}">
                        <a class="cursor-pointer" wire:click="selectTab('{{ $key }}')">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="hidden mobile:block">
            <div class="w-full mobile:text-center pt-4 pb-4 px-0">
                <select wire:change="selectTab($event.target.value)"
                    class="decorated-theme rounded-full border border-medium_blue py-2 px-4 w-60 bg-transparent appearance-none h-10 self-center theme-color-subtitle fw-bold mobile:w-full"
                    style="background-image: url({{ asset('images/down-arrow-blue.svg') }}); background-size: 13px auto; background-position-x: calc(100% - 15px); background-position-y: center; background-repeat: no-repeat; padding-right: 40px; font-size: 18px; text-transform: capitalize; border-width: 2px; max-width: 600px; min-height: 42px;"
                    aria-label="{{ __('events.select_tab') }}">
                    @foreach ($tabs as $key => $label)
                        <option value="{{ $key }}" @selected($key === $tab)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="text-primary" id="parentToColumn2" style="position: relative; z-index: 2;">
        <div class="pt-16 mobile:pt-12 pb-40" id="{{ $tab }}">
            @switch($tab)
                @case('speakers')
                    @include('site.events.tabs.speakers')
                @break

                @case('workshops')
                    @include('site.events.tabs.workshops')
                @break

                @case('main_session')
                    @include('site.events.tabs.main-session')
                @break

                @case('location')
                    @include('site.events.tabs.location')
                @break

                @case('program')
                    @include('site.events.tabs.program')
                @break

                @case('gallery')
                    @include('site.events.tabs.gallery')
                @break

                @case('registration')
                    @include('site.events.tabs.registration')
                @break

                @default
                    @include('site.events.tabs.about')
            @endswitch
        </div>
    </div>

    @if ($speaker = $this->speakerInModal)
        <div class="min-h-screen w-full fixed top-0 left-0 z-40 flex text-black scroll-modal" style="background-color: rgba(0, 0, 0, .6)" wire:click="closeSpeaker">
            <div class="w-2/5 bg-white m-auto flex flex-col pb-20 overflow-y-auto" style="max-height: 90vh; max-width: 700px; width: 100%;" wire:click.stop>
                <div class="flex w-full flex-row p-8 pb-4 justify-end">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 26 26" class="cursor-pointer" wire:click="closeSpeaker" role="button" aria-label="Close">
                        <g fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                            <path d="M1.5 1.499l23 23M24.5 1.499l-23 23" />
                        </g>
                    </svg>
                </div>
                <div class="w-3/5 mx-auto pt-4">
                    @if ($speaker->photo)
                        <img src="{{ \App\Support\Media::url($speaker->photo) }}" style="object-fit: cover;" class="rounded-full w-44 h-44" alt="{{ $speaker->name }}">
                    @endif
                    <h4 class="underline theme-color-title mt-4"><b>{{ $speaker->name }}</b></h4>
                    @if ($speaker->description)
                        <div style="line-height: 20px;" class="mt-6">{!! $speaker->description !!}</div>
                    @endif

                    @if ($speaker->programs->isNotEmpty())
                        <h4 class="theme-text-blue underline fw-bold mt-8" style="margin-bottom: 40px;">{{ __('events.programs') }}</h4>
                        @foreach ($speaker->programs->groupBy(fn ($program) => $program->date_start->format('Y-m-d')) as $day => $programs)
                            <h4 class="theme-color-title" style="margin-bottom: 26px;">
                                <b style="font-size: 18px;">{{ $programs->first()->date_start->locale(app()->getLocale())->translatedFormat('l, j F') }}</b>
                            </h4>
                            @foreach ($programs as $program)
                                <div class="fw-600" style="margin-bottom: 20px;">
                                    <span class="text-medium_blue block" style="font-size: 15px; font-weight: bold;">{{ $program->date_start->format('H:i') }} - {{ $program->date_end->format('H:i') }}</span>
                                    <div class="fw-bold theme-color-subtitle" style="font-size: 12px;">{{ $program->title }}</div>
                                    <div class="theme-color-subtitle" style="font-size: 12px;">{!! $program->description !!}</div>
                                </div>
                            @endforeach
                        @endforeach
                    @endif

                    @php($slots = $speaker->workshops->flatMap(fn ($workshop) => $workshop->schedules->filter(fn ($pivot) => $pivot->schedule)->map(fn ($pivot) => ['workshop' => $workshop, 'schedule' => $pivot->schedule]))->sortBy(fn ($slot) => $slot['schedule']->date_start))
                    @if ($slots->isNotEmpty())
                        <h4 class="theme-text-blue underline fw-bold mt-8" style="margin-bottom: 40px;">{{ __('events.workshops') }}</h4>
                        @foreach ($slots->groupBy(fn ($slot) => $slot['schedule']->date_start->format('Y-m-d')) as $day => $daySlots)
                            <h4 class="theme-color-title" style="margin-bottom: 26px;">
                                <b style="font-size: 18px;">{{ $daySlots->first()['schedule']->date_start->locale(app()->getLocale())->translatedFormat('l, j F') }}</b>
                            </h4>
                            @foreach ($daySlots as $slot)
                                <div class="fw-600" style="margin-bottom: 20px;">
                                    <span class="text-medium_blue block" style="font-size: 15px; font-weight: bold;">{{ $slot['schedule']->date_start->format('H:i') }} - {{ $slot['schedule']->date_end->format('H:i') }}</span>
                                    <div class="fw-bold theme-color-subtitle" style="font-size: 12px;">{{ $slot['workshop']->title }}</div>
                                    <div class="theme-color-subtitle" style="font-size: 12px;">{!! $slot['workshop']->description !!}</div>
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="min-h-screen w-full fixed top-0 left-0 z-40 text-black scroll-modal" x-show="video" x-cloak style="background-color: rgba(0, 0, 0, .6); display: none;" @click="video = null">
        <div class="w-2/5 bg-white m-auto flex flex-col pb-2 px-2 overflow-y-auto" style="max-height: 90vh; max-width: 700px; width: 100%; height: auto; margin-top: 5vh;" @click.stop>
            <div class="flex w-full flex-row p-8 pb-4 justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 26 26" class="cursor-pointer" @click="video = null" role="button" aria-label="Close">
                    <g fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                        <path d="M1.5 1.499l23 23M24.5 1.499l-23 23" />
                    </g>
                </svg>
            </div>
            <template x-if="video">
                <iframe :src="video" style="width: 100%; min-height: 400px;" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </template>
        </div>
    </div>

    @push('styles')
        <style>
            [x-cloak] { display: none !important; }
            .tabs-content p { color: #000; }
            .scroll-modal ::-webkit-scrollbar { width: 5px; }
            .scroll-modal ::-webkit-scrollbar-track { box-shadow: inset 0 0 5px grey; border-radius: 10px; }
            .scroll-modal ::-webkit-scrollbar-thumb { background: rgba(69, 205, 252); border-radius: 10px; }
            .day-switcher { display: flex; align-items: center; justify-content: flex-end; gap: 0.5rem; }
            .day-switcher .days { display: flex; gap: 0.25rem; overflow-x: auto; scrollbar-width: none; }
            .day-switcher .days::-webkit-scrollbar { display: none; }
            .day-switcher .days button { white-space: nowrap; padding: 0.5rem 1rem; background: none; border: 0; border-right: 2px solid #45CDFC; }
            .day-switcher .days button:last-child { border-right: 0; }
            .day-switcher .arrow { background: none; border: 0; cursor: pointer; }
            @media (max-width: 767.9px) { .day-switcher { justify-content: center; } }
        </style>
    @endpush
</div>
