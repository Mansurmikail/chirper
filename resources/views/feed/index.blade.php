<x-layouts::app :title="__('Following Feed')">

    <div class="max-w-4xl mx-auto py-8 px-6">

        <h1 class="text-3xl font-bold mb-2">
            Following Feed
        </h1>

        <p class="mb-6 text-gray-600">
            Chirps from you and the people you follow.
        </p>

        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-red-800">
                {{ session('error') }}
            </div>
        @endif

        @forelse ($chirps as $chirp)

            <div class="mb-6 rounded-lg border p-4">

                {{-- User --}}
                <h3 class="font-semibold">
                    <a
                        href="{{ route('profile.show', $chirp->user) }}"
                        class="hover:underline"
                    >
                        {{ $chirp->user->name }}
                    </a>
                </h3>

                {{-- Chirp --}}
                <p class="mt-2">
                    {{ $chirp->message }}
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    {{ $chirp->created_at->diffForHumans() }}
                </p>

                {{-- Like --}}
                <div class="mt-4 flex items-center">

                    @php
                        $liked = $chirp->likes()
                            ->where('user_id', auth()->id())
                            ->exists();

                        $likeCount = $chirp->likes()->count();
                    @endphp

                    <form
                        method="POST"
                        action="{{ route('chirps.like', $chirp) }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="rounded px-3 py-2 text-sm
                            {{ $liked
                                ? 'bg-red-100 text-red-700'
                                : 'bg-gray-100 text-gray-700'
                            }}"
                        >
                            {{ $liked ? '♥ Unlike' : '♡ Like' }}
                        </button>
                    </form>

                    <span class="ml-2 text-sm text-gray-500">
                        {{ $likeCount }}
                        {{ Str::plural('like', $likeCount) }}
                    </span>

                </div>

                {{-- Comments --}}
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

                    {{-- Add comment --}}
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
                        ></textarea>

                        <button
                            type="submit"
                            class="mt-2 rounded bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700"
                        >
                            Comment
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="rounded-lg border p-6 text-center">

                <p class="text-gray-500">
                    No chirps to show yet.
                </p>

                <p class="mt-2 text-sm text-gray-400">
                    Follow some users to see their chirps here.
                </p>

            </div>

        @endforelse

        <div class="mt-6">
            {{ $chirps->links() }}
        </div>

    </div>

</x-layouts::app>