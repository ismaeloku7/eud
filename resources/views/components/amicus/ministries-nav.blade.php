{{-- Top navigation between ministries (legacy partials/ministries-nav). --}}
@props(['ministry'])
<div class="ressources-searchbar pb-8 pt-9 mobile:pb-0">
    <div class="container-xl mobile:px-6">
        <div class="flex flex-wrap items-center justify-between">
            <h2 class="m-0 w-full pb-4 xl:w-auto xl:pb-0"><strong><span>{{ __('amicus.ministries') }}</span></strong></h2>
            <ul class="category-main-nav flex pl-0 desktop_large:flex-wrap mobile:block mobile:justify-start mobile:text-center">
                @foreach ($site->ministries() as $item)
                    <li @class(['active mobile:mb-[13px]' => $item->is($ministry), 'mobile:mb-[0px]' => ! $item->is($ministry), 'mobile:ml-auto mobile:mr-auto mobile:mt-0'])>
                        <a href="{{ route('ministries.show', ['slug' => $item->slug]) }}">{{ $site->menuName($item) }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
