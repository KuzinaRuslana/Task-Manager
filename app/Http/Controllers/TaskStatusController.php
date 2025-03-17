<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function index()
    {
        $statuses = TaskStatus::paginate();
        return view('task_statuses.index', compact('statuses'));
    }

    public function create()
    {
        $status = new TaskStatus();
        return view('task_statuses.create', compact('status'));
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Статус с таким именем уже существует'
        ];
        $data = $this->validate($request, [
            'name' => 'required|max:255|unique:task_statuses',
        ], $messages);

        $status = new TaskStatus();
        $status->fill($data)->save();

        flash(__('Статус успешно создан!'));
        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('task_statuses.edit', ['status' => $taskStatus]);
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        $messages = [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Статус с таким именем уже существует'
        ];
        $data = $this->validate($request, [
            'name' => 'required|max:255|unique:task_statuses,name,' . $taskStatus->id,
        ], $messages);

        $taskStatus->fill($data)->save();
        flash(__('Статус успешно обновлён!'));
        return redirect()
            ->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists()) {
            flash(__('Не удалось удалить статус'))->error();
            return back();
        }

        $taskStatus->delete();
        flash(__('Статус успешно удалён!'));
        return redirect()->route('task_statuses.index');
    }
}
