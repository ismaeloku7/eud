{{-- Card of a resource: the image block shared by grids, plus the detailed
     list-view block when $details is on (resources listing). --}}
@props(['resource', 'details' => false])
@php
    $url = route('resources.show', ['slug' => $resource->slug]);
    $firstFile = $resource->files->first();
@endphp
<div class="our-ressources text-primary">
    <a class="relative image-section block aspect-square" href="{{ $url }}">
        <img src="{{ \App\Support\Media::url($resource->image, 'images/resources-placeholder.png') }}" alt="{{ $resource->title }}" loading="lazy">
        @if ($resource->collection)
            <div class="absolute highlighted">{{ __('resources.collection') }}</div>
        @endif
        <div class="event-category fix-list-ul">
            <ul>
                @foreach ($resource->categories->take(3) as $category)
                    <li><div>{{ $category->name }}</div></li>
                @endforeach
            </ul>
        </div>
        <span class="white-circle-arrow"><img src="{{ asset('images/circle-arrow.png') }}" alt=""></span>
    </a>
    <div class="flex items-center justify-between gap-4 grid-view-block">
        <h5><a href="{{ $url }}">{{ $resource->title }}</a></h5>
        <div class="flex items-center gap-1 shrink-0">
            <img src="{{ asset('images/Download_Icon.png') }}" alt="">
            <p>{{ $resource->quantity }}</p>
        </div>
    </div>
    @if ($details)
        <div class="flex items-center justify-between list-view-block mobile:px-4">
            <h5><a href="{{ $url }}">{{ $resource->title }}</a></h5>
            @if ($resource->subtitle)
                <h6 class="block">{{ $resource->subtitle }}</h6>
            @endif
            @if ($resource->description)
                <div class="mobile:text-justify">
                    {!! Str::limit(strip_tags($resource->description), 600) !!}
                    @if (mb_strlen(strip_tags($resource->description)) > 600)
                        <a class="text-medium_blue hover:text-blue" href="{{ $url }}">{{ __('resources.read_more') }}</a>
                    @endif
                </div>
            @endif
            <div class="inline-block items-center ressources-feachers text-right w-full">
                <x-resources.feature icon="images/Download_Icon-2.png" :text="$resource->quantity.' '.__('resources.downloads')" />
                @if ($resource->pages)
                    <x-resources.feature icon="images/book-ic.png" :text="$resource->pages.' '.__('resources.pages')" />
                @endif
                @if ($firstFile?->size)
                    <x-resources.feature icon="images/file-size-ic.png" :text="$firstFile->humanSize()" />
                @endif
                @if ($firstFile?->type)
                    <x-resources.feature icon="images/pdf-ic.png" :text="$firstFile->type->name" />
                @endif
                @if ($resource->author)
                    <x-resources.feature icon="images/user-ic.png" :text="$resource->author" :max="120" />
                @endif
            </div>
        </div>
    @endif
</div>
