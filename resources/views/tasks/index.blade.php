@extends('layouts.app')

@section('title', 'Задачи')

@section('content')
    <div class="grid col-span-full">
        <h1 class="text-3xl font-bold mb-5">Задачи</h1>

        <div class="mb-4">
            <form method="GET" action="{{ route('tasks.index') }}">
                <div>
                    <select name="filter[status_id]">
                        <option value="">Статус</option>
                        @foreach ($statuses as $id => $status)
                            <option value="{{ $id }}" {{ request('filter.status_id') == $id ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>

                    <select name="filter[created_by_id]">
                        <option value="">Автор</option>
                        @foreach ($creators as $id => $creator)
                            <option value="{{ $id }}" {{ request('filter.created_by_id') == $id ? 'selected' : '' }}>
                                {{ $creator }}
                            </option>
                        @endforeach
                    </select>

                    <select name="filter[assigned_to_id]">
                        <option value="">Исполнитель</option>
                        @foreach ($executors as $id => $exec)
                            <option value="{{ $id }}" {{ request('filter.assigned_to_id') == $id ? 'selected' : '' }}>
                                {{ $exec }}
                            </option>
                        @endforeach
                    </select>

                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2" type="submit">
                        Применить
                    </button>
                </div>
            </form>
        </div>

        @auth
            <div>
                <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Создать задачу
                </a>
            </div>
        @endauth

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <th>ID</th>
                    <th>Статус</th>
                    <th>Название</th>
                    <th>Автор</th>
                    <th>Исполнитель</th>
                    <th>Дата создания</th>
                    @auth
                        <th>Действия</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr class="border-b border-dashed text-left">
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->status->name }}</td>
                        <td>
                            <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:text-blue-900">
                                {{ $task->name }}
                            </a>
                        </td>
                        <td>{{ $task->creator->name }}</td>
                        <td>{{ $task->executor->name ?? '-' }}</td>
                        <td>{{ $task->formattedDate }}</td>
                        @auth
                            <td>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-600 hover:text-blue-900">
                                    Изменить
                                </a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Вы уверены?');">
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection