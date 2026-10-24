@php
    $contact = $page->section('contact');
    $details = $site->settings('contact');
@endphp
<x-layouts.site :title="__('contact')">
    <section class="pt-24 pb-32 tablet:pt-20 tablet:pb-20 mobile:pt-13 mobile:pb-13 contact-setcion">
        <div class="container-sm">
            <div class="text-center">
                <h5 class="mb-3">{{ $contact->text('kicker', $site->settings('navigation')->text('contact', __('contact'))) }}</h5>
                <h2 class="mb-12 tablet:mb-6">{!! $contact->text('heading', __('home.contact_heading')) !!}</h2>
                @if ($contact->text('text'))
                    <p class="mb-8">{!! $contact->text('text') !!}</p>
                @endif
                <p class="mb-8">
                    @if ($details->text('address'))
                        {{ $details->text('address') }}<br>
                    @endif
                    <a href="mailto:{{ $details->text('email', 'youth@eud.adventist.org') }}">{{ $details->text('email', 'youth@eud.adventist.org') }}</a>
                    @if ($details->text('phone'))
                        <br>{{ $details->text('phone') }}
                    @endif
                </p>
                <x-home.contact-icons />
            </div>
        </div>
    </section>
</x-layouts.site>
