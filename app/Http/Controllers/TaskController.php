<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('assignedUser')->get();
        return response()->json($tasks);
    }

    public function index2(Request $request)
    {
        $query = Task::query();

        // Filtering
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        // Sorting
        if ($request->has('sort_by')) {
            $direction = $request->get('sort_dir', 'asc');
            $query->orderBy($request->sort_by, $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return response()->json($query->paginate(10));
    }

    public function get($id) {
        return response()->json(Task::findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:todo,in_progress,done,blocked',
            'priority' => 'in:low,medium,high,urgent',
            'assigned_user_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        $validated['created_by'] = Auth::id();

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:todo,in_progress,done,blocked',
            'priority' => 'in:low,medium,high,urgent',
            'assigned_user_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
