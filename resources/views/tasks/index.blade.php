@extends('layouts.app')

@section('title', 'Задачи')

@section('content')
    <div class="grid col-span-full">
        <h1 class="text-3xl font-bold mb-5">Задачи</h1>

        <div class="w-full flex justify-between items-center mb-4">
            <div>
                <form method="GET" action="{{ route('tasks.index') }}">
                    <div class="flex">
                        <select class="rounded border-gray-300" name="filter[status_id]">
                            <option value="">Статус</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ request('filter.status_id') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>

                        <select class="rounded border-gray-300" name="filter[created_by_id]">
                            <option value="">Автор</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('filter.created_by_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>

                        <select class="rounded border-gray-300" name="filter[assigned_to_id]">
                            <option value="">Исполнитель</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('filter.assigned_to_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>

                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                            Применить
                        </button>
                    </div>
                </form>
            </div>

            @auth
                <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Создать задачу
                </a>
            @endauth
        </div>

        <table class="mt-4 w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200 border-b-2 border-gray-400">
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Статус</th>
                    <th class="border px-4 py-2">Имя</th>
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