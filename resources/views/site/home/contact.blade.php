@php($contact = $page->section('contact'))
<section class="pt-24 pb-32 tablet:pt-20 tablet:pb-20 mobile:pt-13 mobile:pb-13 contact-setcion">
    <div class="container-sm">
        <div class="text-center">
            @if ($contact->text('kicker'))
                <h5 class="mb-3">{{ $contact->text('kicker') }}</h5>
            @endif
            <h2 class="mb-12 tablet:mb-6">{!! $contact->text('heading') !!}</h2>
            @if ($contact->text('text'))
                <p class="mb-8">{!! $contact->text('text') !!}</p>
            @endif
            <x-home.contact-icons />
        </div>
    </div>
</section>
