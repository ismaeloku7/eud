@php
    $cover = $page->section('cover');
    $intro = $page->section('intro');
    $highlights = $page->section('highlights')->items('items');
    $philosophy = $page->section('philosophy');
    $figures = $page->section('figures')->items('items');
    $identity = $page->section('identity');
    $allAbout = $page->section('all_about')->items('items');
    $shared = $site->settings('ministries');
    $featuredHonors = \App\Models\Honor::query()->where('ministry_id', $ministry->id)->orderBy('id')->take(5)->get();
    $honorsTab = collect($tabs)->firstWhere('slug', 'honors');
    $coverColor = $cover->raw('color') ?: '#45cdfc';
@endphp

<div class="grey-paraghaph bg-secondary pb-48 tablet:pb-30 mobile:pb-16">
    <x-ministries.tabs :ministry="$ministry" :tabs="$tabs" :tab="$tab" />

    {{-- Cover --}}
    <div class="container-xl tablet:px-6 desktop:px-10 desktop_extralarge:pr-[50px] desktop_extralarge:pl-[50px]">
        <div class="flex flex-wrap mb-16 overflow-hidden tablet:mb-9 rounded-xl portada-grid">
            <div class="w-1/2 px-4 pt-8 pb-8 text-center text-white mobile:px-5 tablet:w-full" style="background-color: {{ $coverColor }}">
                <div class="px-3 pt-12 pb-12 tablet:pt-11 tablet:pb-11" style="background-image: url('{{ $cover->url('pattern') }}'); background-repeat: repeat; background-position: left top;">
                    @if ($cover->url('logo'))
                        <img class="inline-block align-top mb-7 mobile:w-24 mobile:mb-4" src="{{ $cover->url('logo') }}" alt="{{ $ministry->name }}">
                    @endif
                    <h1 class="mb-0 font-normal text-2xl">
                        <strong>{{ $ministry->name }}</strong>
                        <br>
                        {{ $cover->text('title') }}
                    </h1>
                </div>
            </div>
            <div class="w-1/2 tablet:w-full">
                <div class="w-full bg-cover portada-2" style="background-image: url('{{ str_replace(' ', '%20', (string) $cover->url('photo')) }}');"></div>
            </div>
        </div>
    </div>

    {{-- Introduction --}}
    <div class="container-xl desktop_extralarge:pl-[50px] desktop_extralarge:pr-[50px] desktop:px-10 tablet:px-6">
        <div class="mx-auto w-1/2 mobile:w-full">
            <h2 class="mb-4 text-center"><strong>{{ $intro->text('title') }}</strong></h2>
            <div class="-mx-12 flex flex-wrap pb-32 desktop:-mx-6 tablet:pb-18">
                <div class="w-full px-12 desktop:px-6 tablet:mb-8 tablet:w-full">
                    <div class="mobile:text-justify">{!! $intro->text('text') !!}</div>
                    @if ($intro->text('secondary_title') || $intro->text('secondary_text'))
                        <h2 class="mt-12 text-center"><strong>{{ $intro->text('secondary_title') }}</strong></h2>
                        <div class="mobile:text-justify">{!! $intro->text('secondary_text') !!}</div>
                    @endif
                </div>
            </div>
            @if ($intro->items('downloads') !== [])
                <div class="-mx-3 mb-16 flex flex-wrap justify-center">
                    @foreach ($intro->items('downloads') as $download)
                        <div class="w-1/2 px-3 mobile:w-full mobile:mb-6 text-center">
                            @if ($download->url('image'))
                                <img class="mb-3 inline-block rounded-xl" src="{{ $download->url('image') }}" alt="">
                            @endif
                            <h6><strong>{{ $download->text('title') }}</strong></h6>
                            <p>{{ $download->text('subtitle') }}</p>
                            @if ($download->url('file'))
                                <a class="text-medium_blue hover:underline" href="{{ $download->url('file') }}" target="_blank" rel="noopener">
                                    <img class="mr-1 inline-block" src="{{ asset('images/Download_Icon_blue.svg') }}" alt=""> {{ __('download') }}
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Highlights --}}
    @if ($highlights !== [])
        <div class="container-xl tablet:px-6 desktop:px-10 desktop_extralarge:pr-[50px] desktop_extralarge:pl-[50px] headline">
            <div class="px-16 pt-10 pb-12 bg-white mobile:px-8 mobile:pt-8 mobile:pb-6 rounded-xl">
                <div class="flex flex-wrap -mx-8 desktop:-mx-6 mobile:-mx-3">
                    @foreach ($highlights as $item)
                        <div class="{{ count($highlights) > 3 ? 'w-1/4' : 'w-1/3' }} px-8 tablet:w-1/2 mobile-small:w-full tablet:mb-8 desktop:px-6 mobile:px-6 mobile:mb-6 mobile:text-center">
                            @if ($item->url('image'))
                                <img class="mb-5 mobile:mx-auto" src="{{ $item->url('image') }}" alt="">
                            @endif
                            <h5 @class(['mb-4 uppercase text-primary mobile:text-center', 'cursor-pointer' => $item->raw('link')]) onclick="redirectPage('{{ $item->raw('link') }}')">
                                {{ $item->text('title') }}
                            </h5>
                            <div>{!! $item->text('text') !!}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Philosophy --}}
@if ($philosophy->text('title') || $philosophy->text('text'))
    <div class="container-xl bg-secondary pb-20 desktop_extralarge:pl-[50px] desktop_extralarge:pr-[50px] desktop:px-10 tablet:px-6">
        <div class="grey-paraghaph philosophy rounded-xl bg-white px-6 pb-12 pt-12 text-primary tablet:pb-20 tablet:pt-18 mobile:px-6 mobile:pb-7 mobile:pt-9">
            <div class="mobile:container-md px-3 mobile:px-6">
                <div class="-mx-12 flex flex-wrap desktop:-mx-6">
                    <div class="w-1/2 px-12 desktop:px-6 tablet:mb-9 tablet:w-full">
                        <h2 class="mb-4"><strong>{{ $philosophy->text('title') }}</strong></h2>
                        <div class="mobile:text-justify">{!! $philosophy->text('text') !!}</div>
                    </div>
                    <div class="w-1/2 px-12 desktop:px-6 tablet:w-full">
                        <h2><strong>{{ $philosophy->text('secondary_title') }}</strong></h2>
                        <div class="mobile:text-justify">{!! $philosophy->text('secondary_text') !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Figures --}}
@if ($figures !== [])
    <div class="px-10 pt-9 pb-9 mobile:px-5 mobile:pt-5 mobile:pb-5" style="background-color: {{ $coverColor }}">
        <div class="pt-10 pb-10 mobile:pt-0 mobile:pb-0" style="background-image: url('{{ $cover->url('pattern') }}'); background-repeat: repeat; background-position: left top;">
            <div class="container-xl">
                <div class="flex flex-wrap -mx-5">
                    @foreach ($figures as $figure)
                        <div class="w-1/2 px-5 py-6 text-center text-white mobile:py-10 mobile:w-full {{ $loop->last ? '' : 'border-r-2 border-white border-solid mobile:border-r-0 mobile:border-b' }}">
                            @if ($figure->url('icon'))
                                <img class="inline-block mb-5" src="{{ $figure->url('icon') }}" alt="">
                            @endif
                            <h2 class="text-8.5xl mobile:text-7xl"><strong>{{ number_format((int) $figure->raw('number'), 0, ',', ',') }}</strong></h2>
                            <h5 class="mb-0 text-white uppercase">{!! $figure->text('text') !!}</h5>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Identity (logo, emblems, download) --}}
@if ($identity->text('subtitle') || $identity->items('logos') !== [])
    <div class="logo-means bg-secondary pb-18 pt-22 text-primary mobile:pb-8 mobile:pt-10">
        <div class="container-xl mobile:container mobile:px-6">
            <div class="mx-auto mb-32 max-w-3.5xl mobile:mb-16">
                <h2 class="mb-12 text-center mobile:mb-8"><strong>{{ $identity->text('subtitle') }}</strong></h2>
                <div class="mobile:text-justify">{!! $identity->text('text') !!}</div>
            </div>
            <div class="mx-auto max-w-4.5xl">
                @if ($identity->url('image'))
                    <div class="footprint-logo grey-paraghaph mb-16 text-center mobile:mb-9">
                        <div class="footprint-graph-line pb-11">
                            <div class="relative inline-block bg-secondary px-4 align-top">
                                <img class="mobile:w-28" src="{{ $identity->url('image') }}" alt="">
                            </div>
                        </div>
                    </div>
                @endif
                <div class="grey-paraghaph -mx-2 mb-6 flex flex-wrap justify-center gap-5 tablet:mb-5 mobile:mb-4">
                    @foreach ($identity->items('logos') as $logo)
                        <div class="{{ $identity->text('card_class') }}" style="display: flex; flex-direction: column; height: 100%;">
                            <div style="flex-grow: 1; display: flex; align-items: center; justify-content: center;">
                                <img class="{{ $identity->text('image_class') }}" src="{{ $logo->url('image') }}" alt="" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            </div>
                            <h5 class="{{ $identity->text('name_class') }}">{{ $logo->text('title') }}</h5>
                            <div>{!! $logo->text('text') !!}</div>
                        </div>
                    @endforeach
                </div>
                @if ($identity->text('file_label') && ($identity->url('file') || $identity->text('link')))
                    <div class="text-center">
                        <a class="btn" href="{{ $identity->url('file') ?? $identity->text('link') }}" target="_blank" rel="noopener">{!! $identity->text('file_label') !!}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

{{-- Featured honors --}}
@if ($featuredHonors->isNotEmpty() && $honorsTab)
    <div class="featured-honors bg-white pt-24 mobile:pb-13 mobile:pt-13">
        <div class="mobile:container-md container-xl mobile:px-6">
            <h5 class="mb-20 text-center uppercase mobile:mb-12"><strong>{{ $shared->text('honors_title', __('ministries.featured_honors')) }}</strong></h5>
            <div class="-mx-5 flex flex-wrap justify-center">
                @foreach ($featuredHonors as $honor)
                    <div class="mb-14 w-1/5 px-5 text-center mobile:mb-8 mobile:w-1/3 mobile-small:w-1/2">
                        <a href="{{ $site->tabUrl($ministry, $honorsTab) }}?view=show&honor={{ $honor->id }}">
                            <img class="mb-3 inline-block align-top" src="{{ \App\Support\Media::url($honor->image) }}" alt="{{ $honor->name }}">
                            <h6><strong>{{ $honor->name }}</strong></h6>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center pb-12">
                <a class="btn hover:bg-primary hover:text-white" href="{{ $site->tabUrl($ministry, $honorsTab) }}">{{ $shared->text('honors_button', __('ministries.all_honors')) }}</a>
            </div>
        </div>
    </div>
@endif

{{-- All about --}}
@if ($allAbout !== [])
    <div class="bg-white pb-20 pt-20 mobile:pb-10 mobile:pt-10">
        <div class="container-xl desktop_extralarge:pl-[50px] desktop_extralarge:pr-[50px] desktop:px-10 tablet:px-6">
            <h5 class="mb-14 text-center uppercase mobile:mb-8">{{ Str::contains(Str::lower($shared->text('all_about_title')), Str::lower((string) $ministry->name)) ? $shared->text('all_about_title') : trim($shared->text('all_about_title', __('ministries.all_about')).' '.$ministry->name) }}</h5>
            <div class="-mx-2 flex flex-wrap justify-center">
                @foreach ($allAbout as $card)
                    <div class="mb-4 w-1/6 cursor-pointer px-2 tablet:w-1/4 mobile:w-1/3 mobile-small:w-1/2">
                        <div class="pathfinder overflow-hidden rounded-xl">
                            @if ($card->url('image'))
                                <img class="w-full" src="{{ $card->url('image') }}" alt="">
                            @endif
                            <h3>
                                @if ($card->text('link'))
                                    <a href="{{ $card->text('link') }}" @if (Str::startsWith($card->text('link'), 'http')) target="_blank" rel="noopener" @endif>{{ $card->text('title') }}</a>
                                @else
                                    {{ $card->text('title') }}
                                @endif
                            </h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

{{-- Countries with directors of this ministry --}}
<livewire:ministries.country-directors :ministry="$ministry" :title="$page->section('countries')->text('title', $shared->text('countries_title', __('ministries.our_countries')))" />

@push('styles')
    <style>
        .portada-grid { height: 400px; }
        .portada-grid .portada-2 { height: 400px; }
        .portada-grid img { max-height: 190px; }
        .headline ol > li { margin-bottom: 0; }
        .logo-means a.btn, .featured-honors a.btn { }
        @media (max-width: 767px) {
            .portada-grid { height: auto; }
            .portada-grid .portada-2 { height: 264px; }
            .logo-means a.btn, .featured-honors a.btn { min-width: 11rem; font-size: .9rem; }
        }
    </style>
@endpush
