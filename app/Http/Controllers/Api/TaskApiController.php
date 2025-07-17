<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskApiController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();

            $tasks = Task::where('user_id', $user->id)->latest()->get();

            return response()->json([
                'message' => $tasks->isEmpty() ? 'Tidak ada data' : 'Data berhasil diambil',
                'data' => $tasks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

   public function store(Request $request)
{
    $user = auth()->user();

    // Validasi input
    $validated = $request->validate([
        'name' => 'required|string',
        'deadline' => 'nullable|date',
        'priority' => 'nullable|in:low,normal,high',
    ]);

    // Simpan task
    $task = Task::create([
        'name' => $validated['name'],
        'deadline' => $validated['deadline'] ?? null,
        'priority' => $validated['priority'] ?? 'normal',
        'user_id' => $user->id,
        'is_done' => false
    ]);

    return response()->json([
        'message' => 'Task berhasil dibuat oleh ' . $user->name,
        'data' => $task
    ], 201);
}

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();

        if (!$task) {
            return response()->json([
                'message' => 'Task tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        if ($request->boolean('toggle_done')) {
            $task->is_done = !$task->is_done;
        } else {
            $task->name = $request->name ?? $task->name;
            $task->deadline = $request->deadline ?? $task->deadline;
            $task->priority = $request->priority ?? $task->priority;
            $task->is_done = $request->has('is_done') ? $request->is_done : $task->is_done;
        }

        $task->save();

        return response()->json([
            'message' => 'Task berhasil diupdate',
            'data' => $task
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();

        if (!$task) {
            return response()->json([
                'message' => 'Task tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task berhasil dihapus'
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();

        if (!$task) {
            return response()->json([
                'message' => 'Task tidak ditemukan atau bukan milik Anda',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Task berhasil ditemukan',
            'data' => $task
        ]);
    }
}
