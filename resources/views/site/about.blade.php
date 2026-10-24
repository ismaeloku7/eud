@php($intro = $page->section('intro'))
<x-layouts.site :title="__('about')">
    <section class="bg-dark_grey px-13 tablet:pb-20 mobile:px-2">
        <div class="about-us pb-30 pt-24 mobile:pb-13 mobile:pt-13">
            <div class="container-sm mobile:px-6">
                <h5 class="mb-2 text-center">{{ $intro->text('kicker') }}</h5>
                <h2 class="mb-12 text-center text-white mobile:mb-8">{!! $intro->text('heading') !!}</h2>
                <div class="mb-18 mobile:mb-9 text-white">{!! $intro->text('text') !!}</div>
                <x-home.team :members="$page->section('team')->items('members')" />
            </div>
        </div>
    </section>
    <section class="bg-white px-13 tablet:pb-20 mobile:px-2">
        <div class="p-5">
            <livewire:home.directors :title="__('home.directors_title')" />
        </div>
    </section>
</x-layouts.site>
