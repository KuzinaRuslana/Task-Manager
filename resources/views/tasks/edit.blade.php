@extends('layouts.app')

@section('content')
        <div class="grid col-span-full">
            <h1 class="text-3xl font-bold mb-5">Изменение задачи</h1>
            <form class="w-50" method="POST" action="{{ route('tasks.update', $task->id) }}">
                @csrf
                @method('PATCH')

                <div class="flex flex-col">
                    <div>
                        <label for="name">Имя</label>
                    </div>
                    <div class="mt-2">
                        <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{ old('name', $task->name) }}">
                    </div>

                    <div class="mt-2">
                        <label for="description">Описание</label>
                    </div>
                    <div>
                        <textarea class="rounded border-gray-300 w-1/3 h-32" name="description" id="description">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="mt-2">
                        <label for="status_id">Статус</label>
                    </div>
                    <div>
                        <select class="rounded border-gray-300 w-1/3" name="status_id" id="status_id">
                            @foreach($statuses as $id => $name)
                                <option value="{{ $id }}" {{ $task->status_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-2">
                        <label for="assigned_to_id">Исполнитель</label>
                    </div>
                    <div>
                        <select class="rounded border-gray-300 w-1/3" name="assigned_to_id" id="assigned_to_id">
                            <option value=""></option>
                            @foreach($users as $id => $name)
                                <option value="{{ $id }}" {{ $task->assigned_to_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-2">
                        <label for="labels">Метки</label>
                    </div>
                    <div>
                        <select class="form-control rounded border-gray-300 w-1/3 h-32" name="labels[]" id="labels" multiple>
                            @foreach($labels as $id => $name)
                                <option value="{{ $id }}" 
                                    {{ collect(old('labels', $task->labels->pluck('id')))->contains($id) ? 'selected' : '' }}>
                                        {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-2">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                            Обновить
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection