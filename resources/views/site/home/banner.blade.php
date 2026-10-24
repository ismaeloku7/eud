@php($hero = $page->section('hero'))
<section class="banner" style="background-image: url('{{ $hero->url('image') }}');">
    <div class="container h-full mobile:px-6">
        <div class="relative z-10 flex h-full flex-wrap items-center">
            <div class="banner-text max-w-2xl">
                <span>{{ $hero->text('kicker') }}</span>
                <h1 class="font-normal">{!! $hero->text('heading') !!}</h1>
                @if ($hero->text('button'))
                    <a class="btn btn-white" href="{{ route('resources.index') }}">{{ $hero->text('button') }}</a>
                @endif
            </div>
        </div>
    </div>
</section>

@push('styles')
    <style>
        @media (max-width: 767px) {
            .banner-text h1 { font-size: 1.5rem; }
            .banner-text span { display: none; }
            .banner-text a.btn { min-width: 12rem; }
        }
    </style>
@endpush
