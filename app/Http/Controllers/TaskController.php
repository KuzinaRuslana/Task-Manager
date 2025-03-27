<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->with(['status', 'creator', 'executor'])
            ->paginate(15);

        return view('tasks.index', [
            'tasks' => $tasks,
            'statuses' => TaskStatus::all(),
            'users' => User::all(),
        ]);
    }

    public function create()
    {
        $task = new Task();
        $statuses = TaskStatus::pluck('name', 'id');
        $executors = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.create', compact('task', 'statuses', 'executors', 'labels'));
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Задача с таким именем уже существует',
            'status_id.required' => 'Это обязательное поле',
        ];

        $data = $request->validate([
            'name' => 'required|max:255|unique:tasks',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
        ], $messages);

        $task = new Task();
        $task->fill($data);
        $task->created_by_id = (int) Auth::id();
        $task->save();

        $labels = collect($request->input('labels'))->filter();
        $task->labels()->attach(Label::find($labels));

        flash("Задача успешно создана");
        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => 'required|max:255|unique:tasks,name,' . $task->id,
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
        ]);

        $task->fill($data);
        $task->save();

        $labels = collect($request->input('labels'))->filter();
        $task->labels()->sync(Label::find($labels));

        flash("Задача успешно изменена");
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Задача успешно удалена.');
    }
}
