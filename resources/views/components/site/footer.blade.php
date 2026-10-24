@php
    $brand = $site->settings('brand');
    $contact = $site->settings('contact');
@endphp
<footer class="pb-20 text-sm text-white mobile:pb-13 bg-footer_bg pt-13 mobile:text-center">
    <div class="container">
        <div class="flex flex-wrap justify-between">
            <div class="f-logo tablet:w-full tablet:mb-6">
                <img src="{{ asset('images/footer-logo.png') }}" alt="{{ config('app.name') }}">
            </div>
            <div class="flex flex-wrap mobile:w-full footer-text">
                @if ($brand->text('footer'))
                    <p>{!! $brand->text('footer') !!}</p>
                @else
                    <p>
                        <strong>Youth Ministries Department</strong><br>
                        Inter-European Division of SDA<br>
                        {{ $contact->text('address', 'Schosshaldenstr. 17, 3006 Bern, Switzerland') }}
                    </p>
                @endif
                <p class="self-start">
                    <a href="mailto:{{ $contact->text('email', 'youth@eud.adventist.org') }}">{{ $contact->text('email', 'youth@eud.adventist.org') }}</a>
                    <br>
                    {{ $contact->text('phone', 'Phone +41-31-359-1515') }}
                </p>
                <div class="footer-social">
                    <x-site.social-icons class="size-icon-footer" />
                </div>
            </div>
        </div>
    </div>
</footer>

@push('styles')
    <style>
        .footer-social { padding-top: 2rem; }
        @media (max-width: 767px) {
            .footer-text p br { display: block; }
            body:not(.home) { padding-top: 70px; }
        }
    </style>
@endpush
