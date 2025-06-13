<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projectId = $request->get('project_id');
        $projects = Project::all();
        $tasks = Task::where('project_id', $projectId ?? $projects->first()->id ?? null)
            ->orderBy('priority')
            ->get();

        return view('tasks.index', compact('projects', 'tasks', 'projectId'));
    }

    public function store(Request $request)
    {
        $maxPriority = Task::where('project_id', $request->project_id)->max('priority') ?? 0;

        Task::create([
            'name' => $request->name,
            'priority' => $maxPriority + 1,
            'project_id' => $request->project_id
        ]);

        return back();
    }

    public function update(Request $request, Task $task)
    {
        $task->update(['name' => $request->name]);
        return back();
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back();
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            Task::where('id', $item['id'])->update(['priority' => $item['priority']]);
        }

        return response()->json(['status' => 'success']);
    }
}
