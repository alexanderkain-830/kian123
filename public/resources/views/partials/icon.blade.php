@php
$paths = [
    'search' => '<circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/>',
    'trash'  => '<path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13"/>',
    'pencil' => '<path d="M4 20l4-1 11-11-3-3L5 16z"/>',
    'receipt'=> '<path d="M6 3h12v18l-3-2-3 2-3-2-3 2z"/><path d="M9 8h6M9 12h6"/>',
    'plus'   => '<path d="M12 5v14M5 12h14"/>',
    'close'  => '<path d="M6 6l12 12M18 6L6 18"/>',
    'chevron'=> '<path d="M6 9l6 6 6-6"/>',
];
@endphp
<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $paths[$n] !!}</svg>
