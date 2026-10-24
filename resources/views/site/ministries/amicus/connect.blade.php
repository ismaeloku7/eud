@php($connect = $page->section('connect'))
<div class="bg-secondary pb-16 pt-16">
    <div class="container text-center mobile:px-6">
        <h2 class="mb-12"><strong>{!! $connect->text('title', __('amicus.connect_title')) !!}</strong></h2>
        <img class="mb-10 inline-block" src="{{ $connect->url('image') ?? asset('images/photo-1536010447069-d2c8af80c584.png') }}" alt="">
        <h3 class="text-green_900 mb-0 inline-block w-full max-w-3xl text-4xl tablet:text-3xl mobile:text-2xl"><strong>{!! $connect->text('quote', __('amicus.connect_quote')) !!}</strong></h3>
    </div>
</div>
<div class="grey-paraghaph pb-30 pt-26 mobile:pb-13 mobile:pt-16">
    <div class="container-md mobile:px-6">
        <div class="-mx-18 flex flex-wrap desktop_medium:-mx-10 tablet:-mx-5">
            <div class="w-1/2 px-18 desktop_medium:px-10 tablet:mb-10 tablet:w-full tablet:px-5">
                <h2 class="mb-6"><strong>{{ __('amicus.connect_events') }}</strong></h2>
                <div class="max-w-xl mobile:text-justify">
                    <p class="mb-2 max-w-xl mobile:text-justify" style="margin-bottom: 35px;">{{ __('amicus.connect_events_text') }}</p>
                </div>
                <div class="amicus-event overflow-hidden rounded-xl">
                    <div class="amicus-event-image relative">
                        <a href="https://amicuscongress.com/" target="_blank" rel="noopener">
                            <img class="w-full" src="{{ asset('images/1080x1080-Insta.jpg') }}" alt="AMiCUS Congress">
                            <div class="amicus-event-title absolute right-0 top-0 z-10 flex h-full w-full items-end bg-opacity-60">
                                <h5 class="relative font-bold tracking-normal text-white">AMiCUS Congress</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-1/2 px-18 desktop_medium:px-10 tablet:w-full tablet:px-5">
                <h2 class="mb-6"><strong>{{ __('amicus.pcm_day') }}</strong></h2>
                <p class="max-w-xl mobile:text-justify">{{ __('amicus.pcm_day_text') }}</p>
                <div class="amicus-event overflow-hidden rounded-xl">
                    <div class="amicus-event-image relative mt-6">
                        <a href="https://www.gcyouthministries.org/events-and-projects/pcm-day/" target="_blank" rel="noopener">
                            <img class="w-full" src="{{ asset('images/IG.jpg') }}" alt="World PCM Day">
                            <div class="amicus-event-title absolute right-0 top-0 z-10 flex h-full w-full items-end bg-opacity-60">
                                <h5 class="relative font-bold tracking-normal text-white">{{ __('amicus.pcm_day') }}</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-secondary pb-28 pt-28 tablet:pb-20 tablet:pt-20 mobile:pb-12 mobile:pt-12">
    <div class="youth-directors">
        <div class="container-md mobile:px-6">
            <div class="mb-19 grey-paraghaph px-14 mobile:px-0">
                <h2 class="mb-5"><strong>{!! $connect->text('local_chapter_title', __('amicus.local_chapter_title')) !!}</strong></h2>
                <div style="margin-bottom:30px;">{!! $connect->text('local_chapter_description', __('amicus.local_chapter_description')) !!}</div>
                <div class="flex w-full">
                    <a class="btn btn-text-start mobile:mx-auto mobile:text-base" href="{{ route('resources.index') }}">{{ __('amicus.get_started') }}</a>
                </div>
            </div>
        </div>
    </div>
    <livewire:amicus.directors :ministry="$ministry" />
</div>
<div>
    <div class="grey-paraghaph my-24 text-center mobile:mt-13 mobile:px-6">
        <h2 class="mb-0 mobile:text-2xl"><strong>{{ __('amicus.social_title') }}</strong></h2>
        <p class="mb-10 mobile:mb-7">{{ __('amicus.social_text') }}</p>
        <ul class="m-0 flex list-none justify-center p-0">
            <li class="mb-0 px-4 mobile:px-2">
                <a href="{{ $site->settings('contact')->raw('instagram') ?: 'https://www.instagram.com/eudyouth/' }}" target="_blank" rel="noopener"><img src="{{ asset('images/instagram.svg') }}" alt="Instagram"></a>
            </li>
            <li class="mb-0 px-4 mobile:px-2">
                <a href="{{ $site->settings('contact')->raw('facebook') ?: 'https://www.facebook.com/EUDyouthministries' }}" target="_blank" rel="noopener"><img src="{{ asset('images/face-book.svg') }}" alt="Facebook"></a>
            </li>
        </ul>
    </div>
</div>
<x-amicus.contact-form class="bg-secondary" :kicker="__('amicus.connect_with_us')" :title="__('amicus.help_us')" />
