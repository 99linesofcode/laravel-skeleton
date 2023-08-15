<form action="{{ ($chirp ?? false) ? route('chirps.update', $chirp) : route('chirps.store') }}" method="POST">
    @if ($chirp ?? false)
        @method('PUT')
    @endif

    <textarea
        name="message"
        placeholder="What's on your mind?"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
    >{{ $chirp->message ?? '' }}</textarea>
    <x-input-error :messages="$errors->get('message')" class="mt-2" />

    <div class="flex items-center justify-start space-x-2">
        <x-primary-button class="mt-4">
            {{ __('Chirp') }}
        </x-primary-button>

        @if ($chirp ?? false)
        <a href="{{ route('chirps.index') }}" class="mt-4">Cancel</a>
        @endif
    </div>
</form>
