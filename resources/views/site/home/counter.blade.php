@php
    $partners = $page->section('partners');
    $logos = $partners->items('logos');
@endphp
<section class="relative pt-24 pb-4 tablet:pt-20 mobile:pt-13 mobile:pb-5 blue-section bg-medium_blue">
    <div class="relative container-xl">
        <h5 class="mb-20 text-center text-white tablet:mb-12 mobile:mb-6">{{ $partners->text('title') }}</h5>
        <div class="flex flex-wrap text-center our-advantage">
            @foreach ($site->ministries() as $index => $ministry)
                <div class="w-1/3 mb-20 mobile:w-1/2 tablet:mb-10 mobile:mb-7">
                    <img class="inline-block mb-4" src="{{ isset($logos[$index]) && $logos[$index]->url('image') ? $logos[$index]->url('image') : $site->logo($ministry) }}" alt="{{ $ministry->name }}">
                    <h2 class="text-8.5xl desktop_large:text-7xl text-white mb-0">
                        <strong class="counter" data-target="{{ (int) preg_replace('/\D+/', '', (string) $ministry->counter) }}"></strong>
                    </h2>
                    <h5>{{ $site->menuName($ministry) }}</h5>
                </div>
            @endforeach
        </div>
    </div>
</section>
