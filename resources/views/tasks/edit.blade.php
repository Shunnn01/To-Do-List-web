@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md mt-10 border border-gray-100 dark:border-gray-700">
        <h2 class="text-3xl font-extrabold mb-6 text-gray-800 dark:text-gray-100 text-center">✏️ Edit Task</h2>

        @if ($errors->any())
            <div class="bg-red-50 dark:bg-gray-900 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-400 p-4 rounded mb-6">
                <strong class="block font-semibold mb-2">Terjadi Kesalahan:</strong>
                <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">📝 Nama Tugas
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                    placeholder="Masukkan nama tugas...">
            </div>

            <div>
                <label for="deadline" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">📅
                    Deadline</label>
                <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $task->deadline) }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label for="priority" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">⚠️
                    Prioritas</label>
                <select name="priority" id="priority"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>🟢 Rendah</option>
                    <option value="normal" {{ $task->priority == 'normal' ? 'selected' : '' }}>🟠 Normal</option>
                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>🔴 Tinggi</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white font-semibold px-6 py-2 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-blue-400">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
