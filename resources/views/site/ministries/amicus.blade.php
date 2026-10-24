{{-- AMiCUS: nine themed tabs on one page, switched client side (Alpine) like the legacy site. --}}
@php
    $partials = ['about' => 'about', 'starting-uni' => 'starting', 'connect' => 'connect', 'think' => 'think', 'encounter-jesus' => 'encounter', 'be' => 'be', 'act' => 'act', 'resources' => 'resources', 'events' => 'events'];
    $items = collect($tabs)->values()->map(fn ($item, $index) => [
        'id' => $index + 1,
        'slug' => $item['slug'],
        'name' => __($item['name']),
        'url' => $site->tabUrl($ministry, $item),
        'partial' => $partials[$item['slug']] ?? null,
    ]);
    $current = $items->firstWhere('slug', $tab)['id'] ?? 1;
    $tabId = fn (string $slug) => $items->firstWhere('slug', $slug)['id'] ?? 1;
@endphp
<x-layouts.site :title="$site->menuName($ministry).' · '.($items->firstWhere('slug', $tab)['name'] ?? '')" :description="$page->section('about')->text('we_are_description') ? Str::limit(strip_tags($page->section('about')->text('we_are_description')), 160) : null">
    <div class="w-5/6 mobile:w-full mx-auto">
        <x-amicus.ministries-nav :ministry="$ministry" />
        <div x-data="amicusTabs({{ $current }})">
            <div class="category-sub-nav amicus-sub-nav mb-13 mobile:mb-0">
                <div class="container-xl">
                    <div class="flex items-end justify-between mobile:items-start">
                        <div class="pr-2 mt-2 mb-1">
                            <img src="{{ asset('images/amicus-blue-Logo.png') }}" class="hidden" alt="AMiCUS" id="iconoLogo">
                        </div>
                        <ul class="flex justify-end pl-0 desktop_extralarge:justify-start desktop_large:flex-wrap category-main-nav category-main-nav-2 self-center py-4">
                            @foreach ($items as $item)
                                <li :class="page == {{ $item['id'] }} ? 'active' : ''">
                                    <a href="{{ $item['url'] }}" @click.prevent="changeUrl({{ $item['id'] }}, '{{ $item['url'] }}')">{{ $item['name'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="amicus-tabs-content pt-20 mobile:pt-0 container-xl tablet:px-6 desktop:px-10 desktop_extralarge:pr-[50px] desktop_extralarge:pl-[50px]">
                @foreach ($items as $item)
                    @if ($item['partial'])
                        <div x-show="page == {{ $item['id'] }}" x-cloak id="amicus-{{ $item['slug'] }}">
                            @include('site.ministries.amicus.'.$item['partial'], ['tabId' => $tabId])
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            [x-cloak] { display: none !important; }
            .wrapper, .wrapper header { max-width: none; }
            .pointer-titles { cursor: pointer; }
            .pointer-titles:hover { opacity: 0.5; }
            @media (max-width: 767px) {
                .places-about p br, .places-starting p br { display: initial; }
                .category-main-nav-2 li:nth-child(3), .category-main-nav-2 li:nth-child(7) { border: none; }
                .category-main-nav-2 { justify-content: center; max-width: none; }
                .category-main-nav-2 li:nth-child(2) { width: 7.4rem; text-align: center; }
                .youth-directors .btn.btn-text-start { min-width: 130px; }
            }
            @media (max-width: 360px) {
                .category-main-nav-2 li:nth-child(6) { border: none; }
                .category-main-nav-2 li:nth-child(7) { border-right: 2px solid rgb(69, 205, 252); }
                .category-main-nav-2 { margin-top: 1rem; }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const amicusSlick = { arrows: false, infinite: true, speed: 500, autoplay: true };

            function amicusUnslick() {
                document.querySelectorAll('.slick-initialized').forEach((item) => $(item).slick('unslick'));
            }

            function amicusSlickFor(page) {
                if (page === 1) $('.places-about').slick(amicusSlick);
                if (page === 2) $('.places-starting').slick(amicusSlick);
            }

            function amicusTabs(initial) {
                return {
                    page: initial,
                    changeUrl(page, link = null) {
                        if (page !== this.page) {
                            amicusUnslick();
                            setTimeout(() => amicusSlickFor(page), 300);
                        }
                        this.page = page;
                        history.pushState(null, '', link || `?nav=${page}`);
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    },
                };
            }

            $(() => amicusSlickFor({{ $current }}));
            $(window).on('resize', () => {
                amicusUnslick();
                amicusSlickFor({{ $current }});
            });
        </script>
    @endpush
</x-layouts.site>
