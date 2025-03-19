@extends('layouts.app')

@section('content')
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5 text-3xl font-bold">Метки</h1>

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
                                        <a href="{{ route('labels.edit', $label) }}" class="text-blue-500 hover:underline">Редактировать</a>
                                        <form action="{{ route('labels.destroy', $label) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Удалить метку?')">
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
        </div>
    </section>
@endsection