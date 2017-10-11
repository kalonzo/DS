<div id="register-modal-title">
    Créer un compte Dinerscope
</div>
<form class="" method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}
    @if(isset($type_user))
    {!! Form::hidden('type_user', $type_user) !!}
    @endif
    
    <div class="col-xs-12 form-group">
        {!! Form::label('lastname','* Nom') !!}	
        {!! Form::text('lastname', old('lastname'),['class' => 'form-control', 'required', 'autofocus']) !!}
    </div>

    <div class="col-xs-12 form-group">
        {!! Form::label('firstname','* Prénom') !!}	
        {!! Form::text('firstname', old('firstname'),['class' => 'form-control', 'required', 'autofocus']) !!}
    </div>

    <div class="col-xs-12 form-group">
        {!! Form::label('email','* Email') !!}	
        {!! Form::email('email', old('email'),['class' => 'form-control', 'required']) !!}
    </div>

    <div class="col-xs-12 form-group">
        {!! Form::label('password','* Mot de passe') !!}	
        {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
    </div>

    <div class="col-xs-12 form-group">
        {!! Form::label('password_confirmation','* Confirmer votre mot de passe') !!}	
        {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
    </div>
    
    <div class="col-xs-12 checkbox newsletter-subscription">
        <label>
            {!! Form::checkbox('subscribe_emailing', 1, true) !!}
            Recevoir la newsletter et les promotions
        </label>
    </div>
    
    <div class="input-group col-xs-12 text-center">
        <button type="button" class="register-button form-data-button">
            Enregistrer
        </button>
    </div>
    <p class="text-center">
        En cliquant sur "Enregistrer", vous acceptez les <a href="#">conditions générales d'utilisation</a> de Dinerscope
    </p>
</form>