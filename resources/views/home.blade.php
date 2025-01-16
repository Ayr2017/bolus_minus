@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{ __('You are logged in!') }}
        </div>
    </div>

        <div class="card mt-4">
        <div class="card-header">{{ __('Sanctum token') }}</div>
        <div class="card-body">
            <div class="input-group mb-3">
                <button id="tokenBtn" class="btn btn-primary" type="button" id="button-addon2">Get token</button>
                <input id="tokenInput" type="text" class="form-control" placeholder="Your token will be here">
            </div>
            <div id="tokenMessage" class="alert alert-primary d-none" role="alert"></div>
            <p><a href="{{route('scramble.docs.ui')}}" target="_blank" class="btn btn-primary">Open docs (Scramble) <i class="bi bi-box-arrow-up-right"></i></a></p>

            <script>
                document.getElementById('tokenBtn').addEventListener('click', async function () {
                    const email = @json(config('seed.admin_email'));
                    const password = @json(config('seed.admin_password'));
                    const response = await fetch('/api/sanctum/token', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json',},
                        body: JSON.stringify({
                            email: email,
                            password: password,
                            device_name: "My Device",
                        }),
                    });
                    const data = await response.json();

                    if (response.ok) {
                        const token = data.data.token;
                        document.getElementById('tokenInput').value = token;
                        navigator.clipboard.writeText(token).then(() => {
                            document.getElementById('tokenMessage').innerText = "Токен скопирован";
                            document.getElementById('tokenMessage').classList.remove("d-none");
                        });
                    } else {
                        document.getElementById('tokenMessage').innerText = data.message;
                        document.getElementById('tokenMessage').classList.remove("d-none");
                    }
                });
            </script>
        </div>
    </div>
@endsection
