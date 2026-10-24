@php($mission = $page->section('mission'))
<section class="contact-setcion pb-32 pt-8 tablet:pb-18 tablet:pt-5 mobile:px-6 mobile:pb-13">
    <div class="container-sm mobile:px-0">
        <div class="mission-home text-center">
            <h5 class="mb-2">{{ $mission->text('kicker') }}</h5>
            <h2 class="mb-12 mobile:mb-6">{!! $mission->text('heading') !!}</h2>
            <p id="content-resource-mission">{!! $mission->text('text') !!}</p>
            @if ($mission->text('button'))
                <div class="btn-wrapper mt-18 mobile:mt-9">
                    <a class="btn btn-mission hover:bg-body_text hover:text-white" href="https://vividfaith.com" target="_blank" rel="noopener">
                        {{ $mission->text('button') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

@push('styles')
    <style>
        #content-resource-mission a { color: cornflowerblue; }
        .btn-mission { width: 18rem; }
        @media (max-width: 767px) {
            .mission-home h2 br { display: none; }
            .mission-home h2 { font-size: 1.3rem; }
            #content-resource-mission { text-align: justify; }
            .btn-mission { width: 17rem; border-radius: 1rem; font-size: 1rem; }
        }
    </style>
@endpush
