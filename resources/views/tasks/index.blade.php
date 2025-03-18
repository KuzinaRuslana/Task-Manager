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

        <table class="mt-4 w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200 border-b-2 border-gray-400">
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Статус</th>
                    <th class="border px-4 py-2">Название</th>
                    <th class="border px-4 py-2">Автор</th>
                    <th class="border px-4 py-2">Исполнитель</th>
                    <th class="border px-4 py-2">Дата создания</th>
                    @auth
                        <th class="border px-4 py-2">Действия</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr class="border-b">
                        <td class="border px-4 py-2">{{ $task->id }}</td>
                        <td class="border px-4 py-2">{{ $task->status->name }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:underline">
                                {{ $task->name }}
                            </a>
                        </td>
                        <td class="border px-4 py-2">{{ $task->creator->name }}</td>
                        <td class="border px-4 py-2">{{ $task->executor->name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $task->formattedDate }}</td>
                        @auth
                            <td class="border px-4 py-2">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500 hover:underline">Изменить</a>

                                @if(Auth::id() === $task->created_by_id)
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Вы уверены?');">
                                            Удалить
                                        </button>
                                    </form>
                                @endif
                            </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection