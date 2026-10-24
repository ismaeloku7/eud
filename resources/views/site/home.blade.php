<x-layouts.site :title="__('home.title')" :description="$page->getTranslation('seo', app()->getLocale(), false) ?: null">
    @include('site.home.banner')
    @include('site.home.ministries')
    @include('site.home.resources')
    @include('site.home.events')
    @include('site.home.mission')
    @include('site.home.counter')
    @include('site.home.about')
    @include('site.home.contact')

    @push('styles')
        <style>
            .contact-setcion p { text-align: center; }
            .more-events { margin-left: auto; }
            @media (min-width: 768px) { .more-events { margin-left: 0; } }
        </style>
    @endpush

    @push('scripts')
        <script>
            function scrollNavbarHome() {
                if (window.scrollY) {
                    $('#nav-bar-desktop').addClass('fixed-header');
                } else {
                    $('#nav-bar-desktop').removeClass('fixed-header');
                }
            }
            window.addEventListener('scroll', scrollNavbarHome);
            scrollNavbarHome();
        </script>
    @endpush
</x-layouts.site>
