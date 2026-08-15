<x-layouts::app :title="__('Edit Profile')">
    <div class="max-w-2xl mx-auto py-8 px-6">

        <div class="mb-8">
            <h1 class="text-3xl font-bold">
                Edit Profile
            </h1>

            <p class="mt-2 text-gray-600">
                Update your profile information.
            </p>
        </div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-6">
                <label
                    for="name"
                    class="block text-sm font-medium text-gray-700"
                >
                    Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="mt-2 w-full rounded-lg border p-3"
                    required
                >
            </div>

            <div class="mb-6">
                <label
                    for="email"
                    class="block text-sm font-medium text-gray-700"
                >
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="mt-2 w-full rounded-lg border p-3"
                    required
                >
            </div>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                >
                    Save Changes
                </button>

                <a
                    href="{{ route('profile.show', $user) }}"
                    class="rounded bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300"
                >
                    Cancel
                </a>
            </div>

        </form>

    </div>
</x-layouts::app>