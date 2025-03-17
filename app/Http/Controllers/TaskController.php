<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['status', 'creator', 'executor'])->get();
        $statuses = TaskStatus::pluck('name', 'id');
        $creators = User::pluck('name', 'id');
        $executors = User::pluck('name', 'id');

        return view('tasks.index', compact('tasks', 'statuses', 'creators', 'executors'));
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
        if (Auth::id() !== $task->created_by_id) {
            return redirect()->route('tasks.index')->withErrors('Вы можете редактировать только свои задачи.');
        }

        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    public function update(Request $request, Task $task)
    {
        if (Auth::id() !== $task->created_by_id) {
            return redirect()->route('tasks.index')->withErrors('Вы можете редактировать только свои задачи.');
        }

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

        flash("Задача успешно обновлена");
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Задача успешно удалена.');
    }
}
