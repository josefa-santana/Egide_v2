<x-guest-layout>
    <x-auth-card>
        <!--     <x-slot name="logo">
        
        </x-slot>-->
        <div class="card" style="background: #5337FF; max-width:45%; margin-inline:auto;">


            <br>
            <br>

            <div class="main-form text-center">
                <div class="mb-4 text-sm text-light-600">
                    {{ __('Esqueceu sua senha? Sem problemas. Just let us know your email address and we will email you
                    a
                    password reset link that will allow you to choose a new one.') }}
                </div>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('password.email') }}" class="main-form text-center">
                @csrf

                <!-- Email Address -->
                <div class="form-group my-0">
                    <label for="email" :value="__('Email')" class="my-0" />
                    <i class="bi bi-envelope-fill icon-login"></i>
                    <x-input id="email" class="myInput" type="email" name="email" placeholder="Email"
                        :value="old('email')" required autofocus />
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="btn btn-warning">
                        {{ __('Email Password Reset Link') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>