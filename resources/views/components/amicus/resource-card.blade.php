@props(['resource'])
@php
    $url = route('resources.show', ['slug' => $resource->slug]);
    $file = $resource->files->first();
@endphp
<div class="ressources-block mb-9">
    <div class="our-ressources text-primary">
        <div class="relative image-section" onclick="window.location.assign('{{ $url }}');">
            <img src="{{ \App\Support\Media::url($resource->image, 'images/resources/manuals/Builder-banner.png') }}" alt="{{ $resource->title }}">
            @if ($resource->collection)
                <div class="absolute highlighted">{{ __('amicus.collection') }}</div>
            @endif
            <div class="event-category fix-list-ul">
                <ul>
                    @foreach ($resource->categories->take(3) as $category)
                        <li><div>{{ $category->name }}</div></li>
                    @endforeach
                </ul>
            </div>
            <a class="white-circle-arrow" href="{{ $url }}">
                <img src="{{ asset('images/circle-arrow.png') }}" alt="">
            </a>
        </div>
        <div class="flex items-center justify-between grid-view-block">
            <h5><a href="{{ $url }}">{{ $resource->title }}</a></h5>
            <div class="flex items-center">
                <img src="{{ asset('images/Download_Icon.png') }}" alt="">
                <p>{{ $resource->quantity }}</p>
            </div>
        </div>
        <div class="flex items-center justify-between list-view-block mobile:px-4">
            <h5><a href="{{ $url }}">{{ $resource->title }}</a></h5>
            @if ($resource->subtitle)
                <h6 class="block">{{ $resource->subtitle }}</h6>
            @endif
            @if ($resource->description)
                <div class="mobile:text-justify">{!! Str::limit(strip_tags($resource->description), 600) !!}</div>
            @endif
            <div class="inline-block items-center ressources-feachers text-right w-full">
                <div class="inline-block">
                    <div class="flex items-center">
                        <img src="{{ asset('images/Download_Icon-2.png') }}" alt="" style="width: 20px;height: 20px;object-fit: contain;">
                        <p style="margin-left: 10px;">{{ $resource->quantity }} {{ __('amicus.downloads') }}</p>
                    </div>
                </div>
                @if ($resource->pages)
                    <div class="inline-block">
                        <div class="flex items-center">
                            <img src="{{ asset('images/book-ic.png') }}" alt="" style="width: 22px;height: 22px;object-fit: contain;">
                            <p style="margin-left: 10px;">{{ $resource->pages }}</p>
                        </div>
                    </div>
                @endif
                @if ($file)
                    <div class="inline-block">
                        <div class="flex items-center">
                            <img src="{{ asset('images/file-size-ic.png') }}" alt="" style="width: 22px;height: 22px;object-fit: contain;">
                            <p style="margin-left: 10px;">{{ $file->humanSize() }}</p>
                        </div>
                    </div>
                    @if ($file->type)
                        <div class="inline-block">
                            <div class="flex items-center">
                                <img src="{{ asset('images/pdf-ic.png') }}" alt="" style="width: 22px;height: 22px;object-fit: contain;">
                                <p style="margin-left: 10px;">{{ $file->type->name }}</p>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($resource->author)
                    <div class="inline-block">
                        <div class="flex items-center">
                            <img src="{{ asset('images/user-ic.png') }}" alt="" style="width: 22px;height: 22px;object-fit: contain;">
                            <p style="margin-left: 10px;">{{ $resource->author }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
