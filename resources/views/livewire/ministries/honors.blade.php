@php
    $banner = [
        'cachorros' => 'images/cachorros-madrid-emaús.jpg',
        'adventurers' => 'images/resources/adventures/a2.jpg',
    ][$ministry->slug] ?? 'images/honor-banner.png';
    $label = in_array($ministry->slug, ['cachorros', 'adventurers']) ? __('ministries.awards') : __('ministries.honors');
@endphp
<div>
    @if ($view === 'index')
        <section class="grey-paraghaph bg-secondary pb-48 tablet:pb-30 mobile:pb-16">
            <div class="container-xl desktop_extralarge:pl-[50px] desktop_extralarge:pr-[50px] desktop:px-10 tablet:px-6">
                <div class="honor-banner relative overflow-hidden rounded-xl">
                    <img class="h-full w-full object-cover desktop:h-72" src="{{ asset($banner) }}" alt="">
                    <h1><strong>{{ $label }}</strong></h1>
                </div>
                <div class="pt-13 mobile:pt-11">
                    <div class="-mx-12 flex flex-wrap desktop:-mx-6">
                        <div class="w-1/2 px-12 desktop_large:mb-16 desktop:w-full desktop:px-6 mobile:mb-8">
                            <p class="mobile:text-justify">{!! __('ministries.honors_intro.'.$ministry->slug) !!}</p>
                        </div>
                        <div class="search-honor w-1/2 px-12 desktop:w-full desktop:px-6">
                            <h5 class="mb-6 uppercase text-primary"><strong>{{ __('ministries.search_for', ['items' => $label]) }}</strong></h5>
                            <form wire:submit="searchHonors">
                                <div class="select flex items-center mobile-small:flex-wrap">
                                    <label for="honor-category">{{ __('ministries.category') }}</label>
                                    <select id="honor-category" wire:model="filterCategory">
                                        <option value="">{{ __('ministries.select_category') }}</option>
                                        @foreach ($categoryOptions as $option)
                                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="select flex items-center mobile-small:flex-wrap">
                                    <label for="honor-class">{{ __('ministries.grade_class') }}</label>
                                    <select id="honor-class" wire:model="filterClass">
                                        <option value="">{{ __('ministries.select_class') }}</option>
                                        @foreach ($classOptions as $option)
                                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="select flex items-center mobile-small:flex-wrap">
                                    <label for="honor-master">{{ __('ministries.master_award') }}</label>
                                    <select id="honor-master" wire:model="filterMasterAward">
                                        <option value="">{{ __('ministries.select_master_award') }}</option>
                                        @foreach ($masterAwardOptions as $option)
                                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-center mobile-small:flex-wrap">
                                    <label for="honor-search">{{ __('ministries.name') }}</label>
                                    <input id="honor-search" type="search" placeholder="{{ __('ministries.search_placeholder') }}" wire:model="search">
                                </div>
                                <div class="flex items-center mobile-small:flex-wrap">
                                    <label>{{ __('ministries.level') }}</label>
                                    <div class="flex mobile:flex-wrap">
                                        @foreach ($levelOptions as $option)
                                            <div class="radio">
                                                <input id="level-{{ $option->id }}" type="checkbox" wire:click="toggleLevel('{{ $option->id }}')" @checked($filterLevel === (string) $option->id)>
                                                <label for="level-{{ $option->id }}">{{ $option->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mb-0 mt-9 flex items-center justify-between mobile:justify-center">
                                    <input class="btn" type="submit" value="{{ __('ministries.search') }}">
                                    @if ($this->hasFilters())
                                        <a class="p-0 font-medium text-title mobile:hidden" href="javascript:void(0);" wire:click="clearFilters">{{ __('clean filters') }}</a>
                                    @endif
                                </div>
                                @if ($this->hasFilters())
                                    <a class="hidden p-0 text-center font-medium text-title mobile:block" href="javascript:void(0);" wire:click="clearFilters">{{ __('clean filters') }}</a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-secondary pb-30 mobile:pb-12">
            <div class="container-xl mobile:px-6">
                @forelse ($categories as $category)
                    <div class="flex justify-between mobile:mb-6 mobile:flex-wrap">
                        <h5 class="mb-4 font-medium uppercase text-primary mobile:mb-2 mobile:w-full">
                            <strong>{{ __('ministries.category') }}: {{ $category->name }}<br></strong>
                            ({{ trans_choice('ministries.honors_count', $category->honors_count, ['count' => $category->honors_count]) }})
                        </h5>
                        @if ($category->honors_count > 5)
                            <a class="tracking-wide text-medium_blue hover:text-medium_blue hover:underline" href="javascript:void(0);" wire:click="showCategory({{ $category->id }})">
                                {{ __('ministries.show_all', ['items' => $label]) }}
                                <img class="inline-block" src="{{ asset('images/Pfeil.png') }}" alt="">
                            </a>
                        @endif
                    </div>
                    <div class="-mx-3 flex flex-wrap pb-11">
                        @foreach ($category->honors->take(5) as $honor)
                            <x-ministries.honor-card :honor="$honor" :color="$category->color" />
                        @endforeach
                    </div>
                @empty
                    <p class="text-center text-primary">{{ __('ministries.no_honors') }}</p>
                @endforelse
            </div>
        </section>
    @elseif ($view === 'results')
        <section class="grey-paraghaph bg-secondary pb-14 mobile:pb-12">
            <div class="container-md mobile:px-6">
                <div class="search-result flex items-center gap-3 border-t border-solid border-dark_border pt-9 mobile:border-0">
                    <div class="back-to-overview">
                        <a href="javascript:void(0);" wire:click="goBack"><img src="{{ asset('images/blue-prev-arrow.png') }}" alt="{{ __('ministries.back') }}"></a>
                    </div>
                    <div class="pt-4">
                        <h5 class="mb-4 font-medium uppercase text-primary mobile:mb-2 mobile:w-full">
                            <strong>{{ $selectedCategory?->name ?? __('ministries.search_results') }}</strong>
                        </h5>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-secondary pb-30 mobile:pb-12">
            <div class="container-xl mobile:px-6">
                <div class="-mx-3 flex flex-wrap pb-11">
                    @forelse ($results as $honor)
                        <x-ministries.honor-card :honor="$honor" :color="$honor->category?->color" />
                    @empty
                        <p class="w-full px-3 text-primary">{{ __('ministries.no_results') }}</p>
                    @endforelse
                </div>
                @if ($results->hasPages())
                    <div class="pb-5">{{ $results->links() }}</div>
                @endif
            </div>
        </section>
    @elseif ($view === 'show' && $honor)
        @php($pdf = $honor->pdfs->first(fn ($file) => (string) $file->language_id === $pdfLanguage) ?? $honor->pdfs->first())
        <section class="grey-paraghaph bg-secondary pb-40 desktop:pb-30 mobile:pb-12">
            <div class="container-md mobile:px-6">
                <div class="search-result flex items-center gap-3 border-t border-solid border-dark_border pt-9 mobile:border-0">
                    <div class="back-to-overview">
                        <a href="javascript:void(0);" wire:click="goBack"><img src="{{ asset('images/blue-prev-arrow.png') }}" alt="{{ __('ministries.back') }}"></a>
                    </div>
                </div>
            </div>
            <div class="container-xl tablet:px-6 desktop:px-10 desktop_extralarge:pr-[50px] desktop_extralarge:pl-[50px]">
                <div class="flex flex-wrap -mx-12 desktop:-mx-6">
                    <div class="w-1/2 px-12 tablet:w-full desktop_large:mb-16 mobile:mb-8 desktop:px-6">
                        <h2 class="mb-7 mobile:mt-8"><strong>{{ $honor->name }}</strong></h2>
                        <div class="mb-12">{!! $honor->description !!}</div>
                        <h5 class="mb-1 uppercase text-primary"><strong>{{ __('ministries.info') }}</strong></h5>
                        <div class="px-6 pt-4 pb-2 bg-white document-detail rounded-xl">
                            @foreach ([
                                [__('ministries.category'), $honor->category?->name],
                                [__('ministries.master_award'), $honor->masterAward?->name],
                                [__('ministries.level'), $honor->level?->name],
                                [__('ministries.class'), $honor->classHonor?->name],
                            ] as [$rowLabel, $rowValue])
                                @if ($rowValue)
                                    <div class="flex -mx-4">
                                        <div class="w-1/2 px-4"><div class="flex items-center py-2 font-medium border-b-2 border-solid text-primary border-grey_300">{{ $rowLabel }}</div></div>
                                        <div class="w-1/2 px-4"><div class="py-2 font-medium border-b-2 border-solid text-primary border-grey_300">{{ $rowValue }}</div></div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/2 px-12 tablet:w-full desktop:px-6">
                        <div class="relative px-8 text-center bg-white border-solid rounded-xl py-30 mobile:py-12 honor-detail-block" style="border-color: {{ $honor->category?->color }}">
                            @if ($honor->classHonor)
                                <span class="absolute top-0 inline-block px-5 py-3 mb-6 text-xs font-black text-center left-10 bg-grey_300">{{ $honor->classHonor->name }}</span>
                            @endif
                            <img class="inline-block" src="{{ \App\Support\Media::url($honor->image) }}" alt="{{ $honor->name }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white pt-22 pb-36 tablet:pb-22 mobile:pt-13 mobile:pb-13">
            <div class="container-md mobile:px-6">
                <h5 class="mb-5 uppercase text-primary"><strong>{{ __('ministries.requirements') }}</strong></h5>
                <div class="flex flex-wrap -mx-12 tablet:-mx-6">
                    <div class="requirements-text w-1/2 px-12 tablet:px-6 tablet:w-full tablet:mb-6">{!! $honor->requirements !!}</div>
                </div>
                @if ($honor->url)
                    <a class="btn mt-8 inline-block" href="{{ $honor->url }}" target="_blank" rel="noopener">{{ __('ministries.more_info') }}</a>
                @endif
            </div>
        </section>
        @if ($pdf)
            <section class="pt-16 bg-secondary pb-30 mobile:pt-13 mobile:pb-13">
                <div class="container-md mobile:px-6">
                    <h6 class="mb-2"><strong>{{ $pdf->name ?: $honor->name }}</strong></h6>
                    <div class="flex flex-wrap -mx-11 tablet:-mx-6">
                        <div class="w-1/2 px-11 tablet:px-6 mobile:w-full">
                            <img class="mb-4 rounded-xl" src="{{ asset('images/libro-con-sector-gris.png') }}" alt="">
                            <div class="download-document">
                                <select wire:model.live="pdfLanguage">
                                    @foreach ($honor->pdfs as $file)
                                        <option value="{{ $file->language_id }}">{{ $file->language?->name }}</option>
                                    @endforeach
                                </select>
                                <br>
                                <a class="inline-block mt-3 align-top text-medium_blue hover:underline hover:text-medium_blue" href="{{ \App\Support\Media::url($pdf->file) }}" download="{{ $honor->name }}-{{ $pdf->language?->name }}">
                                    <img class="inline-block mr-1" src="{{ asset('images/Download_Icon_blue.svg') }}" alt="">
                                    {{ __('download') }} {{ $pdf->size ? \Illuminate\Support\Number::fileSize((int) $pdf->size) : '' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
</div>
