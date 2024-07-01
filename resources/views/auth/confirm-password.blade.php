<x-guest-layout>
    <style>
        .logo-center {
            display: block;
            margin-left: auto;
            margin-right: auto;


        }
    </style>
    <x-authentication-card>
    <x-slot name="logo">
            <x-authentication-card-logo class="logo-center" />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.') }}
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('Confirmar') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>