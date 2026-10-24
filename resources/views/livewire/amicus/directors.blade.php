<div>
    @if ($this->countries->isNotEmpty() && ($selected = $this->selected))
        @php($director = $selected->directors->first())
        @php($office = $selected->office)
        <div class="pt-24 bg-secondary mobile:pt-12 mobile:pb-12 pb-28 tablet:pb-20">
            <div class="youth-directors">
                <div class="container-md">
                    <h5 class="text-center uppercase mb-18 mobile:mb-7">{{ __('amicus.your_directors') }}</h5>
                    <div class="flex flex-wrap overflow-hidden bg-grey rounded-xl">
                        <div class="pt-10 w-48p tablet:w-full bg-medium_grey px-14 pb-18 mobile:py-8 mobile:px-5 right-arrow">
                            <h3 class="mb-6 text-lightten_grey"><strong>{{ __('amicus.choose_country') }}</strong></h3>
                            <select wire:model.live="country" aria-label="{{ __('amicus.choose_country') }}">
                                @foreach ($this->countries as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @if ($selected->image)
                                <img src="{{ \App\Support\Media::url($selected->image) }}" alt="{{ $selected->name }}">
                            @endif
                        </div>
                        <div class="py-10 w-52p tablet:w-full px-22 mobile:text-center desktop_large:px-14 mobile:py-8 mobile:px-5">
                            <h3 class="mb-10 mobile:mb-6 text-lightten_grey mobile:text-center"><strong>{{ $selected->name }}</strong></h3>
                            <div class="pb-12 mobile:pb-7 text-lightten_grey">
                                {!! $director?->description ?: $office?->description !!}
                            </div>
                            <div class="flex flex-wrap -mx-5 our-team">
                                @if ($director)
                                    <div class="w-1/2 px-5 mobile:w-full mobile:text-center">
                                        @if ($director->photo)
                                            <img src="{{ \App\Support\Media::url($director->photo) }}" alt="{{ $director->name }}" class="img-rounded">
                                        @endif
                                        <h6>{{ $director->name }}</h6>
                                        <p>{{ $director->charge }}</p>
                                        <ul>
                                            @if ($director->linkedin)
                                                <li><a href="{{ $director->linkedin }}" target="_blank" rel="noopener"><img src="{{ asset('images/blue-linkedin-ic.svg') }}" alt="LinkedIn"></a></li>
                                            @endif
                                            @if ($director->twitter)
                                                <li><a href="{{ $director->twitter }}" target="_blank" rel="noopener"><img src="{{ asset('images/blue-twitter-ic.svg') }}" alt="X"></a></li>
                                            @endif
                                            @if ($director->email)
                                                <li><a href="mailto:{{ $director->email }}"><img src="{{ asset('images/blue-mail-icon.svg') }}" alt="Email"></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                                @if ($office)
                                    <div class="w-1/2 px-5 mobile:w-full mobile:text-center">
                                        <div style="height: 180px;width: 150px;margin-bottom: 1rem;"></div>
                                        <h6>{{ $office->title }}</h6>
                                        <p>
                                            @if ($office->website)
                                                <a href="{{ $office->website }}" target="_blank" rel="noopener">{{ $office->website }}</a><br>
                                            @endif
                                            @if ($office->email)
                                                <a href="mailto:{{ $office->email }}">{{ $office->email }}</a>
                                            @endif
                                        </p>
                                        <ul>
                                            @if ($office->linkedin)
                                                <li><a href="{{ $office->linkedin }}" target="_blank" rel="noopener"><img src="{{ asset('images/blue-linkedin-ic.svg') }}" alt="LinkedIn"></a></li>
                                            @endif
                                            @if ($office->twitter)
                                                <li><a href="{{ $office->twitter }}" target="_blank" rel="noopener"><img src="{{ asset('images/blue-twitter-ic.svg') }}" alt="X"></a></li>
                                            @endif
                                            @if ($office->email)
                                                <li><a href="mailto:{{ $office->email }}"><img src="{{ asset('images/blue-mail-icon.svg') }}" alt="Email"></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
