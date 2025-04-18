@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="text-3xl font-bold mb-5">Изменение статуса</h1>

        <form class="w-50" method="POST" action="{{ route('task_statuses.update', $status) }}">
            @csrf
            @method('PATCH')

            <div class="flex flex-col">
                <div>
                    <label for="name">Имя</label>
                </div>
                <div class="mt-2">
                    <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{ old('name', $status->name) }}">
                </div>
                
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div class="mt-2">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        Обновить
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
