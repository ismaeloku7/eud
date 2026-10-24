<div>
    @if ($this->countries->isNotEmpty() && $country)
        <div class="pt-24 mobile:pt-12 mobile:pb-12 bg-secondary pb-36 tablet:pb-20">
            <div class="youth-directors">
                <div class="mobile:container-md container-xl mobile:px-6">
                    @if ($title !== '')
                        <h5 class="mb-10 text-center uppercase mobile:mb-7">{{ $title }}</h5>
                    @endif
                    <div class="flex flex-wrap overflow-hidden bg-grey rounded-xl">
                        <div class="pt-10 w-48p tablet:w-full bg-medium_grey px-14 pb-18 mobile:py-8 mobile:px-5 right-arrow">
                            <h3 class="mb-6 text-lightten_grey"><strong>{{ __('choose country') }}</strong></h3>
                            <select wire:model.live="countryId" aria-label="{{ __('choose country') }}">
                                @foreach ($this->countries as $option)
                                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                                @endforeach
                            </select>
                            <img src="{{ \App\Support\Media::url($country->image, 'images/paises-default.png') }}" alt="{{ $country->name }}">
                        </div>
                        <div class="py-10 w-52p tablet:w-full px-22 desktop_large:px-14 mobile:py-8 mobile:px-5">
                            <h3 class="mb-10 mobile:mb-6 text-lightten_grey mobile:text-center"><strong>{{ $country->name }}</strong></h3>
                            <div class="flex flex-wrap -mx-5 our-team">
                                @foreach ($directors as $director)
                                    <div class="px-5 mobile:w-full mobile:text-center">
                                        <img src="{{ \App\Support\Media::url($director->photo, 'images/paises-default.png') }}" alt="{{ $director->name }}" class="img-rounded">
                                        <h6>{{ $director->name }}</h6>
                                        <p>{{ $director->type?->name ?: $director->charge }}</p>
                                        @if ($director->email)
                                            <p><a href="mailto:{{ $director->email }}" class="text-lightten_grey">{{ $director->email }}</a></p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @if ($withOffice && $office)
                                <div class="mt-10 text-lightten_grey office-details">
                                    <h6><strong>{{ $office->title }}</strong></h6>
                                    @if ($office->address)<p>{{ $office->address }}</p>@endif
                                    @if ($office->phone)<p>{{ $office->phone }}</p>@endif
                                    @if ($office->email)<p><a href="mailto:{{ $office->email }}">{{ $office->email }}</a></p>@endif
                                    @if ($office->website)
                                        <div class="w-full flex">
                                            <a class="mt-6 btn mobile:mx-auto mobile:text-base" href="{{ $office->website }}" target="_blank" rel="noopener">{{ __('ministries.learn_more') }}</a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <style>
                @media (max-width: 767px) { .youth-directors .btn { min-width: 200px; } }
            </style>
        </div>
    @endif
</div>
