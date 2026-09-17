<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Stmt\TryCatch;

class TaskController extends Controller
{
    public function index(){

        Gate::authorize('viewAny', Task::class);

        $tasks = Task::all();
        
        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task){

        Gate::authorize('view', $task);

        return view('tasks.view', compact('task'));
    }

    public function create(){

        Gate::authorize('create', Task::class);

        return view('tasks.create');
    }

    public function store(Request $request)
    {

        Gate::authorize('create', Task::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'due_date' => ['required', 'date'],
        ]);

        Task::create([
            'name' => $validated['name'],
            'due_date' => $validated['due_date'],
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        Gate::authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {

        Gate::authorize('update', $task);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'due_date' => ['required', 'date'],
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index');
    }

    public function delete(Task $task)
    {
        Gate::authorize('delete', $task);

        return view('tasks.delete', compact('task'));
    }

    public function destroy(Task $task){

        Gate::authorize('delete', $task);
        
        $task->delete();

        return redirect()->route('tasks.index');

    }
}
