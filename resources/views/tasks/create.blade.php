@extends('layouts.app')

@section('title', 'Создать задачу')

@section('content')
    <div class="grid col-span-full">
        <h1 class="text-3xl font-bold mb-5">Создать задачу</h1>

        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf

            <div class="flex flex-col">
                <div>
                    <label for="name">Имя</label>
                </div>
                <div class="mt-2">
                    <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{ old('name') }}">
                </div>

                @error('name')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror

                <div class="mt-2">
                    <label for="description">Описание</label>
                </div>
                <div>
                    <textarea class="rounded border-gray-300 w-1/3 h-32" name="description" id="description">{{ old('description') }}</textarea>
                </div>

                <div class="mt-2">
                    <label for="status_id">Статус</label>
                </div>
                <div>
                    <select class="rounded border-gray-300 w-1/3" name="status_id" id="status_id">
                        <option value="">Выберите статус</option>
                        @foreach ($statuses as $id => $status)
                            <option value="{{ $id }}" {{ old('status_id') == $id ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @error('status_id')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror

                <div class="mt-2">
                    <label for="assigned_to_id">Исполнитель</label>
                </div>
                <div>
                    <select class="rounded border-gray-300 w-1/3" name="assigned_to_id" id="assigned_to_id">
                        <option value="">Выберите исполнителя</option>
                        @foreach ($executors as $id => $executor)
                            <option value="{{ $id }}" {{ old('assigned_to_id') == $id ? 'selected' : '' }}>
                                {{ $executor }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-2">
                    <label for="labels">Метки</label>
                </div>
                <div>
                    <select class="rounded border-gray-300 w-1/3 h-32" name="labels[]" id="labels" multiple>
                        @foreach ($labels as $id => $label)
                            <option value="{{ $id }}" {{ collect(old('labels'))->contains($id) ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-2">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        Создать
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection