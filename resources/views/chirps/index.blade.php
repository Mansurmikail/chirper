<x-layouts::app :title="__('Chirps')">
    <div class="max-w-4xl mx-auto py-8 px-6">

        <h1 class="text-3xl font-bold mb-2">
            Chirps
        </h1>

        
        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <p class="mb-6 text-gray-600">
            Total chirps: {{ $chirps->total() }}
        </p>

        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf

            <textarea
                name="message"
                rows="3"
                class="w-full rounded-lg border p-3"
                placeholder="What's on your mind?"
            >{{ old('message') }}</textarea>

            @error('message')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

            <button
                type="submit"
                class="mt-4 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
            >
                Chirp
            </button>
        </form>

        <hr class="my-8">

        <p class="mb-4 text-sm text-gray-500">
            Showing {{ $chirps->firstItem() }}–{{ $chirps->lastItem() }}
            of {{ $chirps->total() }} chirps
        </p>

        @foreach ($chirps as $chirp)

            <div class="mb-4 rounded-lg border p-4">

                <h3 class="font-semibold">
                    <a
                        href="{{ route('profile.show', $chirp->user) }}"
                        class="hover:underline"
                    >
                        {{ $chirp->user->name }}
                    </a>
                </h3>

                <p class="mt-2">
                    {{ $chirp->message }}
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    {{ $chirp->created_at->diffForHumans() }}
                </p>

                <div class="mt-4">
                @php
                    $liked = $chirp->likes()
                        ->where('user_id', auth()->id())
                        ->exists();
                @endphp

                <form
                    method="POST"
                    action="{{ route('chirps.like', $chirp) }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="rounded px-3 py-2 text-sm {{ $liked ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700' }}"
                    >
                        {{ $liked ? '♥ Unlike' : '♡ Like' }}
                    </button>
                </form>

                <span class="ml-2 text-sm text-gray-500">
                    {{ $chirp->likes()->count() }}
                    {{ Str::plural('like', $chirp->likes()->count()) }}
                </span>
            </div>


            <div class="mt-6 border-t pt-4">

                    <h4 class="font-semibold mb-3">
                        Comments ({{ $chirp->comments()->count() }})
                    </h4>

                    @foreach ($chirp->comments()->with('user')->latest()->get() as $comment)
                        <div class="mb-3 rounded-lg bg-gray-50 p-3">

                            <div class="flex justify-between">
                                <span class="font-semibold">
                                    {{ $comment->user->name }}
                                </span>

                                <span class="text-sm text-gray-500">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <p class="mt-1">
                                {{ $comment->body }}
                            </p>

                            @can('delete', $comment)
                        <form
                            method="POST"
                            action="{{ route('comments.destroy', $comment) }}"
                            class="mt-2"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="text-sm text-red-600 hover:underline"
                                onclick="return confirm('Delete this comment?')"
                            >
                                Delete
                            </button>
                        </form>
                    @endcan

                        </div>
                    @endforeach

                    <form
                        method="POST"
                        action="{{ route('comments.store', $chirp) }}"
                        class="mt-4"
                    >
                        @csrf

                        <textarea
                            name="body"
                            rows="2"
                            class="w-full rounded-lg border p-3"
                            placeholder="Write a comment..."
                        >{{ old('body') }}</textarea>

                        @error('body')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <button
                            type="submit"
                            class="mt-2 rounded bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700"
                        >
                            Comment
                        </button>
                    </form>

                </div>

                @can('update', $chirp)

                    <div class="mt-4 flex gap-2">

                        <a
                            href="{{ route('chirps.edit', $chirp) }}"
                            class="rounded bg-yellow-500 px-3 py-2 text-white hover:bg-yellow-600"
                        >
                            Edit
                        </a>

                        <form
                            action="{{ route('chirps.destroy', $chirp) }}"
                            method="POST"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="rounded bg-red-600 px-3 py-2 text-white hover:bg-red-700"
                                onclick="return confirm('Delete this chirp?')"
                            >
                                Delete
                            </button>

                        </form>

                    </div>

                @endcan

            </div>

        @endforeach

        <div class="mt-6">
            {{ $chirps->links() }}
        </div>

    </div>
</x-layouts::app>