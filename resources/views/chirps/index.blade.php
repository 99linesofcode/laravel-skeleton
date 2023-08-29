<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chirps') }}
        </h2>
    </x-slot>

    <x-turbo-stream-from source="chirps" />

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
      <x-turbo-frame id="create_chirp" src="{{ route('chirps.create') }}">
        <div class="relative flex items-center justify-center py-10 px-4 rounded-lg border border-dotted border-gray-300">
            <a class="text-gray-700" href="{{ route('chirps.create') }}">
                Add a new Chirp
                <span class="absolute inset-0"></span>
            </a>
        </div>
      </x-turbo-frame>

      <div id="chirps" class="mt-6 bg-white shadow-sm rounded-lg divide-y">
          @each('chirps._chirp', $chirps, 'chirp')
      </div>
    </div>
</x-app-layout>
