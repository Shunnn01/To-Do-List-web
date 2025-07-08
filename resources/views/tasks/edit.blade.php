<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">

    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Task</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <strong>Error:</strong>
                <ul class="ml-4 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="text" name="name" value="{{ $task->name }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md">

            <input type="date" name="deadline"
                value="{{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : '' }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md">

            <select name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>📘 Rendah</option>
                <option value="normal" {{ $task->priority == 'normal' ? 'selected' : '' }}>📙 Normal</option>
                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>📕 Tinggi</option>
            </select>

            <div class="flex justify-between items-center">
                <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:underline">← Kembali</a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>

</body>
</html>
