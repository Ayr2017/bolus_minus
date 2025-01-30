@extends('layouts.app')

@section('content')
    <div class="pb-2 mb-3 border-bottom d-flex align-items-center justify-content-between">
        <h2>{{$title}}</h2>
        <a
            class="btn btn-outline-secondary"
            href="{{route('organisations.index')}}"
        >
            All organisations
        </a>
    </div>
    <div>
        @include('organisations.partials.organisation-edit-form')
    </div>
    <div class="my-4 row">
        <div class="col-6">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Id</th>
                            <td>{{$organisation->id}}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{$organisation->name}}</td>
                        </tr>
                        <tr>
                            <th>Structural unit</th>
                            <td>{{$organisation->structuralUnit?->name}}</td>
                        </tr>
                        <tr>
                            <th>Parent</th>
                            <td>
                                @if($organisation->parent)
                                    <a
                                        href="{{
                                            route(
                                                'organisations.show',
                                                ['organisation'=>$organisation->parent?->id]
                                            )
                                        }}"
                                    >
                                        {{$organisation->parent?->name}}
                                    </a>
                                @else
                                    no parent
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created at</th>
                            <td>{{$organisation->created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <a
                class="btn btn-outline-primary"
                href="{{route('organisations.edit',['organisation' => $organisation])}}"
            >
                Edit
            </a>
            @include(
                'layouts.partials.delete-modal',
                [
                    'item'=>$organisation,
                    'message'=>'Animal will delete',
                    'route'=>route('organisations.destroy', ['organisation'=>$organisation])
                ]
            )
        </div>
    </div>
@endsection
