<div>
    @if ($countries->isNotEmpty() && $selected)
        <div class="youth-directors">
            <div class="container-lg mobile:px-0">
                <h5 class="mb-16 text-center mobile:mb-8">{{ $title }}</h5>
                <div class="flex flex-wrap overflow-hidden rounded-xl bg-grey">
                    <div class="right-arrow w-48p bg-medium_grey px-14 pb-18 pt-10 tablet:w-full mobile:px-5 mobile:py-8">
                        <h3 class="mb-6 text-lightten_grey"><strong>{{ __('home.choose_country') }}</strong></h3>
                        <select wire:model.live="country" aria-label="{{ __('home.choose_country') }}">
                            @foreach ($countries as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @if ($selected->image)
                            <img src="{{ App\Support\Media::url($selected->image) }}" alt="{{ $selected->name }}">
                        @endif
                    </div>
                    <div class="w-52p px-28 py-10 desktop_extralarge:px-18 desktop_large:px-14 tablet:w-full mobile:px-5 mobile:py-8">
                        <h3 class="mb-10 text-lightten_grey mobile:mb-6 mobile:text-center"><strong>{{ $selected->name }}</strong></h3>
                        <div class="our-team -mx-5 flex flex-wrap">
                            @foreach ($directors as $director)
                                <div class="mb-16 w-1/2 px-5 desktop_large:mb-8 mobile:mb-5 mobile:w-full mobile:text-center">
                                    <div class="mx-auto h-32 w-32 overflow-hidden rounded-full bg-medium_grey sm:mx-0">
                                        @if ($director->photo)
                                            <img class="h-full w-full object-cover" src="{{ App\Support\Media::url($director->photo) }}" alt="{{ $director->name }}">
                                        @endif
                                    </div>
                                    <h6>{{ $director->name }}</h6>
                                    <p>{{ $director->charge }}</p>
                                    <ul>
                                        @if ($director->instagram)
                                            <li>
                                                <a href="{{ $director->instagram }}" target="_blank" rel="noopener" aria-label="Instagram">
                                                    <div class="size-icon-maps relative inline-block">
                                                        <svg class="center-absolute" style="fill: #fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                                                    </div>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($director->email)
                                            <li>
                                                <a href="mailto:{{ $director->email }}" aria-label="{{ $director->email }}">
                                                    <div class="size-icon-maps relative inline-block">
                                                        <svg class="center-absolute" style="fill: #fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 64C490.5 64 512 85.49 512 112C512 127.1 504.9 141.3 492.8 150.4L275.2 313.6C263.8 322.1 248.2 322.1 236.8 313.6L19.2 150.4C7.113 141.3 0 127.1 0 112C0 85.49 21.49 64 48 64H464zM217.6 339.2C240.4 356.3 271.6 356.3 294.4 339.2L512 176V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V176L217.6 339.2z"/></svg>
                                                    </div>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endforeach

                            @if ($office)
                                <div class="w-1/2 px-5 mobile:mb-5 mobile:w-full mobile:text-center">
                                    <div class="contact-info mt-5 border-t-2 border-solid border-body_text pt-10">
                                        <h6><strong>{{ $office->title }}</strong></h6>
                                        <p class="break-words">
                                            @if ($office->phone)
                                                <a class="block" href="tel:{{ preg_replace('/[^\d+]/', '', $office->phone) }}">{{ $office->phone }}</a>
                                            @endif
                                            @if ($office->website)
                                                <a class="block" href="{{ Str::startsWith($office->website, ['http://', 'https://']) ? $office->website : 'https://'.$office->website }}" target="_blank" rel="noopener">{{ $office->website }}</a>
                                            @endif
                                        </p>
                                        <div class="break-words">
                                            <ul>
                                                @if ($office->facebook)
                                                    <li>
                                                        <a href="{{ $office->facebook }}" target="_blank" rel="noopener" aria-label="Facebook">
                                                            <div class="size-icon-maps relative inline-block">
                                                                <svg class="center-absolute" style="fill: #fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if ($office->instagram)
                                                    <li>
                                                        <a href="{{ $office->instagram }}" target="_blank" rel="noopener" aria-label="Instagram">
                                                            <div class="size-icon-maps relative inline-block">
                                                                <svg class="center-absolute" style="fill: #fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if ($office->email)
                                                    <li>
                                                        <a href="mailto:{{ $office->email }}" aria-label="{{ $office->email }}">
                                                            <div class="size-icon-maps relative inline-block">
                                                                <svg class="center-absolute" style="fill: #fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 64C490.5 64 512 85.49 512 112C512 127.1 504.9 141.3 492.8 150.4L275.2 313.6C263.8 322.1 248.2 322.1 236.8 313.6L19.2 150.4C7.113 141.3 0 127.1 0 112C0 85.49 21.49 64 48 64H464zM217.6 339.2C240.4 356.3 271.6 356.3 294.4 339.2L512 176V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V176L217.6 339.2z"/></svg>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
