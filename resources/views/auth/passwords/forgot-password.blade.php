<form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}

    <div class="col-xs-12 form-group">
        Vous avez oublié votre mot de passe ?
        <br/><br/>
        Pour réinitialiser votre mot de passe, saisissez l’adresse email liée à votre compte et envoyez.
    </div>
    <br class="cleaner"/><br/>
    <div class="form-group">
        {!! Form::label('email', 'Email', ['class' => 'control-label col-xs-4 col-sm-3 col-md-2']) !!}	
        <div class="col-xs-8 col-sm-9 col-md-10">
            {!! Form::email('email', $email or old('email'),['class' => 'form-control', 'required', 'autofocus']) !!}
        </div>
    </div>

    <div class="input-group col-xs-12 text-center">
        <button type="button" class="resend-password-button form-data-button">
            Envoyer
        </button>
    </div>
</form>