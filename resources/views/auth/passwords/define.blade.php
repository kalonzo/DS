@extends('layouts.front')

@section('content')

<div class="container">
    <h1 class="text-center">Définition de votre mot de passe</h1>
    <br/><br/>
    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
            <div class="col-md-6">
                <p class="form-control-static">{{ $email or old('email') }}</p>
                <input type="hidden" name="email" value="{{ $email or old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-md-4 control-label">Password</label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="button" class="btn btn-primary form-data-button pull-right">
                    Envoyer
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
