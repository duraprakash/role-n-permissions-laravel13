<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Stmt\TryCatch;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::with('user')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create(){
        Gate::authorize('create-task');

        return view('tasks.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create-task');

        Task::create($request->only('name', 'due_date')
            + ['user_id' => auth()->id()]);

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        Gate::authorize('update-task', $task);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        Gate::authorize('update-task', $task);

        $task->update($request->only('name', 'due_date'));

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task){
        Gate::authorize('delete-task', $task);

        $task->delete();

        return redirect()->route('tasks.index');

    }
}
