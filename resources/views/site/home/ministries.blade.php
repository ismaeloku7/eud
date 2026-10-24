<section class="pt-24 ministry-section pb-30 tablet:pt-18 tablet:pb-12 mobile:pt-13 mobile:pb-7">
    <div class="container text-center">
        <h5 class="mb-16 tablet:mb-12 mobile:mb-6">{{ Str::upper($site->settings('navigation')->text('ministries', __('home.ministries'))) }}</h5>
        <div class="flex flex-wrap">
            @foreach ($site->ministries() as $ministry)
                <a class="w-1/6 tablet:w-1/3 mobile:w-1/2 tablet:mb-6 cursor-pointer hover:opacity-60 no-underline"
                    href="{{ route('ministries.show', ['slug' => $ministry->slug]) }}">
                    <img src="{{ $site->logo($ministry) }}" alt="{{ $ministry->name }}">
                    <strong>{{ $site->menuName($ministry) }}</strong>
                </a>
            @endforeach
        </div>
    </div>
</section>
