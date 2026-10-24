@php
    $selectedCategory = $category === \App\Livewire\Resources\Index::COLLECTIONS ? __('resources.collection') : $categories->firstWhere('id', (int) $category)?->name;
    $selectedType = $types->firstWhere('id', (int) $type)?->name;
    $selectedLanguage = $languages->firstWhere('id', (int) $language)?->name;
@endphp
<div>
    <div class="ressources-searchbar mb-4 pt-9">
        <div class="container-xl mobile:px-6">
            <div class="mb-18 flex flex-wrap items-center justify-between mobile:mb-0">
                <h2 class="mb-0"><strong>{{ __('resources') }}</strong></h2>
                <div class="search-bar flex items-center">
                    @if ($this->hasFilters())
                        <p class="unselected cursor-pointer" wire:click="resetFilters">{{ __('all') }}</p>
                    @else
                        <p class="selected">{{ __('all') }}</p>
                    @endif
                    <div class="ministries">
                        <select class="cursor-pointer" wire:model.live="category" aria-label="{{ __('resources.category') }}">
                            <option value="">{{ __('resources.category') }}</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                            <option value="{{ \App\Livewire\Resources\Index::COLLECTIONS }}">{{ __('resources.collection') }}</option>
                        </select>
                    </div>
                    <div class="file-type">
                        <select class="cursor-pointer" wire:model.live="type" aria-label="{{ __('file type') }}">
                            <option value="">{{ __('file type') }}</option>
                            @foreach ($types as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="language">
                        <select class="cursor-pointer" wire:model.live="language" aria-label="{{ __('language') }}">
                            <option value="">{{ __('language') }}</option>
                            @foreach ($languages as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-field">
                        <input type="search" placeholder="{{ __('search') }}" wire:model.live.debounce.400ms="search" aria-label="{{ __('search') }}">
                    </div>
                </div>
            </div>
            <div class="filter-bar relative flex flex-wrap items-center justify-between">
                <div class="sort-by flex items-center">
                    <p>{{ __('sort') }}</p>
                    <select class="cursor-pointer" wire:model.live="sort" aria-label="{{ __('sort') }}">
                        <option value="">{{ __('resources.sort_az') }}</option>
                        <option value="desc">{{ __('resources.sort_za') }}</option>
                        <option value="newest">{{ __('resources.sort_newest') }}</option>
                        <option value="oldest">{{ __('resources.sort_oldest') }}</option>
                    </select>
                    <ul class="selected-filter flex">
                        @if ($selectedCategory)
                            <li>
                                {{ $selectedCategory }}
                                <a href="javascript:void(0);" wire:click="$set('category', '')" aria-label="{{ __('resources.remove_filter') }}"><img src="{{ asset('images/cancle-selection.png') }}" alt=""></a>
                            </li>
                        @endif
                        @if ($selectedType)
                            <li>
                                {{ $selectedType }}
                                <a href="javascript:void(0);" wire:click="$set('type', '')" aria-label="{{ __('resources.remove_filter') }}"><img src="{{ asset('images/cancle-selection.png') }}" alt=""></a>
                            </li>
                        @endif
                        @if ($selectedLanguage)
                            <li>
                                {{ $selectedLanguage }}
                                <a href="javascript:void(0);" wire:click="$set('language', '')" aria-label="{{ __('resources.remove_filter') }}"><img src="{{ asset('images/cancle-selection.png') }}" alt=""></a>
                            </li>
                        @endif
                    </ul>
                    <a class="clear-filter" href="javascript:void(0);" wire:click="resetFilters">{{ __('clean filters') }}</a>
                </div>
                <div class="view flex items-center mobile:hidden">
                    <p>{{ __('design') }}</p>
                    <ul class="flex items-center">
                        <li class="grid-view {{ $view === 'grid' ? '' : 'active' }}">
                            <a href="javascript:void(0);" wire:click="setView('grid')" aria-label="{{ __('resources.grid_view') }}">
                                <img class="active-view" src="{{ asset('images/grid-view.svg') }}" alt="">
                                <img class="normal-view" src="{{ asset('images/grid-view-active.svg') }}" alt="">
                            </a>
                        </li>
                        <li class="list-view {{ $view === 'list' ? '' : 'active' }}">
                            <a href="javascript:void(0);" wire:click="setView('list')" aria-label="{{ __('resources.list_view') }}">
                                <img class="active-view" src="{{ asset('images/list-view.svg') }}" alt="">
                                <img class="normal-view" src="{{ asset('images/list-view-active.svg') }}" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div @class(['our-ressources-wrapper', 'list-view-format' => $view === 'list']) wire:loading.class="opacity-50">
        <div class="container-xl mobile:px-6">
            @if ($resources->count() > 0)
                <div @class(['flex flex-wrap pt-3 -mx-4', 'pb-18 mobile:pb-12' => ! $resources->hasPages()])>
                    @foreach ($resources as $resource)
                        <div class="ressources-block mb-9" wire:key="resource-{{ $resource->id }}">
                            <x-resources.card :resource="$resource" :details="true" />
                        </div>
                    @endforeach
                </div>
                @if ($resources->hasPages())
                    <div class="pb-5">
                        {{ $resources->links() }}
                    </div>
                @endif
            @else
                <div class="flex flex-wrap pt-3 -mx-4 pb-18 mobile:pb-12">
                    <h4 class="text-center py-8 w-full">{{ __('no resources found') }}</h4>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            @media (max-width: 767px) { .our-ressources p { margin: 0; } }
            @media (max-width: 400px) {
                .search-bar p { width: 20%; margin: 0 0 .5rem; display: inline-block; }
                .search-bar .ministries { width: 48%; margin-left: auto; display: inline-block; }
                .search-bar .file-type, .search-bar .language { width: 48%; display: inline-block; }
                .search-bar .language { margin-left: auto; }
                .search-bar .search-field { margin-top: 0; }
                .sort-by p { display: inline-block; width: auto; margin-right: auto; }
                .sort-by select { width: 50%; display: inline-block; }
                .sort-by a { position: absolute; bottom: 0; right: 0; width: auto; margin-bottom: 0; }
                .our-ressources h5 { margin-left: 0; }
            }
        </style>
    @endpush
</div>
