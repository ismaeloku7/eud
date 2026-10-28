@php($days = $this->programDays)
<div class="container-md text-black mb-20">
    <div class="flex flex-wrap mb-40 grey-paraghaph">
        <div class="w-full py-4 mobile:px-0">
            <h2 class="mb-2" style="color: rgb(110, 110, 110);"><strong>{{ $event->program_title ?: $event->title }}</strong></h2>
            @if ($event->program_subtitle ?: $event->subtitle)
                <h6 class="mb-6" style="color: rgb(110, 110, 110);"><strong>{!! $event->program_subtitle ?: $event->subtitle !!}</strong></h6>
            @endif
            <div class="theme-text-black--important theme_content_description" style="color: rgb(110, 110, 110);">
                {!! $event->program_description ?: $event->description !!}
            </div>
        </div>
    </div>

    <div class="mobile:text-center">
        <h3 class="theme-color-title fw-bold mb-6">{{ __('events.schedule') }}</h3>
        @include('site.events.tabs.partials.day-switcher', ['items' => $days, 'selected' => $programDay, 'select' => 'selectProgramDay', 'align' => 'start'])
    </div>

    <div class="flex flex-wrap mt-12 py-4">
        <div class="w-full">
            @if ($this->programDayTitle)
                <h4 class="theme-color-title fw-bold mb-2 mobile:text-center">{{ $this->programDayTitle }}</h4>
            @endif
            @foreach ($this->programsOfDay as $program)
                <div class="py-8 flex" style="border-bottom: solid 1px whitesmoke;" wire:key="program-{{ $program->id }}">
                    <div class="text-medium_blue block text-xl fw-bold mobile:fs-16 pr-4 tablet:pr-0" style="max-width: 240px; width: 100%; {{ $program->color ? 'border-left: 4px solid '.$program->color.'; padding-left: 1rem;' : '' }}">
                        {{ $program->date_start->format('H:i') }} - {{ $program->date_end->format('H:i') }}
                    </div>
                    <div class="pl-4 tablet:pl-0 w-full">
                        <span class="theme-color-title mobile:fs-14 flex items-center">
                            {{ $program->title }}&ensp;
                            @if ($program->main_session)
                                <a wire:click="showMainSession({{ $program->id }})" style="cursor: pointer;" title="{{ __('events.tabs.main_session') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><path fill="#45CDFC" d="M320 0c-17.7 0-32 14.3-32 32s14.3 32 32 32h82.7L201.4 265.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L448 109.3V192c0 17.7 14.3 32 32 32s32-14.3 32-32V32c0-17.7-14.3-32-32-32H320zM80 32C35.8 32 0 67.8 0 112V432c0 44.2 35.8 80 80 80H400c44.2 0 80-35.8 80-80V320c0-17.7-14.3-32-32-32s-32 14.3-32 32V432c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16H192c17.7 0 32-14.3 32-32s-14.3-32-32-32H80z" /></svg>
                                </a>
                            @endif
                            @if ($program->sync_workshop && $this->workshopGroups->has((string) $program->id))
                                <a wire:click="showWorkshops({{ $program->id }})" style="cursor: pointer;" title="{{ __('events.tabs.workshops') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><path fill="#45CDFC" d="M320 0c-17.7 0-32 14.3-32 32s14.3 32 32 32h82.7L201.4 265.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L448 109.3V192c0 17.7 14.3 32 32 32s32-14.3 32-32V32c0-17.7-14.3-32-32-32H320zM80 32C35.8 32 0 67.8 0 112V432c0 44.2 35.8 80 80 80H400c44.2 0 80-35.8 80-80V320c0-17.7-14.3-32-32-32s-32 14.3-32 32V432c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16H192c17.7 0 32-14.3 32-32s-14.3-32-32-32H80z" /></svg>
                                </a>
                            @endif
                        </span>
                        @if ($program->speakers->isNotEmpty())
                            <span class="block theme-color-subtitle mobile:fs-14">{{ $program->speakers->map(fn ($speaker) => $speaker->name)->join(', ') }}</span>
                        @endif
                        @if ($program->description)
                            <span class="block"><b class="theme-color-title mobile:fs-14">{!! $program->description !!}</b></span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
