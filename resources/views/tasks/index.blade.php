@extends('layouts.app')

@section('title', 'To-Do List')

@section('content')



<form method="GET" action="{{ route('tasks.index') }}" class="mb-6">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tugas..."
        class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-indigo-300 dark:bg-gray-800 dark:text-white dark:border-gray-600">
</form>
<form action="{{ route('tasks.store') }}" method="POST"
    class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl shadow-sm space-y-4 md:space-y-0 md:flex md:items-end md:gap-4 mb-6">
    @csrf
    <div class="flex-1">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tugas</label>
        <input type="text" name="name" placeholder="Tambah tugas..."
            class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-indigo-300 dark:bg-gray-700 dark:text-white dark:border-gray-600" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Deadline</label>
        <input type="date" name="deadline"
            class="p-2 border rounded-md w-full dark:bg-gray-700 dark:text-white dark:border-gray-600">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Prioritas</label>
        <select name="priority"
            class="p-2 border rounded-md w-full dark:bg-gray-700 dark:text-white dark:border-gray-600">
            <option value="low">🟢 Rendah</option>
            <option value="normal" selected>🟠 Normal</option>
            <option value="high">🔴 Tinggi</option>
        </select>
    </div>
    <div>
        <button type="submit"
            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 w-full mt-4 md:mt-0">+ Tambah</button>
    </div>
</form>
<div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm space-y-3 mb-6">
    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
        <span class="font-semibold">Status:</span>
        <a href="{{ url('/') }}" class="text-blue-500 hover:underline">📘 Semua</a>
        <a href="{{ url('/?filter=done') }}" class="text-green-600 hover:underline">✅ Selesai</a>
        <a href="{{ url('/?filter=undone') }}" class="text-purple-600 hover:underline">📥 Belum</a>
    </div>
    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
        <span class="font-semibold">Prioritas:</span>
        <a href="{{ url('/') }}" class="text-blue-500 hover:underline">📋 Semua</a>
        <a href="{{ url('/?priority=high' . (request('filter') ? '&filter=' . request('filter') : '')) }}"
            class="text-red-500 hover:underline">🔴 Tinggi</a>
        <a href="{{ url('/?priority=normal' . (request('filter') ? '&filter=' . request('filter') : '')) }}"
            class="text-orange-500 hover:underline">🟠 Normal</a>
        <a href="{{ url('/?priority=low' . (request('filter') ? '&filter=' . request('filter') : '')) }}"
            class="text-green-500 hover:underline">🟢 Rendah</a>
    </div>
</div>

<ul class="space-y-4">
    @forelse ($tasks as $task)
        <li
            class="flex justify-between items-start bg-white dark:bg-gray-900 p-4 rounded-xl shadow-md border hover:shadow-lg transition-shadow duration-200 dark:border-gray-700">
            <div class="flex items-start gap-3">
                <form action="{{ route('tasks.toggle', $task->id) }}" method="POST" class="inline">
                    @csrf
                    <input type="checkbox" onchange="this.form.submit()" {{ $task->is_done ? 'checked' : '' }}>
                </form>
                <div class="{{ $task->is_done ? 'line-through text-gray-400' : 'text-gray-800 dark:text-white' }}">
                    <div class="font-semibold text-lg">{{ $task->name }}</div>
                    <div class="text-sm">
                        <span class="font-medium">🗓️ Deadline:</span>
                        {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                        <span class="text-gray-500">({{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }})</span>
                        <br>
                        <span class="font-medium">🔥 Prioritas:</span>
                        <span
                            class="inline-block px-2 py-1 text-xs font-bold rounded-full
                            {{ $task->priority === 'high' ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-white' :
                               ($task->priority === 'normal' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white' :
                               'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white') }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 text-lg">
                <a href="{{ route('tasks.edit', $task->id) }}"
                    class="text-orange-500 hover:text-orange-700">✏️</a>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:text-red-800">🗑️</button>
                </form>
            </div>
        </li>
    @empty
        <li class="text-center text-gray-400 py-6 bg-white dark:bg-gray-800 rounded-xl shadow-inner">Tidak ada tugas ditemukan.</li>
    @endforelse
</ul>
@endsection
