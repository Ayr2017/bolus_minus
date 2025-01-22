<form action="{{route('users.update',['user'=>$user])}}" method="POST">
    @csrf
    @method('PATCH')

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="name" class="form-label">Фамилия*</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="surname"
            name="surname"
            value="{{ old('surname') ?? $user->surname }}"
            style="max-width: 400px;"
        >
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="name" class="form-label">Имя*</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="name"
            name="name"
            value="{{ old('name') ?? $user->name }}"
            style="max-width: 400px;"
        >
    </div>


    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="lastname" class="form-label">Отчество*</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="lastname"
            name="lastname"
            value="{{ old('lastname') ?? $user->lastname }}"
            style="max-width: 400px;"
        >
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="role" class="form-label">Должность*</label>

        @if($user->roles->isNotEmpty())
            @foreach($user->roles as $role)
                <div class="mb-3">
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        id="roles_names{{$role->id}}"
                        name="roles_names[]"
                        value="{{ old('role') ?? $role->name }}"
                        style="max-width: 400px;"
                    >
                </div>
            @endforeach
        @else
            <div class="mb-3">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    name="roles_names[]"
                    placeholder="Введите должность"
                    style="max-width: 400px;"
                >
            </div>
        @endif
    </div>


    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="phone" class="form-label">Телефон*</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="phone"
            name="phone"
            value="{{ old('phone') ?? $user->phone }}"
            style="max-width: 400px;"
        >
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="email" class="form-label">Почта*</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="email"
            name="email"
            value="{{ old('email') ?? $user->email }}"
            style="max-width: 400px;"
        >
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="email" class="form-label">Пароль</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="password"
            name="password"

            style="max-width: 400px;"
        >
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="email" class="form-label">Идентификатор пользователя</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="password"
            name="password"

            style="max-width: 400px;"
            @if(!auth()->user()->hasRole('admin')) disabled @endif
        >
    </div>

    <button type="submit" class="btn btn-sm  @if(!auth()->user()->hasRole('admin') and auth()->user()->id !== $user->id) btn-outline @else btn-outline-primary  @endif"
            @if(!auth()->user()->hasRole('admin') and auth()->user()->id !== $user->id) disabled  @endif
    >Сохранить</button>
</form>
