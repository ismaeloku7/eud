{{-- Contact block of the legacy page (the old form had no backend either). --}}
@props(['kicker' => null, 'title'])
<div {{ $attributes->merge(['class' => 'pb-26 pt-26 text-center mobile:pb-13 mobile:pt-13']) }}>
    <div class="contact-us mobile:px-6">
        @if ($kicker)
            <h5 class="mb-2 uppercase text-medium_blue">{{ $kicker }}</h5>
        @endif
        <h2 class="mb-14 font-black mobile:mb-6"><strong>{{ $title }}</strong></h2>
        <form action="{{ route('contact') }}" method="get">
            <input type="text" name="name" placeholder="{{ __('amicus.form_name') }}">
            <input type="email" name="email" placeholder="{{ __('amicus.form_email') }}">
            <input type="text" name="country" placeholder="{{ __('amicus.form_country') }}">
            <textarea name="message" placeholder="{{ __('amicus.form_message') }}" cols="30" rows="10"></textarea>
            <div class="checkbox mb-4 text-left">
                <input type="checkbox" id="amicus-terms-{{ $title }}">
                <label for="amicus-terms-{{ $title }}">{!! __('amicus.form_terms') !!}</label>
            </div>
            <div class="checkbox mb-16 text-left mobile:mb-9">
                <input type="checkbox" id="amicus-privacy-{{ $title }}">
                <label for="amicus-privacy-{{ $title }}">{!! __('amicus.form_privacy') !!}</label>
            </div>
            <input class="btn border border-solid border-medium_blue" type="submit" value="{{ __('amicus.form_send') }}">
        </form>
    </div>
</div>
