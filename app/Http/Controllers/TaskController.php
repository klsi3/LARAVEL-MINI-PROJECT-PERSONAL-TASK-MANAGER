<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private const STATUSES = ['Pending', 'Completed'];

    private function rules(): array
    {
        return [
            'task_name'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:Pending,Completed',
            'due_date'    => 'required|date',
        ];
    }

    // VIEW TASKS: list all tasks (optional filter: ?status=Pending or ?status=Completed)
    public function index(Request $request)
    {
        $filter = in_array($request->query('status'), self::STATUSES) ? $request->query('status') : null;

        $query = Task::query();
        if ($filter) {
            $query->where('status', $filter);
        }

        // Pending first, then the nearest deadline first
        $tasks = $query
            ->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")
            ->orderBy('due_date')
            ->get();

        $stats = [
            'total'     => Task::count(),
            'pending'   => Task::where('status', 'Pending')->count(),
            'completed' => Task::where('status', 'Completed')->count(),
            'overdue'   => Task::where('status', 'Pending')->whereDate('due_date', '<', today())->count(),
        ];

        return view('tasks.index', compact('tasks', 'stats', 'filter'));
    }

    // ADD TASK: show the form
    public function create()
    {
        return view('tasks.create');
    }

    // ADD TASK: save to database
    public function store(Request $request)
    {
        Task::create($request->validate($this->rules()));

        return redirect()->route('tasks.index')->with('success', 'Task added.');
    }

    // EDIT TASK: show the form (Laravel finds the Task by id automatically)
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // EDIT TASK: save changes
    public function update(Request $request, Task $task)
    {
        $task->update($request->validate($this->rules()));

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    // UPDATE STATUS: set Pending or Completed
    public function updateStatus(Request $request, Task $task)
    {
        $data = $request->validate(['status' => 'required|in:Pending,Completed']);
        $task->update($data);

        return back()->with('success', 'Task marked as ' . strtolower($data['status']) . '.');
    }

    // DELETE TASK
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}