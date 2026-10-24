<div class="container-md text-black">
    <h2 class="text-center mb-12 title-theme-900-space theme-text-black--important">{{ $event->main_session_title ?: __('events.tabs.main_session') }}</h2>
    <div class="flex flex-wrap custom-workshops mobile:mt-20">
        @foreach ($this->mainSessions as $session)
            <div class="w-1/2 mobile:w-full {{ $loop->index % 2 === 0 ? 'index-1' : 'index-2' }}" id="main_session_{{ $session->id }}" wire:key="session-{{ $session->id }}">
                <div class="pr-40 tablet:pr-0 mobile:pr-0 pt-28 {{ $loop->first ? 'mobile:pt-0' : 'mobile:pt-20' }}">
                    <span class="text-medium_blue block mb-6"><b style="text-transform: capitalize;">{{ $session->title }}</b></span>
                    <div style="display: inline-block;">
                        @forelse ($session->speakers as $speaker)
                            @if ($speaker->photo)
                                <img src="{{ \App\Support\Media::url($speaker->photo) }}" alt="{{ $speaker->name }}" class="{{ $session->speakers->count() > 2 ? 'w-24 h-24' : 'w-32 h-32' }} rounded-full my-4 bg-secondary" style="object-fit: cover; display: inline-block;">
                            @endif
                        @empty
                            <div class="w-32 h-32 rounded-full my-4"></div>
                        @endforelse
                    </div>
                    <h4><b class="theme-color-title">{{ $session->title }}</b></h4>
                    <span class="block">
                        @foreach ($session->speakers as $speaker)
                            <b class="theme-color-subtitle">{{ $speaker->name }}{{ $speaker->type ? ' - '.$speaker->type : '' }}</b><br>
                        @endforeach
                    </span>
                    <div class="my-4">
                        <span class="text-medium_blue block">
                            <b>{{ $session->date_start->format('d M') }} / {{ $session->date_start->format('H:i') }} - {{ $session->date_end->format('H:i') }}</b>
                        </span>
                    </div>
                    <span class="block theme-text-black">{!! $session->description !!}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
