{{-- Grid of resource cards picked in the page editor (a list of resource ids). --}}
@props(['ids' => [], 'title' => null])
@php
    $ids = array_values(array_filter((array) $ids));
    $resources = $ids === []
        ? collect()
        : \App\Models\Resource::query()->whereIn('id', $ids)->with('files.type', 'files.language', 'categories')->get()->sortBy(fn ($r) => array_search($r->id, $ids))->values();
@endphp
@if ($resources->isNotEmpty())
    <div {{ $attributes->merge(['class' => 'pt-16 our-ressources-wrapper px-3 py-3']) }}>
        <div class="flex flex-wrap pt-3 -mx-4 pb-18 mobile:pb-12">
            @if ($title)
                <div class="w-full px-4"><h4 class="mb-6">{{ $title }}</h4></div>
            @endif
            @foreach ($resources as $resource)
                <x-amicus.resource-card :resource="$resource" />
            @endforeach
        </div>
    </div>
@endif
