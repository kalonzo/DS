@extends('layouts.front') 

@section('content')

<div class="container-fluid no-gutter">
    @if($success)
    <h2>Votre paiement a bien été enregistré</h2>
    <p>
        Votre demande d'inscription a bien été enregistrée. 
        @if(!count($errors))
            Un email de confirmation vous a été envoyé.
            <br/>
            Merci de cliquer sur le lien d'activation dans cet email pour confirmer votre adresse email et accéder à votre espace client.
        @else
            <p>
                Votre demande d'inscription a toutefois rencontré des erreurs.
                <br/>
                Nous vous recontacterons sous peu pour régulariser votre demande et ouvrir votre espace client. 
            </p>
        @endif
    </p>
    @else
    <h2>Votre paiement a échoué</h2>
    <p>
        Votre demande d'inscription n'a pu aboutir. 
        <br/>
        Nous vous recontacterons sous peu pour régulariser votre demande et ouvrir votre espace client. 
    </p>
    @endif
    
    
    @if(count($errors))
        <div class="alert alert-danger">
            Les erreurs suivantes ont été identifiées.
            <br/>
            <ul>
                @foreach($errors as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

@endsection