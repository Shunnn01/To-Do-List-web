<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
public function index(Request $request)
{
    $query = Task::query();

    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->has('filter')) {
        if ($request->filter === 'done') {
            $query->where('is_done', true);
        } elseif ($request->filter === 'undone') {
            $query->where('is_done', false);
        }
    }

    if ($request->has('priority')) {
        $query->where('priority', $request->priority);
    }

    $tasks = $query->orderBy('is_done', 'asc')
                   ->orderBy('deadline', 'asc')
                   ->orderBy('created_at', 'desc')
                   ->get();

    return view('tasks.index', compact('tasks'));
}


   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'deadline' => 'nullable|date',
        'priority' => 'required|in:low,normal,high', 
    ]);

    Task::create([
        'name' => $request->name,
        'deadline' => $request->deadline,
        'priority' => $request->priority,
        'user_id' => 1,
    ]);

    return redirect('/');
}


    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,normal,high', 
        ]);

        $task->update([
            'name' => $request->name,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
        ]);

        return redirect('/')->with('success', 'Task berhasil diperbarui!');
    }

    public function toggle(Task $task)
    {
        $task->is_done = !$task->is_done;
        $task->save();

        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }
}
