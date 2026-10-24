@php($nav = $site->settings('navigation'))
<nav class="sb-slidebar" id="menu">
    <ul>
        <li>
            <a href="javascript:void(0)">{{ Str::upper($nav->text('ministries', __('ministries'))) }}</a>
            <ul>
                @foreach ($site->ministries() as $ministry)
                    <li>
                        <a href="javascript:void(0)">{{ $site->menuName($ministry) }}</a>
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

@push('styles')
    <style>
        #menu .mm-navbar {
            background-image: linear-gradient(to right, #45cdfc 0%, #45cdfc 100%);
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
        }
    </style>
@endpush
