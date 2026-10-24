<x-layouts.site :title="$site->menuName($ministry)">
    <x-ministries.nav :ministry="$ministry" />

    <div class="bg-secondary">
        @switch($tab)
            @case('curriculum')
                <div class="grey-paraghaph bg-secondary pb-48 tablet:pb-30 mobile:pb-16">
                    <x-ministries.tabs :ministry="$ministry" :tabs="$tabs" :tab="$tab" />
                    @include('site.ministries.curriculum')
                </div>
            @break

            @case('honors')
                <x-ministries.tabs :ministry="$ministry" :tabs="$tabs" :tab="$tab" />
                <livewire:ministries.honors :ministry="$ministry" />
            @break

            @case('our-countries')
                <div class="grey-paraghaph bg-secondary pb-48 tablet:pb-30 mobile:pb-16">
                    <x-ministries.tabs :ministry="$ministry" :tabs="$tabs" :tab="$tab" />
                    <livewire:ministries.country-directors :ministry="$ministry" :title="__('ministries.your_youth_directors')" :with-office="true" />
                </div>
            @break

            @default
                @include('site.ministries.general')
        @endswitch
    </div>

    @push('styles')
        <style>
            .requirements-text ol { list-style: decimal; padding-left: 1.5rem; }
            .requirements-text ul { list-style: disc; padding-left: 1.5rem; }
            @media (max-width: 767px) {
                .category-main-nav-2 li:nth-child(3), .category-main-nav-2 li:nth-child(5) { border: none; }
                .category-main-nav-2 li:nth-child(6) { width: 6.2rem; }
                .category-main-nav-2 { justify-content: center; }
            }
            @media (max-width: 360px) {
                .category-main-nav-2 li:nth-child(4), .category-main-nav-2 li:nth-child(2) { border: none; }
                .category-main-nav-2 li:nth-child(3) { border-right: 2px solid rgb(69, 205, 252); }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Curriculum tabs: show the first panel; custom.js switches panels on click.
            document.querySelectorAll('.achievement-tabs-content').forEach((content) => {
                content.querySelectorAll(':scope > div').forEach((panel, index) => { panel.style.display = index === 0 ? '' : 'none'; });
            });

            function playGeneral(btnClass, videoClass, cardClass) {
                document.querySelectorAll('video').forEach((video) => video.pause());
                const btn = $(btnClass);
                $(btn).siblings(videoClass).trigger('play');
                $(btn).parents(cardClass).addClass('vid_play');
            }

            function toggleVideo(element) {
                const wasPaused = element.paused;
                document.querySelectorAll('video').forEach((video) => { if (!video.paused) video.pause(); });
                if (!wasPaused) {
                    document.querySelector(`.${element.className}`).play();
                }
            }

            function redirectPage(url) {
                if (!url) return;
                const a = document.createElement('a');
                a.href = url;
                a.target = '_blank';
                a.rel = 'noopener';
                a.click();
            }
        </script>
    @endpush
</x-layouts.site>
