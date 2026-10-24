{{-- YouTube embed; accepts watch, youtu.be or embed URLs (legacy embedYouTubeURL). --}}
@props(['url' => null, 'default' => 'https://www.youtube.com/embed/vOxX8S-rtaY', 'height' => 315])
@php
    $src = $url ?: $default;
    if (preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $src, $m)) {
        $src = 'https://www.youtube.com/embed/'.$m[4];
    }
@endphp
<iframe {{ $attributes->merge(['width' => 560, 'height' => $height]) }} src="{{ $src }}" title="YouTube video player" frameborder="0"
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
