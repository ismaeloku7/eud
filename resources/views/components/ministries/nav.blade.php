@props(['ministry'])
<div class="ressources-searchbar pb-8 pt-9 mobile:pb-0">
    <div class="container-xl mobile:px-6">
        <div class="flex flex-wrap items-center justify-between">
            <h2 class="m-0 w-full pb-4 xl:w-auto xl:pb-0"><strong><span>{{ __('ministries') }}</span></strong></h2>
            <ul class="category-main-nav flex pl-0 desktop_large:flex-wrap mobile:block mobile:justify-start mobile:text-center">
                @foreach ($site->ministries() as $item)
                    <li @class(['active' => $item->is($ministry), 'mobile:mb-[13px] mobile:ml-auto mobile:mr-auto mobile:mt-0' => $item->is($ministry), 'mobile:mb-[0px] mobile:ml-auto mobile:mr-auto mobile:mt-0' => ! $item->is($ministry)])>
                        <a href="{{ route('ministries.show', ['slug' => $item->slug]) }}">
                            {{ $item->slug === 'amicus' ? __('ministries.amicus_members') : $site->menuName($item) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@push('styles')
    <style>
        @media (max-width: 767px) {
            .category-main-nav { max-width: 316px; margin-left: auto; margin-right: auto; }
            .category-main-nav li { margin-left: 0; margin-right: 0; }
        }
        @media (max-width: 360px) {
            .category-main-nav { max-width: 230px; margin-left: auto; margin-right: auto; justify-content: space-between; }
        }
    </style>
@endpush
