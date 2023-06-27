@props([
    'id',
    'show' => false,
    'maxWidth' => '2xl'
])
 
@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp
 
<div
    id="{{ $id }}"
    data-controller="modal"
    data-modal-overlay-class="overflow-y-hidden"
    data-modal-open-value="{{ $show ? 'true' : 'false' }}"
    data-modal-focusable-value="{{ $attributes->has('focusable') ? 'true' : 'false' }}"
    data-action="
        close->modal#close
        keydown.esc@window->modal#close
        keydown.shift+tab->modal#hijackFocus:prevent
        keydown.tab->modal#hijackFocus:prevent
        turbo:before-cache@window->modal#closeNow
    "
    class="{{ $show ? '' : 'hidden' }} fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
>
    <div
        data-action="click->modal#close"
        data-modal-target="overlay"
        class="{{ $show ? '' : 'hidden' }} fixed inset-0 transform transition-all"
        data-transition-enter="ease-out duration-300"
        data-transition-enter-start="opacity-0"
        data-transition-enter-end="opacity-100"
        data-transition-leave="ease-in duration-200"
        data-transition-leave-start="opacity-100"
        data-transition-leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>
 
    <div
        class="{{ $show ? '' : 'hidden' }} mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
        data-modal-target="content"
        data-transition-enter="ease-out duration-300"
        data-transition-enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        data-transition-enter-end="opacity-100 translate-y-0 sm:scale-100"
        data-transition-leave="ease-in duration-200"
        data-transition-leave-start="opacity-100 translate-y-0 sm:scale-100"
        data-transition-leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        {{ $slot }}
    </div>
</div>