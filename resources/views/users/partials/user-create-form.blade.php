<form action="{{route('users.store')}}" method="POST">
    @csrf

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="name" class="form-label">Фамилия*</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="surname"
            name="surname"
            value="{{ old('surname')}}"
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
            value="{{ old('name') }}"
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
            value="{{ old('lastname')  }}"
            style="max-width: 400px;"
        >
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="role" class="form-label">Должность*</label>



            <div class="mb-3">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    name="roles_names[]"
                    placeholder="Введите должность"
                    style="max-width: 400px;"
                >
            </div>
    </div>


    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="phone" class="form-label">Телефон*</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="phone"
            name="phone"
            value="{{ old('phone') }}"
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
            value="{{ old('email') }}"
            style="max-width: 400px;"
        >
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label for="email" class="form-label">Пароль*</label>
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
            type="number"
            class="form-control form-control-sm"
            id="uuid"
            name="uuid"

            style="max-width: 400px;"
            @if(!auth()->user()->hasRole('admin')) disabled @endif
        >
    </div>

    <button type="submit" class="btn btn-sm  @if(!auth()->user()->hasRole('admin') and auth()->user()->id !== $user->id) btn-outline @else btn-outline-primary  @endif"
            @if(!auth()->user()->hasRole('admin') and auth()->user()->id !== $user->id) disabled  @endif
    >Сохранить</button>
</form>
