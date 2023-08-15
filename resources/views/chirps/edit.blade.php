<x-app-layout :title="__('Edit Chirp')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('chirps.index') }}" class="underline underline-offset-2 text-indigo-600">Chirps</a>
            <span class="text-gray-300">/</span>
            {{ __('Edit Chirp #:id', ['id' => $chirp->id]) }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <x-turbo-frame :id="$chirp" target="_top">
          @include('chirps._form', ['chirp' => $chirp])
        </x-turbo-frame>
    </div>
</x-app-layout>
