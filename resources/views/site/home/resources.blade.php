@if ($featured->isNotEmpty())
    <section class="ressources-section pt-13 pb-18 mobile:pb-10">
        <h5 class="mb-12 text-center">{{ Str::upper($site->settings('navigation')->text('resources', __('home.resources'))) }}</h5>
        <div class="relative">
            <div class="ressources-slider">
                @foreach ($featured as $resource)
                    <div class="our-ressources">
                        <div class="relative image-section">
                            <img src="{{ App\Support\Media::url($resource->image, 'images/placeholder-resource.png') }}" alt="{{ $resource->title }}">
                            <div class="like-event">
                                <img src="{{ asset('images/like-ic.svg') }}" alt="">
                            </div>
                            <div class="event-category">
                                <ul>
                                    @foreach ($resource->categories->take(3) as $category)
                                        <li class="break-words">{{ $category->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <a class="white-circle-arrow" href="{{ route('resources.show', ['slug' => $resource->slug]) }}" aria-label="{{ $resource->title }}">
                                <img src="{{ asset('images/circle-arrow.png') }}" alt="">
                            </a>
                        </div>
                        <h5>{{ $resource->title }}</h5>
                    </div>
                @endforeach
            </div>
            <div class="absolute z-10 mobile:left-4 more-events top-1/2 right-6 mobile:mt-5 mobile:relative mobile:right-auto mobile:top-auto">
                <a href="{{ route('resources.index') }}">
                    {{ __('home.more') }}
                    <img src="{{ asset('images/right-blue-arrow.svg') }}" alt="">
                </a>
            </div>
        </div>
    </section>
@endif
