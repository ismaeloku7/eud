@php($act = $page->section('act'))
<div class="pt-16 pb-16 bg-secondary">
    <div class="container text-center mobile:px-6">
        <h2 class="mb-12"><strong>{!! $act->text('title', __('amicus.act_title')) !!}</strong></h2>
        <div class="py-2">{!! $act->text('description_top', __('amicus.act_description_top')) !!}<br></div>
        <img class="inline-block mb-10" src="{{ $act->url('image') ?? asset('images/jed-villejo-bEcC0nyIp2g-unsplash.png') }}" alt="">
        <h3 class="inline-block w-full max-w-3xl mb-0 text-4xl tablet:text-3xl mobile:text-2xl text-green_900"><strong>{!! $act->text('quote', __('amicus.act_quote')) !!}</strong></h3>
    </div>
</div>
<div class="pt-16 px-3 py-3 grey-paraghaph">{!! $act->text('description', __('amicus.act_description')) !!}</div>
<x-amicus.resource-grid :ids="$act->ids('resources')" />
