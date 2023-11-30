<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Egide</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
<div class="wrap">
    <x-guest-layout>
        <x-auth-card>
            <div class="card" style="background: #5337FF; max-width:45%; margin-inline:auto;">

                        <!--  <x-slot name="logo">

                    </x-slot>-->

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <div class="myHead text-center">
                            <i class=""></i>
                            <p>Entrar</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="main-form text-center">
                            @csrf
                            <picture>
                            <img class="mb-4" src="..\public\assets\brand\user_logo.png" alt="" width="72" height="65">
                            </picture>


                            <!-- E-mail Address -->
                            <div class="form-group my-0">
                                <label for="email" :value="__('Email')" class="my-0" />
                                <i class="bi bi-person-circle icon-login"></i>
                                <x-input id="email" class="myInput" type="email" name="email" placeholder="Usuário"
                                    :value="old('email')" required autofocus />
                                </label>
                            </div>

                            <!-- Password -->
                            <div class="form-group my-0">
                                <label for="password" :value="__('Password')" class="my-0" />
                                <i class="bi bi-lock icon-login"></i>
                                <x-input id="password" class="myInput" type="password" name="password" required
                                    autocomplete="current-password" placeholder="Senha" />
                            </div>

                            <!-- Remember Me -->
                            <label for="remember_me" class="check_1">
                                <input id="remember_me" type="checkbox" checked class="form-check-input"
                                    name="remember">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Lembre-me') }}</span>
                            </label>

                            <!-- Button Login -->
                            <div class="form-group my-0">
                                @if (Route::has('password.request'))
                                <a class="text-sm text-light-600 hover:text-light-900" style="text-decoration:none; color: #fff;"
                                    href="{{ route('password.request') }}">
                                    {{ __('Esqueceu a senha?') }}
                                </a>
                                <br>
                                @endif
                                <br>
                            
                                <x-button class="btn btn-success">
                                    {{ __('Entrar') }}
                                </x-button>
                                <br>
                                <br>

                                <a href="{{ route('register') }}" style="text-decoration:none; color: #fff;">Cadastrar</a>
                                
                            </div>
                        </form>

                    </div>


        </x-auth-card>
    </x-guest-layout>
</div>
</body>
</html>
