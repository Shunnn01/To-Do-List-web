@extends('layouts.app')

@section('title', 'To-Do List')

@section('content')
{{-- Navbar --}}
<nav class="flex justify-between items-center mb-6 border-b pb-4">
    <h2 class="text-2xl font-bold text-indigo-600">📝 To-Do List</h2>
    <div class="text-sm text-gray-600">Hari ini: {{ now()->format('d M Y') }}</div>
</nav>

{{-- Form tambah tugas --}}
<form action="{{ route('tasks.store') }}" method="POST" class="bg-gray-50 p-4 rounded-xl shadow-sm space-y-4 md:space-y-0 md:flex md:items-end md:gap-4 mb-6">
    @csrf
    <div class="flex-1">
        <label class="block text-sm font-medium text-gray-700 mb-1">Tugas</label>
        <input type="text" name="name" placeholder="Tambah tugas..." class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-indigo-300" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
        <input type="date" name="deadline" class="p-2 border rounded-md w-full">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
        <select name="priority" class="p-2 border rounded-md w-full">
            <option value="low">🟢 Rendah</option>
            <option value="normal" selected>🟠 Normal</option>
            <option value="high">🔴 Tinggi</option>
        </select>
    </div>
    <div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 w-full mt-4 md:mt-0">+ Tambah</button>
    </div>
</form>

{{-- Filter --}}
<div class="bg-white p-4 rounded-xl shadow-sm space-y-3 mb-6">
    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
        <span class="font-semibold">Status:</span>
        <a href="{{ url('/') }}" class="text-blue-500 hover:underline">📘 Semua</a>
        <a href="{{ url('/?filter=done') }}" class="text-green-600 hover:underline">✅ Selesai</a>
        <a href="{{ url('/?filter=undone') }}" class="text-purple-600 hover:underline">📥 Belum</a>
    </div>
    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
        <span class="font-semibold">Prioritas:</span>
        <a href="{{ url('/') }}" class="text-blue-500 hover:underline">📋 Semua</a>
        <a href="{{ url('/?priority=high' . (request('filter') ? '&filter=' . request('filter') : '')) }}" class="text-red-500 hover:underline">🔴 Tinggi</a>
        <a href="{{ url('/?priority=normal' . (request('filter') ? '&filter=' . request('filter') : '')) }}" class="text-orange-500 hover:underline">🟠 Normal</a>
        <a href="{{ url('/?priority=low' . (request('filter') ? '&filter=' . request('filter') : '')) }}" class="text-green-500 hover:underline">🟢 Rendah</a>
    </div>
</div>

{{-- Daftar tugas --}}
<ul class="space-y-4">
    @forelse ($tasks as $task)
        <li class="flex justify-between items-start bg-white p-4 rounded-xl shadow-md border hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-start gap-3">
                <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xl hover:scale-110 transition-transform duration-200">
                        {{ $task->is_done ? '✅' : '🟪' }}
                    </button>
                </form>
                <div class="{{ $task->is_done ? 'line-through text-gray-400' : 'text-gray-800' }}">
                    <div class="font-semibold text-lg">{{ $task->name }}</div>
                    <div class="text-sm">
                        <span class="font-medium">🗓️ Deadline:</span> {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}<br>
                        <span class="font-medium">🔥 Prioritas:</span> {{ ucfirst($task->priority) }}
                    </div>
                </div>
            </div>
            <div class="flex gap-2 text-lg">
                <a href="{{ route('tasks.edit', $task->id) }}" class="text-orange-500 hover:text-orange-700">✏️</a>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:text-red-800">🗑️</button>
                </form>
            </div>
        </li>
    @empty
        <li class="text-center text-gray-400 py-6 bg-white rounded-xl shadow-inner">Tidak ada tugas ditemukan.</li>
    @endforelse
</ul>
@endsection
