{{-- Information blocks ({title, content, column}) of the location and registration tabs. --}}
@foreach ($blocks ?? [] as $block)
    @php($title = \App\Pages\Translate::resolve($block['title'] ?? null))
    @php($contents = is_array($block['content'] ?? null) && array_is_list($block['content']) ? $block['content'] : [$block['content'] ?? null])
    @php($columns = max(1, (int) ($block['column'] ?? 1)))
    @if ($title !== '')
        <h3 class="text-center uppercase mb-8 pt-32 title-theme-900-space theme-color-title">{{ $title }}</h3>
    @endif
    <div class="-mx-16 desktop:-mx-7 m-0-auto w-full h4-default-theme theme_content_description">
        <div class="flex flex-wrap -mx-16">
            @foreach ($contents as $content)
                @php($text = \App\Pages\Translate::resolve($content))
                @if ($text !== '')
                    <div class="{{ $columns === 1 ? 'w-full' : 'w-1/'.$columns.' tablet:w-full' }} px-15 py-15 text-left fw-400 mobile:py-8">{!! $text !!}</div>
                @endif
            @endforeach
        </div>
    </div>
@endforeach
