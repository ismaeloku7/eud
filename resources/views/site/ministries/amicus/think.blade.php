@php($think = $page->section('think'))
<div class="pt-16 pb-16 bg-secondary">
    <div class="container text-center mobile:px-6">
        <h2 class="mb-12"><strong>{!! $think->text('title', __('amicus.think_title')) !!}</strong></h2>
        <img class="inline-block mb-10" src="{{ $think->url('image') ?? asset('images/jed-villejo-bEcC0nyIp2g-unsplash.png') }}" alt="">
        <h3 class="inline-block w-full max-w-3xl mb-0 text-4xl tablet:text-3xl mobile:text-2xl text-green_900"><strong>{!! $think->text('content', __('amicus.think_quote')) !!}</strong></h3>
    </div>
</div>
<x-amicus.resource-grid :ids="$think->ids('resources')" :title="__('amicus.recommended_resources')" />
