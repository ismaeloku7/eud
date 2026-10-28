{{-- Site pagination for every Livewire listing: the result count on the left; previous, page numbers and next on the right. --}}
@php
    if (! isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoViewJsSnippet = ($scrollTo !== false)
        ? "(\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()"
        : '';
    $pageName = $paginator->getPageName();
    $buttonClass = 'inline-flex items-center gap-2 px-5 py-2 rounded-btn font-bold text-medium_blue bg-white border border-medium_blue hover:bg-medium_blue hover:text-white transition';
    $disabledClass = 'inline-flex items-center gap-2 px-5 py-2 rounded-btn font-bold text-gray-300 border border-gray-200 cursor-default';
@endphp

<div>
    @if ($paginator->hasPages())
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <p class="text-sm text-gray-500">{{ __('Showing :first to :last of :total results', ['first' => $paginator->firstItem(), 'last' => $paginator->lastItem(), 'total' => $paginator->total()]) }}</p>

        <nav role="navigation" aria-label="{{ __('pagination.navigation') }}" class="flex items-center justify-between gap-4">
            <div class="flex-1 flex justify-start">
                @if ($paginator->onFirstPage())
                    <span class="{{ $disabledClass }}" aria-disabled="true">&larr; {{ __('pagination.previous') }}</span>
                @else
                    <button type="button" wire:click="previousPage('{{ $pageName }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" rel="prev" class="{{ $buttonClass }}">&larr; {{ __('pagination.previous') }}</button>
                @endif
            </div>

            <div class="hidden md:flex items-center gap-1">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-2 text-gray-400" aria-disabled="true">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <span wire:key="paginator-{{ $pageName }}-page{{ $page }}">
                                @if ($page == $paginator->currentPage())
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full font-bold text-white bg-medium_blue" aria-current="page">{{ $page }}</span>
                                @else
                                    <button type="button" wire:click="gotoPage({{ $page }}, '{{ $pageName }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full font-bold text-primary hover:text-medium_blue transition" aria-label="{{ __('pagination.goto', ['page' => $page]) }}">{{ $page }}</button>
                                @endif
                            </span>
                        @endforeach
                    @endif
                @endforeach
            </div>

            <span class="md:hidden text-primary">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>

            <div class="flex-1 flex justify-end">
                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $pageName }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" rel="next" class="{{ $buttonClass }}">{{ __('pagination.next') }} &rarr;</button>
                @else
                    <span class="{{ $disabledClass }}" aria-disabled="true">{{ __('pagination.next') }} &rarr;</span>
                @endif
            </div>
        </nav>
        </div>
    @endif
</div>
