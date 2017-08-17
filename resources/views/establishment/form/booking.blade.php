{!! Form::open(['id'=>'feed-establishment', 'url'=>'/establishment']) !!}
<div class="row">
    <div class="col-md-12 form-group">
        <div><h4>Choisissez<strong>une date</strong></h4></div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::date('datetime_reservation', old('date'), ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div><h4>Choisissez<strong>l'heure</strong></h4></div>
        <div class="row">
            <div class="col-md-6">
                Déjeuner
            </div>
            <div class="col-md-6 form-group">
                {!! Form::time('time', old('time'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 ">
                Diner
            </div>
            <div class="col-md-6 form-group">
                {!! Form::time('time', old('time'), ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div ><h4>Pour<strong>combien de personnes</strong></h4></div>
        <div class="row">
            <div class="col-md-6 form-group">
                {!! Form::selectRange('nb_adults', 1, 100) !!}
            </div>
            <div class="col-md-6">
                Personne
            </div>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div ><h4>Info<strong>du contact</strong></h4></div>
        <div class="row">
            <div class="col-md-12 form-group">
                Saissisez vos coordonées pour finaliser votre résérvation 
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                Prénom
                {!! Form::text('firstname',old('range')) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                Nom
                {!! Form::text('lastname',old('range')) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                Email
                {!! Form::text('email',old('range')) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                Portable
                {!! Form::text('phone_number',old('range')) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                Ajouter une demande particulière
                {!! Form::textarea('comment', old('content'), ['class' => 'form-control', 
                'placeholder' => 'Allergie/habitude alimentaire']) !!}  
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class='row'><h4>Inviter<strong>des amis</strong></h4></div>
        <div class="row">
            <div class="col-md-12 form-group">
                {!! Form::label('Pour l\'envoyer à plusieur amis, merci de séparer les emails par des points virgule') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                {!! Form::label('Message de l\'invitation') !!}
                {!! Form::textarea('message', old('message'), ['class' => 'form-control', 
                'placeholder' => 'Votre message']) !!}  
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                {!! Form::label('Message de l\'invitation') !!}
                {!! Form::textarea('message', old('message'), ['class' => 'form-control', 
                'placeholder' => 'Votre message']) !!}  
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                {!! Form::label('Recevoir la copie de l\'invitation par email') !!}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 form-group alert-info">
                {!! Form::submit('Valider votre résérvation') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                {!! Form::label('En cliquant sur valider votre réservation vous acceptez les conditions général de vente.') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group alert-info">
                {!! Form::submit('Nous renvoyons l’information au restaurant . Veuillez attendre la confirmation de votre table par email.') !!}
            </div>
        </div>
    </div>
</div>
{!! form::close() !!}