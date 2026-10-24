@php
    $about = $page->section('about');
    $places = __('amicus.places');
@endphp
<div class="pb-0 mobile:pb-0 mobile:pt-8">
    <div class="max-w-5.5xl relative mx-auto w-full px-4 text-center mobile:px-6">
        <div class="tree-line relative mb-5 text-center mobile:mb-5" style="max-width: 57rem;margin: 0 auto;margin-bottom: 1.25rem;">
            <div class="tree-graph-line relative">
                <h3 class="relative mb-0 inline-block bg-white px-10 pb-13 mobile:p-0"><strong>{{ $about->text('title', __('amicus.default_title')) }}</strong></h3>
            </div>
        </div>
    </div>

    {{-- places desktop --}}
    <div class="mx-auto mb-18 hidden max-w-6xl flex-wrap lg:flex mobile:mb-9 mobile:pt-10">
        @foreach ($places as $key => $place)
            <div class="pointer-titles {{ $key % 2 == 0 ? 'opacity-60' : 'opacity-80' }} flex w-1/3 flex-col items-center justify-start bg-purple p-6 pt-8 text-center text-white"
                style="height: 19rem;padding: 0.6rem;padding-top: 1.6rem;" x-on:click="changeUrl({{ $tabId($place['tab']) }}, '{{ $site->tabUrl($ministry, ['slug' => $place['tab']]) }}')">
                <img class="{{ $place['tab'] === 'be' ? 'w-17 h-20' : 'w-20 h-20' }} inline-block" src="{{ asset($place['image']) }}" alt="">
                <h3 class="my-5"><strong>{{ $place['title'] }}</strong></h3>
                <p class="text-l font-bold text-white">{!! $place['description'] !!}</p>
            </div>
        @endforeach
        <div class="opacity-80 flex w-1/3 flex-col items-center justify-center bg-purple p-6 pt-8 text-center text-white" style="height: 19rem;">
            <img class="w-30 h-25 inline-block" src="{{ asset('images/amicus-logo-ic.png') }}" alt="AMiCUS">
        </div>
    </div>

    {{-- places mobile (slick) --}}
    <div class="places-about mx-auto mb-18 flex w-full flex-wrap overflow-x-hidden lg:hidden mobile:mb-9 mobile:pt-10">
        @foreach ($places as $key => $place)
            <div class="pointer-titles {{ $key % 2 == 0 ? 'opacity-60' : 'opacity-80' }} flex h-96 w-full flex-col items-center justify-start break-words bg-purple p-6 pt-8 text-center text-white"
                x-on:click="changeUrl({{ $tabId($place['tab']) }}, '{{ $site->tabUrl($ministry, ['slug' => $place['tab']]) }}')">
                <img class="w-24 h-24 mx-auto inline-block" src="{{ asset($place['image']) }}" alt="">
                <h2 class="my-5 mobile:my-2"><strong>{{ $place['title'] }}</strong></h2>
                <p class="text-xl font-bold text-white mobile:px-2 mobile:text-lg">{!! $place['description'] !!}</p>
            </div>
        @endforeach
        <div class="opacity-80 flex h-96 w-full flex-col items-center justify-center bg-purple p-6 text-center text-white">
            <img class="w-40 h-32 mx-auto inline-block" src="{{ asset('images/amicus-logo-ic.png') }}" alt="AMiCUS">
        </div>
    </div>
</div>

<div class="bg-secondary px-10 py-30 mobile:px-6 mobile:pb-14 mobile:pt-14">
    <div class="mx-auto w-full max-w-5xl">
        <x-amicus.video :url="$about->raw('video_url')" :height="500" />
    </div>
</div>

<div class="grey-paraghaph mx-auto w-full pb-18 pt-20 text-center desktop_medium:px-4 mobile:px-6 mobile:pb-14 mobile:pt-14">
    <h2 class="mb-8"><strong>{{ $about->text('we_are_here', __('amicus.we_are_here')) }}</strong></h2>
    <div class="flex flex-wrap">
        <div class="w-1/2 py-8 tablet:w-full mobile:px-0">
            <div class="mobile:text-normal text-left text-2xl" style="display:flex;align-items:center;height:100%;">
                <div>{!! $about->text('we_are_description', __('amicus.we_are_description')) !!}</div>
            </div>
        </div>
        <div class="w-1/2 px-8 py-8 tablet:w-full mobile:px-0">
            <blockquote class="ml-0">
                <h2 class="text-left"><div>{!! $about->text('we_are_quote', __('amicus.we_are_quote')) !!}</div></h2>
            </blockquote>
        </div>
    </div>
</div>

<div class="mb-22 bg-purple px-10 pb-9 pt-9 mobile:mb-14 mobile:px-6 mobile:pb-5 mobile:pt-5">
    <div class="pb-10 pt-10 mobile:pb-0 mobile:pt-0" style="background-image: url({{ asset('images/Berg-purple-bg-new.png') }}); background-repeat: repeat; background-position:left top;">
        <div class="container-xl">
            <div class="-mx-5 flex flex-wrap">
                <div class="w-1/2 border-r-2 border-solid border-white px-5 py-6 text-center text-white mobile:w-full mobile:border-b mobile:border-r-0 mobile:py-10">
                    <img class="mb-5 inline-block" src="{{ asset('images/club.png') }}" alt="">
                    <h2 class="text-8.5xl mobile:text-7xl"><strong>42</strong></h2>
                    <h5 class="mb-0 uppercase text-white">{{ __('amicus.chapters') }}</h5>
                </div>
                <div class="w-1/2 px-5 py-6 text-center text-white mobile:w-full mobile:py-10">
                    <img class="mb-5 inline-block" src="{{ asset('images/team-user.png') }}" alt="">
                    <h2 class="text-8.5xl mobile:text-7xl"><strong>{{ $ministry->counter ?: '1934' }}</strong></h2>
                    <h5 class="mb-0 uppercase text-white">{!! __('amicus.members') !!}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<livewire:amicus.directors :ministry="$ministry" />

<x-amicus.contact-form :title="__('amicus.how_can_we_help')" />
