<!DOCTYPE html>
<html lang="en" data-theme="lofi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' | Chirper' : 'Chirper' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-base-200 font-sans">

    <nav class="navbar bg-base-100 shadow-sm">
        <div class="navbar-start">
            <a href="/" class="btn btn-ghost text-xl">
                Chirper
            </a>
        </div>

        <div class="navbar-end gap-2">
            <a href="/register" class="btn btn-primary">
                Sign Up
            </a>

            <a href="/login" class="btn btn-outline">
                Sign In
            </a>
        </div>
    </nav>

    <main class="flex-1 flex items-center justify-center">
        {{ $slot }}
    </main>

</body>
</html>