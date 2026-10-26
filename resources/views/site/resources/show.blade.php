@php
    use App\Support\Media;

    // Languages offered by the resource's own files; collection items pick theirs in a modal.
    $languageOptions = $resource->files
        ->filter(fn ($file) => $file->language)
        ->unique('language_id')
        ->map(fn ($file) => ['id' => $file->language_id, 'name' => (string) $file->language->name])
        ->values();

    $related = $resource->related->count() > 0
        ? $resource->related
        : \App\Models\Resource::query()
            ->whereKeyNot($resource->id)
            ->whereHas('categories', fn ($q) => $q->whereIn('category_resources.id', $resource->categories->pluck('id')))
            ->whereHas('files')
            ->with('categories', 'files')
            ->take(4)
            ->get();
@endphp
<x-layouts.site :title="$resource->title" :description="Str::limit(strip_tags((string) $resource->description), 160)">
    <div id="resource-page" data-language="{{ $languageOptions->first()['id'] ?? '' }}">
        <div class="ressources-searchbar mb-4 pt-9">
            <div class="container-xl mobile:px-6">
                <div class="mb-30 flex flex-wrap items-center justify-between tablet:mb-20 mobile:mb-8">
                    <h2 class="mb-0 tablet:mb-7 tablet:w-full">
                        <strong>
                            <a href="{{ route('resources.index') }}">{{ __('resources') }}</a>
                            <span>/</span>
                            <span class="inline-block">{{ $resource->title }}</span>
                        </strong>
                    </h2>
                </div>
            </div>
        </div>

        <div class="resources-detail-wrapper">
            <div class="container-xl mobile:px-6">
                <div class="-mx-12 mb-28 flex flex-wrap desktop:-mx-6 tablet:mb-20 mobile:mb-14">
                    <div class="w-1/2 px-12 desktop:px-6 tablet:mb-20 tablet:w-full mobile:mb-12">
                        <div class="single-image relative mb-20 tablet:mb-12">
                            <img src="{{ Media::url($resource->image, 'images/resources-placeholder.png') }}" alt="{{ $resource->title }}">
                            <div class="event-category fix-list-ul">
                                <ul>
                                    @foreach ($resource->categories->take(3) as $category)
                                        <li><div>{{ $category->name }}</div></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @if ($resource->legend)
                            <blockquote><h2>{!! $resource->legend !!}</h2></blockquote>
                        @endif
                    </div>
                    <div class="w-1/2 px-12 desktop:px-6 tablet:w-full">
                        <div class="max-w-1.5xl">
                            <h1 class="mb-0 text-40p leading-snug text-primary mobile:text-3xl"><strong>{{ $resource->title }}</strong></h1>
                            @if ($resource->subtitle)
                                <h6>{{ $resource->subtitle }}</h6>
                            @endif
                            <div class="mobile:text-justify">{!! $resource->description !!}</div>

                            @if ($languageOptions->isNotEmpty())
                                <div class="my-8 flex items-center mobile:mb-11 mobile:flex-wrap mobile:justify-center">
                                    <form class="mobile:mb-2" action="" onsubmit="return false">
                                        <select class="js-language" aria-label="{{ __('resources.choose_language') }}">
                                            @foreach ($languageOptions as $option)
                                                <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                    @unless ($resource->collection)
                                        @foreach ($resource->files as $file)
                                            <div class="js-file mobile:mb-2" data-language="{{ $file->language_id }}" hidden>
                                                @if ($file->url)
                                                    <a class="btn hover:bg-primary hover:text-white" href="{{ $file->url }}" target="_blank" rel="noopener">{{ __('resources.go_to_web') }}</a>
                                                @else
                                                    <form method="post" action="{{ route('resources.download', [$resource, $file]) }}">
                                                        @csrf
                                                        <button type="submit" class="btn hover:bg-primary hover:text-white">{{ __('resources.download') }}</button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endunless
                                </div>
                            @endif

                            @unless ($resource->collection)
                                <h5>{{ __('resources.document_details') }}</h5>
                                <div class="document-detail rounded-xl bg-secondary px-6 pb-2 pt-4">
                                    @foreach ($resource->files as $file)
                                        @if ($file->type)
                                            <div class="-mx-4 flex js-file" data-language="{{ $file->language_id }}" hidden>
                                                <div class="w-1/2 self-end px-4">
                                                    <div class="flex items-center border-b-2 border-solid border-grey_300 py-2 font-medium">
                                                        <img class="mr-3 h-4 w-4" src="{{ asset('images/pdf-ic.png') }}" alt="">{{ __('resources.file_type') }}
                                                    </div>
                                                </div>
                                                <div class="w-1/2 self-end px-4">
                                                    <div class="border-b-2 border-solid border-grey_300 py-2 font-medium">{{ $file->type->name }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if ($resource->pages)
                                        <div class="-mx-4 flex">
                                            <div class="w-1/2 self-end px-4">
                                                <div class="flex items-center border-b-2 border-solid border-grey_300 py-2 font-medium">
                                                    <img class="mr-3 h-4 w-4" src="{{ asset('images/book-ic.png') }}" alt="">{{ __('resources.pages_label') }}
                                                </div>
                                            </div>
                                            <div class="w-1/2 self-end px-4">
                                                <div class="border-b-2 border-solid border-grey_300 py-2 font-medium">{{ $resource->pages }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    @foreach ($resource->files as $file)
                                        @if ($file->size)
                                            <div class="-mx-4 flex js-file" data-language="{{ $file->language_id }}" hidden>
                                                <div class="w-1/2 self-end px-4">
                                                    <div class="flex items-center border-b-2 border-solid border-grey_300 py-2 font-medium">
                                                        <img class="mr-3 h-4 w-4" src="{{ asset('images/file-size-ic.png') }}" alt="">{{ __('resources.size') }}
                                                    </div>
                                                </div>
                                                <div class="w-1/2 self-end px-4">
                                                    <div class="border-b-2 border-solid border-grey_300 py-2 font-medium">{{ $file->humanSize() }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if ($resource->author)
                                        <div class="-mx-4 flex">
                                            <div class="w-1/2 self-end px-4">
                                                <div class="flex items-center border-b-2 border-solid border-grey_300 py-2 font-medium">
                                                    <img class="mr-3 h-4 w-4" src="{{ asset('images/user-ic.png') }}" alt="">{{ __('resources.author') }}
                                                </div>
                                            </div>
                                            <div class="w-1/2 self-end px-4">
                                                <div class="border-b-2 border-solid border-grey_300 py-2 font-medium">{{ $resource->author }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="-mx-4 flex">
                                        <div class="w-1/2 self-end px-4">
                                            <div class="flex items-center py-2 font-medium">
                                                <img class="mr-3 h-4 w-4" src="{{ asset('images/Download_Icon-2.png') }}" alt="">{{ __('resources.downloads_label') }}
                                            </div>
                                        </div>
                                        <div class="w-1/2 self-end px-4">
                                            <div class="py-2 font-medium">{{ $resource->quantity }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endunless
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($resource->collection && $resource->items->isNotEmpty())
            <div class="projects" x-data="{ downloads: null }" @keydown.escape.window="downloads = null">
                <div class="container-xl mobile:px-6">
                    <h2 class="mb-7"><strong>{{ __('resources.in_this_collection') }}</strong></h2>
                    <div class="flex flex-wrap mb-20 -mx-4 mobile:mb-7">
                        @foreach ($resource->items as $item)
                            <div class="w-1/4 px-4 mb-8 desktop:w-1/2 mobile:w-full">
                                <div class="our-ressources">
                                    <div class="relative image-section">
                                        <img src="{{ Media::url($item->image, 'images/resources-placeholder.png') }}" alt="{{ $item->title }}" loading="lazy">
                                        <div class="absolute top-0 bottom-0 left-0 right-0 flex flex-wrap items-center justify-center invisible transition-all opacity-0 place-content-center project-download">
                                            <a class="my-2 btn hover:bg-primary hover:text-white mobile:mb-3" href="{{ route('resources.show', ['slug' => $item->slug]) }}">{{ __('resources.learn_more') }}</a>
                                            @if ($item->files->isNotEmpty())
                                                <br>
                                                <button type="button" class="my-2 btn hover:bg-primary hover:text-white mobile:mb-3" @click="downloads = {{ $item->id }}">{{ __('resources.download') }}</button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between grid-view-block">
                                        <h5><a href="{{ route('resources.show', ['slug' => $item->slug]) }}">{{ $item->title }}</a></h5>
                                        <div class="flex items-center">
                                            <img src="{{ asset('images/Download_Icon.png') }}" alt="">
                                            <p>{{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @foreach ($resource->items->filter(fn ($item) => $item->files->isNotEmpty()) as $item)
                    <div class="fixed inset-0 z-40 flex items-center justify-center px-4" x-show="downloads === {{ $item->id }}" x-cloak style="background-color: rgba(0, 0, 0, .6);" @click="downloads = null" role="dialog" aria-modal="true" aria-labelledby="downloads-title-{{ $item->id }}">
                        <div class="w-full max-w-lg rounded-xl bg-white p-8 mobile:p-6" style="max-height: 90vh; overflow-y: auto;" @click.stop>
                            <div class="mb-6 flex items-start justify-between gap-4">
                                <div>
                                    <h4 id="downloads-title-{{ $item->id }}" class="mb-1 text-primary"><strong>{{ $item->title }}</strong></h4>
                                    <p class="mb-0 text-primary">{{ __('resources.choose_download_language') }}</p>
                                </div>
                                <button type="button" class="shrink-0" @click="downloads = null" aria-label="{{ __('resources.close') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 26 26">
                                        <g fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                            <path d="M1.5 1.499l23 23M24.5 1.499l-23 23" />
                                        </g>
                                    </svg>
                                </button>
                            </div>
                            <ul>
                                @foreach ($item->files->sortBy(fn ($file) => (string) $file->language?->name) as $file)
                                    <li class="flex items-center justify-between gap-4 border-b-2 border-solid border-grey_300 py-3 last:border-b-0">
                                        <div class="min-w-0 text-primary">
                                            <strong>{{ $file->language?->name ?? __('resources.download') }}</strong>
                                            <span class="block whitespace-nowrap text-sm">{{ collect([$file->type?->name, $file->size ? $file->humanSize() : null])->filter()->join(' · ') }}</span>
                                        </div>
                                        @if ($file->url)
                                            <a class="shrink-0 whitespace-nowrap rounded-btn bg-medium_blue px-5 py-2 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-primary" href="{{ $file->url }}" target="_blank" rel="noopener">{{ __('resources.go_to_web') }}</a>
                                        @else
                                            <form method="post" action="{{ route('resources.download', [$item, $file]) }}" class="shrink-0">
                                                @csrf
                                                <button type="submit" class="shrink-0 whitespace-nowrap rounded-btn bg-medium_blue px-5 py-2 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-primary">{{ __('resources.download') }}</button>
                                            </form>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($related->isNotEmpty())
            <div class="pb-10 related-ressources">
                <div class="container-xl mobile:px-6">
                    <h2 class="mb-7"><strong>{{ __('resources.you_may_also_like') }}</strong></h2>
                    <div class="flex flex-wrap -mx-4 mb-14 mobile:mb-7">
                        @foreach ($related->take(4) as $item)
                            <div class="w-1/4 px-4 mb-8 desktop:w-1/2 mobile:w-full">
                                <x-resources.card :resource="$item" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('styles')
        <style>
            [x-cloak] { display: none !important; }

            @media (max-width: 767px) {
                .event-category ul li { width: auto; }
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            (function () {
                const page = document.getElementById('resource-page');
                const select = page.querySelector('.js-language');
                const files = Array.from(page.querySelectorAll('.js-file'));

                function show(language) {
                    files.forEach((el) => { el.hidden = el.dataset.language !== String(language); });
                }

                show(page.dataset.language);
                if (select) select.addEventListener('change', (event) => show(event.target.value));
            })();
        </script>
    @endpush
</x-layouts.site>
