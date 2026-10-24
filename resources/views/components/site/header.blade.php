@php
    $nav = $site->settings('navigation');
    $brand = $site->settings('brand');
@endphp
<header class="fixed-header fixed top-0 z-40 w-full" id="nav-bar-desktop">
    <div class="px-4 py-8 mobile:py-5">
        <div class="flex items-center justify-between">
            <div class="logo-wrap">
                <a href="{{ route('home') }}">
                    <img src="{{ $brand->url('logo') ?? asset('images/Logo.svg') }}" alt="{{ config('app.name') }}" />
                    <p>{!! $brand->text('tagline') !!}</p>
                </a>
            </div>
            <div class="menu-wrap flex items-center">
                <nav>
                    <ul>
                        <li>
                            <a href="javascript:void(0)">{{ Str::upper($nav->text('ministries', __('ministries'))) }}</a>
                            <ul>
                                @foreach ($site->ministries() as $ministry)
                                    <li>
                                        <a href="{{ route('ministries.show', ['slug' => $ministry->slug]) }}">{{ $site->menuName($ministry) }}</a>
                                        <ul>
                                            @foreach ($site->tabs($ministry) as $tab)
                                                <li><a href="{{ $site->tabUrl($ministry, $tab) }}">{{ __($tab['name']) }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="{{ route('resources.index') }}">{{ Str::upper($nav->text('resources', __('resources'))) }}</a></li>
                        <li><a href="{{ route('events.index') }}">{{ Str::upper($nav->text('events', __('events'))) }}</a></li>
                        <li><a href="{{ route('mission') }}">{{ Str::upper($nav->text('mission', __('mission'))) }}</a></li>
                        <li><a href="{{ route('about') }}">{{ Str::upper($nav->text('about', __('about'))) }}</a></li>
                    </ul>
                </nav>
                <div class="language-section">
                    <select onchange="cambiarUrl(event.target.value)" aria-label="{{ __('language') }}">
                        @foreach ($site->languages() as $language)
                            <option value="{{ $language['url'] }}" @selected($language['selected'])>{{ $language['code'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="header-icon">
                    <x-site.social-icons />
                </div>
                <div class="humberger-icon hidden tablet:block">
                    <a class="menu-bt sb-toggle-right" href="#menu" aria-label="Menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

@push('styles')
    <style>
        @media (max-width: 767px) {
            .logo-wrap a p { color: transparent; }
            .logo-wrap a p strong { color: #fff; }
        }
    </style>
@endpush
