<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'To-Do App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen transition-colors duration-300">
    <header class="bg-white dark:bg-gray-800 border-b shadow-sm dark:border-gray-700">
        <div class="max-w-4xl mx-auto flex items-center justify-between px-4 py-3">
            <h1 class="text-xl font-bold text-indigo-600 dark:text-indigo-400">📝 To-Do App</h1>
            <button id="toggleDark" class="ml-4 text-sm px-3 py-1 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600">
                <span id="darkIcon">🌙</span>
            </button>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-6">
        @yield('content')
    </main>
</body>
</html>
