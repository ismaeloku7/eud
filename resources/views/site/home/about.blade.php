@php($about = $page->section('about'))
<section class="bg-dark_grey px-13 pb-30 tablet:pb-20 mobile:px-6">
    <div class="pt-24 mobile:pt-13 about-us pb-30 mobile:pb-13">
        <div class="container-sm mobile:px-0">
            <h5 class="mb-2 text-center">{{ $about->text('kicker') }}</h5>
            <h2 class="mb-12 text-center text-white mobile:mb-8">{!! $about->text('heading') !!}</h2>
            <div class="mb-18 mobile:mb-9 text-white text-center mobile:text-justify">{!! $about->text('text') !!}</div>
            <x-home.team :members="$about->items('team')" />
            @if ($about->text('button'))
                <div class="text-center btn-wrapper">
                    <a class="btn" href="{{ route('about') }}">{{ $about->text('button') }}</a>
                </div>
            @endif
        </div>
    </div>
    <livewire:home.directors :title="$about->text('directors_title', __('home.directors_title'))" />
</section>
