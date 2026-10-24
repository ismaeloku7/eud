@php($encounter = $page->section('encounter'))
<div class="pt-16 pb-16 bg-secondary">
    <div class="container text-center mobile:px-6">
        <h2 class="mb-12"><strong>{!! $encounter->text('title', __('amicus.encounter_title')) !!}</strong></h2>
        <img class="inline-block mb-10" src="{{ $encounter->url('image') ?? asset('images/jed-villejo-bEcC0nyIp2g-unsplash.png') }}" alt="">
        <h3 class="inline-block w-full max-w-3xl mb-0 text-4xl tablet:text-3xl mobile:text-2xl text-green_900"><strong>{!! $encounter->text('content', __('amicus.encounter_quote')) !!}</strong></h3>
    </div>
</div>
<x-amicus.resource-grid :ids="$encounter->ids('resources')" :title="__('amicus.recommended_resources')" />
