@extends('layouts.admin')

@section('content')
    <h1>{{$title}}</h1>
    <div class="">
        <div class="col-6">
            @include('admin.animals.partials.animal-create-form')
        </div>

    </div>
@endsection
