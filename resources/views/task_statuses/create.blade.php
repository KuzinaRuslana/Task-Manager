@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-5">Создать статус</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="w-50">
        <form action="{{ route('task_statuses.store') }}" method="POST">
            @csrf

            <div class="flex flex-col">
                <div>
                    <label for="name">Имя</label>
                </div>
                <div class="mt-2">
                    <div class="rounded border-gray-300 w-1/3">
                        <input type="text" name="name" id="name" value="{{ old('name', $status->name) }}">
                    </div>
                    <div class="text-rose-600"></div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded">
                        Создать
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
