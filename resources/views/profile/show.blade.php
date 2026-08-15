<x-layouts::app :title="$user->name . '\'s Profile'">

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

    <div class="mb-8 rounded-xl border bg-white p-6 shadow-sm">

        <div class="flex items-start justify-between">

            <div>
                <h1 class="text-3xl font-bold">
                    {{ $user->name }}
                </h1>

                <p class="mt-2 text-gray-600">
                    {{ $user->email }}
                </p>
            </div>

            {{-- Follow / Unfollow button --}}
            @if (auth()->id() !== $user->id)

                @php
                    $isFollowing = auth()->user()
                        ->following()
                        ->where('following_id', $user->id)
                        ->exists();
                @endphp

                <form method="POST" action="{{ route('users.follow', $user) }}">
                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg px-4 py-2 text-sm font-semibold
                        {{ $isFollowing
                            ? 'bg-gray-200 text-gray-800 hover:bg-gray-300'
                            : 'bg-blue-600 text-white hover:bg-blue-700'
                        }}"
                    >
                        {{ $isFollowing ? 'Unfollow' : 'Follow' }}
                    </button>
                </form>

            @endif

        </div>

        {{-- Profile statistics --}}
        <div class="mt-6 flex gap-8">

            <div>
                <p class="text-2xl font-bold">
                    {{ $chirps->total() }}
                </p>

                <p class="text-sm text-gray-500">
                    Chirps
                </p>
            </div>

            <div>
                <p class="text-2xl font-bold">
                    {{ $user->followers()->count() }}
                </p>

                <p class="text-sm text-gray-500">
                    Followers
                </p>
            </div>

            <div>
                <p class="text-2xl font-bold">
                    {{ $user->following()->count() }}
                </p>

                <p class="text-sm text-gray-500">
                    Following
                </p>
            </div>

        </div>

    </div>

    <h2 class="text-2xl font-bold mb-2">
        Chirps
    </h2>

    <p class="mb-6 text-gray-600">
        Total chirps: {{ $chirps->total() }}
    </p>

    @forelse ($chirps as $chirp)

        <div class="mb-4 rounded-lg border p-4">

            <p class="mt-2">
                {{ $chirp->message }}
            </p>

            <p class="mt-2 text-sm text-gray-500">
                {{ $chirp->created_at->diffForHumans() }}
            </p>

        </div>

    @empty

        <p class="text-gray-500">
            This user has not posted any chirps yet.
        </p>

    @endforelse

    <div class="mt-6">
        {{ $chirps->links() }}
    </div>

</x-layouts::app>