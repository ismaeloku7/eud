@php
    $starting = $page->section('starting');
    $tips = __('amicus.tips');
@endphp
<div class="pt-16 pb-32 mobile:pt-13 mobile:pb-13 tablet:pb-18 bg-secondary">
    <div class="container-md mobile:px-6">
        <div class="px-6 mobile:px-0">
            <div class="flex flex-wrap -mx-6 grey-paraghaph">
                <div class="w-1/2 px-6 tablet:mb-13 tablet:w-full">
                    <div class="pr-18 mobile:pr-0">
                        <h2 class="mb-8 font-black mobile:text-center">{!! $starting->text('title', __('amicus.starting_title')) !!}</h2>
                        <div class="mobile:text-justify">{!! $starting->text('description', __('amicus.starting_description')) !!}</div>
                    </div>
                </div>
                <div class="w-1/2 px-6 tablet:w-full mobile:px-0">
                    <x-amicus.video :url="$starting->raw('video_url')" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center w-full max-w-5.5xl mx-auto px-4 mobile:px-6 relative mt-30 mobile:mt-10">
    <div class="relative mb-16 text-center mobile:mb-5 tree-line">
        <div class="relative tree-graph-line">
            <h3 class="relative inline-block px-10 mb-0 bg-white pb-13"><strong>{!! $starting->text('tips_title', __('amicus.tips_title')) !!}</strong></h3>
            <span class="text-center absolute top-12 left-0 right-0 m-auto w-3/4 mobile:w-4/5">{!! $starting->text('tips_description', __('amicus.tips_description')) !!}</span>
        </div>
    </div>
</div>
{{-- tips desktop --}}
<div class="hidden lg:flex flex-wrap mb-10">
    @foreach ($tips as $key => $tip)
        <div class="w-1/5 p-4 pt-8 text-center text-white bg-purple h-80 flex flex-col justify-start items-center {{ $key % 2 == 0 ? 'opacity-60' : 'opacity-80' }}">
            <img class="inline-block w-24 h-24" src="{{ asset('images/iconos/'.($key + 1).'.svg') }}" alt="">
            <h2 class="my-5"><strong>{{ $key + 1 }}.</strong></h2>
            <p class="text-md font-bold text-white">{!! $tip !!}</p>
        </div>
    @endforeach
</div>
{{-- tips mobile (slick) --}}
<div class="flex lg:hidden flex-wrap mb-10 places-starting mt-12">
    @foreach ($tips as $key => $tip)
        <div class="w-full p-4 pt-8 text-center text-white bg-purple h-80 flex flex-col justify-start items-center {{ $key % 2 == 0 ? 'opacity-60' : 'opacity-80' }}">
            <img class="inline-block w-24 h-24 mx-auto" src="{{ asset('images/iconos/'.($key + 1).'.svg') }}" alt="">
            <h2 class="my-5"><strong>{{ $key + 1 }}.</strong></h2>
            <p class="text-md font-bold text-white">{!! $tip !!}</p>
        </div>
    @endforeach
</div>
<div class="pt-24 pb-22 mobile:pt-13 mobile:pb-13">
    <h2 class="text-center mb-14 mobile:px-6"><strong>{!! $starting->text('resources_title', __('amicus.resources_to_help')) !!}</strong></h2>
    <x-amicus.resource-grid :ids="$starting->ids('resources')" class="pt-4" />
</div>
