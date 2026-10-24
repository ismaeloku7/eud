<div class="container-md a-href-theme">
    @if ($event->registration_title)
        <h2 class="text-center uppercase mb-12 title-theme-900-space theme-text-black--important">{{ $event->registration_title }}</h2>
    @endif
    @if ($event->registration_eud || $event->registration_non_eud)
        <div class="flex -mx-12 desktop_medium:flex-wrap a-href-theme">
            @if ($event->registration_eud)
                <div class="w-1/2 px-12 desktop_medium:w-full desktop_medium:pb-28 mobile:pb-14 theme-text-black-all theme_content_description">
                    <h2 class="mb-6"><strong>{{ __('events.eud_participants') }}</strong></h2>
                    {!! $event->registration_eud !!}
                </div>
            @endif
            @if ($event->registration_non_eud)
                <div class="w-1/2 px-12 desktop_medium:w-full theme-text-black-all theme_content_description">
                    <h2 class="mb-6"><strong>{{ __('events.non_eud_participants') }}</strong></h2>
                    {!! $event->registration_non_eud !!}
                </div>
            @endif
        </div>
    @endif
    @include('site.events.tabs.partials.blocks', ['blocks' => $event->registration_recursive ?? []])
</div>
