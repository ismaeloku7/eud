@php($be = $page->section('be'))
<div class="pt-16 pb-16 bg-secondary">
    <div class="container text-center mobile:px-6">
        <h2 class="mb-12"><strong>{!! $be->text('title', __('amicus.be_title')) !!}</strong></h2>
        <img class="inline-block mb-10" src="{{ $be->url('image') ?? asset('images/photo-1536010447069-d2c8af80c584.png') }}" alt="">
        <h4>{!! $be->text('description', __('amicus.be_description')) !!}</h4>
        <h3 class="inline-block w-full max-w-3xl mb-0 text-4xl tablet:text-3xl mobile:text-2xl text-green_900"><strong>{!! $be->text('quote', __('amicus.be_quote')) !!}</strong></h3>
    </div>
</div>
@if ($be->items('blocks') !== [])
    <div class="pt-26 mobile:pt-16 pb-30 mobile:pb-13 grey-paraghaph">
        <div class="flex flex-wrap -mx-18 desktop_medium:-mx-10 tablet:-mx-5">
            @foreach ($be->items('blocks') as $block)
                <div class="w-full px-18 desktop_medium:px-10 tablet:px-5 tablet:mb-10">
                    <h2 class="mb-6"><strong>{!! $block->text('title') !!}</strong></h2>
                    <div class="mobile:text-justify mb-2" style="margin-bottom: 35px;">{!! $block->text('description') !!}</div>
                    <x-amicus.resource-grid :ids="$block->ids('resources')" :title="__('amicus.recommended_resources')" class="px-0" />
                </div>
            @endforeach
        </div>
    </div>
@endif
