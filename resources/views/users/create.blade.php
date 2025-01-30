@extends('layouts.app')

@section('content')
    <div class="pb-2 mb-3 border-bottom d-flex align-items-center justify-content-between">
        <h2>Создать пользователя</h2>

        <div class="d-flex gap-1">
            <a
                class="btn btn-sm btn-outline-secondary"
                href="{{route('users.index')}}"
            >
                Users
            </a>
        </div>
    </div>

    <div class="my-4">
        @include('users.partials.user-create-form')
    </div>
@endsection
