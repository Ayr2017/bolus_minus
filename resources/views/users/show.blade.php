@extends('layouts.app')

@section('content')
    <div class="pb-2 mb-3 border-bottom d-flex align-items-center justify-content-between">
        <h2>{{$title}}</h2>

        <div class="d-flex gap-2">
            <a
                class="btn btn-outline-secondary"
                href="{{route('users.index')}}"
            >
                Users
            </a>
            <a
                href="{{route('users.edit',['user'=>$user])}}"
                class="btn btn-outline-primary"
            >
                Edit
            </a>
        </div>
    </div>

    <div class="my-4">
        @include('users.partials.user-edit-form')
        <p>Name:{{$user->name}}</p>
        <p>Surname: {{$user->surname}}</p>
        <p>Email: {{$user->email}}</p>
        <p>Phone: {{$user->phone}}</p>
        <p>Created at: {{$user->created_at}}</p>

        <h5>Roles</h5>
        @foreach($user->roles as $role)
            <span
                class="mx-1 p-1 {{
                    $loop->iteration%2 == 0
                    ? 'bg-info-subtle'
                    : 'bg-warning-subtle'
                }}"

            >
                {{$role->name}}
            </span>
        @endforeach
    </div>
@endsection
