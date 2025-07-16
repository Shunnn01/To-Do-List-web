<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
public function index($id = null)
{
    try {
        if ($id) {
            $task = Task::find($id);
            if (!$task) {
                return response()->json([
                    'message' => 'Task tidak ditemukan',
                    'data' => null
                ]);
            }

            return response()->json([
                'message' => 'Task berhasil ditemukan',
                'data' => $task
            ]);
        }

        $tasks = Task::latest()->get();

        return response()->json([
            'message' => $tasks->isEmpty() ? 'Tidak ada data' : 'Data berhasil diambil',
            'data' => $tasks
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan',
        ]);
    }
}


    public function store(Request $request)
    {
        $task = Task::create([
            'name' => $request->name ?? 'Tanpa Nama',
            'deadline' => $request->deadline,
            'priority' => $request->priority ?? 'normal',
            'user_id' => 1,
            'is_done' => false
        ]);

        return response()->json([
            'message' => 'Task berhasil dibuat',
            'data' => $task
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'message' => 'Task tidak ditemukan'
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
        ], 200);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'message' => 'Task tidak ditemukan'
            ], 404);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task berhasil dihapus'
        ], 200);
    }
}
