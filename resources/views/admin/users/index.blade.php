@extends('layouts.sidebar')

@extends('layouts.header')
<!-- Aquí puedes agregar tu formulario, tabla u otro contenido -->




@section('content')
@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
        @endif

<h1>Lista de usuarios</h1>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registerModal">
    Registrar nuevo Usuario
</button>
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Registrar nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí puedes poner tu formulario de registro -->
                <form method="POST" action="{{ route('users.store') }}" style="background: none; color: black;">
                    @csrf

                    <div style="margin-bottom: 1em;">
                        <label for="name" style="display: block;">{{ __('Name') }}</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" style="width: 100%; padding: .5em;">
                    </div>

                    <div style="margin-bottom: 1em;">
                        <label for="email" style="display: block;">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" style="width: 100%; padding: .5em;">
                    </div>

                    <div style="margin-bottom: 1em;">
                        <label for="password" style="display: block;">{{ __('Password') }}</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" style="width: 100%; padding: .5em;">
                    </div>

                    <div style="margin-bottom: 1em;">
                        <label for="password_confirmation" style="display: block;">{{ __('Confirm Password') }}</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" style="width: 100%; padding: .5em;">
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div style="margin-bottom: 1em;">
                        <label for="terms">
                            <div>
                                <input type="checkbox" name="terms" id="terms" required />

                                <div>
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </label>
                    </div>
                    @endif
                

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" style="background-color: blue; color: white; padding: .5em 1em; border: none;">
                            {{ __('Register') }}
                        </button>
                    </div>

                </form>
        </div>
    </div>
</div>
@livewire('admin.users-index')


@endsection