@props(['ministry', 'tabs', 'tab'])
<div class="category-sub-nav amicus-sub-nav mb-13 bg-white pb-6 mobile:mb-9">
    <div class="container-xl">
        <div class="flex items-end justify-between mobile:items-start">
            <div class="mb-1 mt-2 pr-2 tablet:hidden"></div>
            <ul class="category-main-nav category-main-nav-2 flex justify-end self-center py-4 pl-0 desktop_extralarge:justify-start desktop_large:flex-wrap">
                @foreach ($tabs as $item)
                    <li @class(['active' => $item['slug'] === $tab])>
                        <a href="{{ $site->tabUrl($ministry, $item) }}">{{ __($item['name']) }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
