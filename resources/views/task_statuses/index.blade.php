@extends('layouts.app')

@section('title', 'Статусы')

@section('content')
    <div class="grid col-span-full">
        <h1 class="text-3xl font-bold mb-5">Статусы</h1>

        @auth
            <div class="mb-4">
                <a href="{{ route('task_statuses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Создать статус
                </a>
            </div>
        @endauth

        <table class="mt-4 w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200 border-b-2 border-gray-400">
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Имя</th>
                    <th class="border px-4 py-2">Дата создания</th>
                    @auth
                        <th class="border px-4 py-2">Действия</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($statuses as $status)
                    <tr class="border-b">
                        <td class="border px-4 py-2">{{ $status->id }}</td>
                        <td class="border px-4 py-2">{{ $status->name }}</td>
                        <td class="border px-4 py-2">{{ $status->created_at->format('d.m.Y') }}</td>
                        @auth
                            <td class="border px-4 py-2">
                                <a href="{{ route('task_statuses.edit', $status->id) }}" class="text-blue-500 hover:underline">Изменить</a>
                                <form action="{{ route('task_statuses.destroy', $status->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Вы уверены?');">
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
