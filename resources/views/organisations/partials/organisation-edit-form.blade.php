<form action="{{route('organisations.update',['organisation' => $organisation])}}" method="POST" class="row">
    @csrf
    @method('PATCH')

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="name" class="form-label">Полное наименование компании</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="name"
            name="name"
            value="{{ old('name') ?? $organisation->name}}"
            style="max-width: 400px;"
            @if(!auth()->user()->hasRole('admin')) disabled @endif
        >
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="name" class="form-label">Сокращщенное наименование компании</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="name"
            name="name"
            value="{{ old('name') ?? $organisation->name}}"
            style="max-width: 400px;"
            @if(!auth()->user()->hasRole('admin')) disabled @endif
        >
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="name" class="form-label">ИНН</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="name"
            name="name"
            value="{{ old('name') ?? 11}}"
            style="max-width: 400px;">
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="name" class="form-label">Структура подразделение</label>

        <select class="form-control form-control-sm form-select" name="structural_unit_id" id="structural_unit_id" style="max-width: 400px;>
            <option value=""></option>
            @foreach($structural_units as $unit)
                <option value="{{$unit->id}}" {{$unit->id == (old('structural_unit_id') ?? $organisation->structural_unit_id) ? 'selected' : ''}}>{{$unit->id." - ".$unit->name}} </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="name" class="form-label">Регион</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="name"
            name="name"
            value="{{ old('name') ?? 11}}"
            style="max-width: 400px;">
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="name" class="form-label">Район</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="name"
            name="name"
            value="{{ old('name') ?? 11}}"
            style="max-width: 400px;">
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="name" class="form-label">Адрес</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="name"
            name="name"
            value="{{ old('name') ?? 11}}"
            style="max-width: 400px;">
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="name" class="form-label">Отделение</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="name"
            name="name"
            value="{{ old('name') ?? 11}}"
            style="max-width: 400px;">
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="uuid" class="form-label">Идентификатор компании</label>
        <input
            type="number"
            class="form-control form-control-sm"
            id="uuid"
            name="uuid"

            style="max-width: 400px;"
            @if(!auth()->user()->hasRole('admin')) disabled @endif
        >
    </div>

    <div class="col-6">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" value="{{old('name') ?? $organisation->name }}" name="name" aria-describedby="name">
        </div>
        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent</label>
            <select class="form-select" name="parent_id" id="parent_id">
                <option value=""></option>
                @foreach($parents as $parent)
                    <option value="{{$parent->id}}" {{$parent->id == (old('parent_id') ?? $organisation->parent_id) ? 'selected' : ''}}>{{$parent->id." - ".$parent->name}}</option>
                @endforeach
            </select>
        </div>

    </div>

    <div class="my-1 border-top pt-2 border-2">
        <button type="submit" class="btn btn-outline-primary">Update</button>
        <a href="{{route('organisations.show',['organisation' => $organisation])}}" class="btn btn-outline-secondary">Show</a>
    </div>
</form>
