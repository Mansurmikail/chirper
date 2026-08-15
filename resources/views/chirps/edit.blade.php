<x-layouts::app :title="__('Edit Chirp')">
    <div class="max-w-4xl mx-auto py-8 px-6">

        <h1 class="text-3xl font-bold mb-6">
            Edit Chirp
        </h1>

        <form method="POST" action="{{ route('chirps.update', $chirp) }}">
            @csrf
            @method('PATCH')

            <textarea
                name="message"
                rows="3"
                class="w-full rounded-lg border p-3"
            >{{ old('message', $chirp->message) }}</textarea>

            @error('message')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

            <button
                type="submit"
                class="mt-4 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
            >
                Save Changes
            </button>
        </form>

    </div>
</x-layouts::app>