@extends('layouts.app')

@section('content')
    <h1>{{$title}}</h1>
    <div class="">
        <a class="btn btn-sm btn-outline-primary" href="{{route('animals.create')}}">Create</a>
    </div>
    @include('animals.partials.animals-table')
@endsection
