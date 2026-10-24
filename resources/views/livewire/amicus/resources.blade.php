<div class="amicus-resources">
    <div class="ressources-searchbar pb-8 pt-9 mobile:pb-0">
        <div class="container-xl mobile:px-6">
            <div class="flex flex-wrap items-center justify-between">
                <h2 class="m-0 w-full pb-4 xl:w-auto xl:pb-0"><strong>{{ __('amicus.resources_title') }}</strong></h2>
                <div class="search-bar flex items-center">
                    <div class="search-field">
                        <input type="search" wire:model.live.debounce.400ms="search" placeholder="{{ __('amicus.search') }}" aria-label="{{ __('amicus.search') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="our-ressources-wrapper px-3 py-3" wire:loading.class="opacity-50">
        <div class="flex flex-wrap pt-3 -mx-4 pb-18 mobile:pb-12">
            @forelse ($resources as $resource)
                <x-amicus.resource-card :resource="$resource" />
            @empty
                <p class="w-full px-4 text-center text-light_grey">{{ __('amicus.no_resources') }}</p>
            @endforelse
        </div>
        <div class="px-4">
            {{ $resources->links() }}
        </div>
    </div>
</div>
