@extends('layouts.app')

@section('content')
            <div class="grid col-span-full">
                <h1 class="text-3xl font-bold mb-5">Метки</h1>

                @auth
                    <div class="mb-4">
                        <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Создать метку
                        </a>
                    </div>
                @endauth

                <table class="mt-4 w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-200 border-b-2 border-gray-400">
                        <tr>
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">Имя</th>
                            <th class="border px-4 py-2">Описание</th>
                            <th class="border px-4 py-2">Дата создания</th>
                            @auth
                                <th class="border px-4 py-2">Действия</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($labels as $label)
                            <tr class="border-b">
                                <td class="border px-4 py-2">{{ $label->id }}</td>
                                <td class="border px-4 py-2">{{ $label->name }}</td>
                                <td class="border px-4 py-2">{{ $label->description ?? '—' }}</td>
                                <td class="border px-4 py-2">{{ $label->created_at->format('d.m.Y') }}</td>
                                @auth
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('labels.edit', $label) }}" class="text-blue-500 hover:underline">Изменить</a>
                                        <a href="{{ route('labels.destroy', $label) }}"
                                            class="text-red-500 hover:underline"
                                            onclick="event.preventDefault(); if (confirm('Удалить метку?')) document.getElementById('delete-label-{{ $label->id }}').submit();">
                                            Удалить
                                        </a>
                                        <form id="delete-label-{{ $label->id }}" action="{{ route('labels.destroy', $label) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                @endauth
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection