<form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}

    <div class="col-xs-12 form-group">
        {!! Form::label('email','Email') !!}	
        {!! Form::email('email', $email or old('email'),['class' => 'form-control', 'required', 'autofocus']) !!}
    </div>

    <div class="input-group col-xs-12 text-center">
        <button type="button" class="resend-password-button form-data-button">
            Envoyer un email de réinitialisation
        </button>
    </div>
</form>