{{-- Selector of days or workshop slots, wrapping so every option stays visible: $items (key => label), $selected, $select (Livewire method), optional $align (start|end). --}}
<div @class(['day-switcher', 'day-switcher--start' => ($align ?? 'end') === 'start'])>
    @foreach ($items as $key => $label)
        @php($label = is_array($label) ? $label['label'] : $label)
        @php($isSelected = (string) $key === (string) $selected)
        <button type="button" wire:click="{{ $select }}('{{ $key }}')" wire:key="day-{{ $select }}-{{ $key }}" @class(['is-selected' => $isSelected]) @if ($isSelected) aria-current="true" @endif>
            <b class="{{ $isSelected ? 'text-white' : 'theme-color-title' }} fs-18">{{ $label }}</b>
        </button>
    @endforeach
</div>
