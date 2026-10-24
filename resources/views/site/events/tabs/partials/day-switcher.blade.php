{{-- Horizontal selector of days or workshop slots: $items (key => label), $selected, $select and $shift (Livewire methods). --}}
<div class="day-switcher">
    @if (count($items) > 1)
        <button type="button" class="arrow" wire:click="{{ $shift }}(-1)" aria-label="{{ __('events.previous') }}">
            <svg class="mx-2 self-center" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.710938 10.1473L19.4653 0.222095V20.0726L0.710938 10.1473Z" fill="#45CDFC" /></svg>
        </button>
    @endif
    <div class="days">
        @foreach ($items as $key => $label)
            @php($label = is_array($label) ? $label['label'] : $label)
            <button type="button" wire:click="{{ $select }}('{{ $key }}')" wire:key="day-{{ $select }}-{{ $key }}" class="cursor-pointer">
                <b class="{{ (string) $key === (string) $selected ? 'text-medium_blue' : 'theme-color-title' }} fs-22 mobile:fs-20">{{ $label }}</b>
            </button>
        @endforeach
    </div>
    @if (count($items) > 1)
        <button type="button" class="arrow" wire:click="{{ $shift }}(1)" aria-label="{{ __('events.next') }}">
            <svg class="mx-2 self-center" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.2451 10.1476L0.49077 20.0728L0.49077 0.222323L19.2451 10.1476Z" fill="#45CDFC" /></svg>
        </button>
    @endif
</div>
