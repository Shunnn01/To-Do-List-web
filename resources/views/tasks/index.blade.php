<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl p-8 space-y-6">
        <h1 class="text-3xl font-bold text-center text-indigo-600">📋 To-Do List</h1>

        {{-- Form tambah tugas --}}
        <form action="{{ route('tasks.store') }}" method="POST" class="flex flex-col md:flex-row items-center gap-4">
            @csrf
            <input type="text" name="name" placeholder="Tambah tugas..." class="flex-1 p-2 border rounded-md focus:outline-none focus:ring focus:ring-indigo-300" required>
            <input type="date" name="deadline" class="p-2 border rounded-md">
            <select name="priority" class="p-2 border rounded-md">
                <option value="low" class="text-green-600">Low</option>
                <option value="normal" selected class="text-orange-600">Normal</option>
                <option value="high" class="text-red-600">High</option>
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Tambah</button>
        </form>

        {{-- Filter --}}
        <div class="space-y-2">
            <div class="text-sm text-gray-700 font-semibold">Status:</div>
            <div class="flex gap-4 text-sm">
                <a href="{{ url('/') }}" class="text-blue-500 hover:underline">📘 Semua</a>
                <a href="{{ url('/?filter=done') }}" class="text-green-600 hover:underline">✅ Selesai</a>
                <a href="{{ url('/?filter=undone') }}" class="text-purple-600 hover:underline">📥 Belum</a>
            </div>
            <div class="text-sm text-gray-700 font-semibold mt-4">Filter Prioritas:</div>
            <div class="flex gap-4 text-sm">
                <a href="{{ url('/') }}" class="text-blue-500 hover:underline">📋 Semua</a>
                <a href="{{ url('/?priority=high' . (request('filter') ? '&filter=' . request('filter') : '')) }}" class="text-red-500 hover:underline">🔴 Tinggi</a>
                <a href="{{ url('/?priority=normal' . (request('filter') ? '&filter=' . request('filter') : '')) }}" class="text-orange-500 hover:underline">🟠 Normal</a>
                <a href="{{ url('/?priority=low' . (request('filter') ? '&filter=' . request('filter') : '')) }}" class="text-green-500 hover:underline">🟢 Rendah</a>
            </div>
        </div>

        {{-- Daftar tugas --}}
        <ul class="space-y-4">
            @forelse ($tasks as $task)
                <li class="flex items-center justify-between bg-gray-50 p-4 rounded-md shadow-sm border">
                    <div class="flex items-center gap-3">
                      <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                          @csrf
                            <button type="submit" class="text-xl hover:scale-110 transition-transform duration-200">
                          {{ $task->is_done ? '✅' : '🟪' }}
                            </button>
                        </form>

                        <div class="{{ $task->is_done ? 'line-through text-gray-400' : '' }}">
                            <span class="font-medium">{{ $task->name }}</span> —
                            <span class="font-bold">Prioritas:</span> {{ ucfirst($task->priority) }} —
                            <span class="font-bold">Deadline:</span> {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="text-orange-500 hover:text-orange-700">✏️</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:text-red-800">🗑️</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="text-center text-gray-400">Tidak ada tugas ditemukan.</li>
            @endforelse
        </ul>
    </div>
</body>
</html>
