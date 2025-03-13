@extends('layouts.app')

@section('title', 'Статусы')

@section('content')
    <div class="grid col-span-full">
        <h1 class="text-3xl font-bold mb-5">Статусы</h1>

        @auth
            <div>
                <a href="{{ route('task_statuses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Создать статус
                </a>
            </div>
        @endauth

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Дата создания</th>
                    @auth
                        <th>Действия</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($statuses as $status)
                    <tr class="border-b border-dashed text-left">
                        <td>{{ $status->id }}</td>
                        <td>{{ $status->name }}</td>
                        <td>{{ $status->created_at->format('d.m.Y') }}</td>
                        @auth
                            <td>
                                <a href="{{ route('task_statuses.edit', $status->id) }}" class="text-blue-600 hover:text-blue-900">
                                    Изменить
                                </a>
                                <form action="{{ route('task_statuses.destroy', $status->id) }}" method="POST" style="display: inline;">
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
