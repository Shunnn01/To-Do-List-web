<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'To-Do List')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen py-10 px-4">
    <main class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-8 space-y-8">
        @yield('content')
    </main>
</body>
</html>
