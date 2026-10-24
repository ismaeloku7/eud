@props(['icon', 'text', 'max' => 250])
<div class="inline-block">
    <div class="flex items-center">
        <img src="{{ asset($icon) }}" alt="" style="width: 22px; height: 22px; object-fit: contain;">
        <p style="text-align: left; min-width: {{ min(mb_strlen((string) $text) * 11, $max) }}px; margin-left: 10px;">{{ $text }}</p>
    </div>
</div>
