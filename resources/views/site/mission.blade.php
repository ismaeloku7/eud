@php($intro = $page->section('intro'))
<x-layouts.site :title="__('mission')">
    <section class="pt-8 pb-32 tablet:pt-5 tablet:pb-18 mobile:pb-13 contact-setcion">
        <div class="container-sm mobile:px-6">
            <div class="text-center">
                <h5 class="mb-2">{{ $intro->text('kicker') }}</h5>
                <h2 class="mb-12 mobile:mb-6">{!! $intro->text('heading') !!}</h2>
                <div class="text-center mobile:text-justify">{!! $intro->text('text') !!}</div>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            @media (max-width: 767px) {
                .contact-setcion h2 { font-size: 1.3rem; font-weight: 600; }
            }
        </style>
    @endpush
</x-layouts.site>
