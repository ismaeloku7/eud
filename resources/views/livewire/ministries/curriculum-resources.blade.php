<div>
    @if ($this->resources->isNotEmpty())
        <h6><strong>{{ __('ministries.resources') }}</strong></h6>
        <div class="-mx-3 mb-10 flex max-w-2xl flex-wrap">
            @foreach ($this->resources as $resource)
                @php($file = $resource->files->first(fn ($f) => $f->id === (int) ($selectedFiles[$resource->id] ?? 0)) ?? $resource->files->first())
                <div class="w-1/3 px-3 mobile:mb-4 mobile:w-1/2">
                    <img class="mb-2" src="{{ \App\Support\Media::url($resource->image) }}" alt="{{ $resource->title }}">
                    <h6><strong>{{ Str::limit($resource->title, 18) }}</strong></h6>
                    @if ($file)
                        <div class="download-document">
                            <select wire:model.live="selectedFiles.{{ $resource->id }}" aria-label="{{ __('language') }}">
                                @foreach ($resource->files as $option)
                                    <option value="{{ $option->id }}">{{ $option->language?->name }}</option>
                                @endforeach
                            </select>
                            <br>
                            <a class="mt-3 inline-block align-top text-medium_blue hover:text-medium_blue hover:underline" href="{{ $file->url ?: \App\Support\Media::url($file->file) }}" target="_blank" rel="noopener">
                                <img class="mr-1 inline-block" src="{{ asset('images/Download_Icon_blue.svg') }}" alt="">
                                {{ __('download') }} {{ $file->humanSize() }}
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
