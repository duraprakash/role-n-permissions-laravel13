<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
// use Illuminate\Routing\Attributes\Controllers\Authorize; // This is supposed to be used
use Livewire\Attributes\Authorize; // This is used instead as livewire
use PhpParser\Node\Stmt\TryCatch;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::with('user')->get();

        return view('tasks.index', compact('tasks'));
    }

    #[Authorize('create', [Task::class])]
    public function create(){

        return view('tasks.create');
    }

    #[Authorize('create', [Task::class])]
    public function store(Request $request)
    {

        Task::create($request->only('name', 'due_date')
            + ['user_id' => auth()->id()]);

        return redirect()->route('tasks.index');
    }

    #[Authorize('update', 'task')]
    public function edit(Task $task)
    {

        return view('tasks.edit', compact('task'));
    }

    #[Authorize('update', 'task')]
    public function update(Request $request, Task $task)
    {

        $task->update($request->only('name', 'due_date'));

        return redirect()->route('tasks.index');
    }

    #[Authorize('delete', 'task')]
    public function destroy(Task $task){

        $task->delete();

        return redirect()->route('tasks.index');

    }
}
