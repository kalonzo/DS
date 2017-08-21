<div class="container-fluid" id="booking-container">
    {!! Form::open(['url' => '/establishment/booking/{{ $establishment->getUuid() }}']) !!}
    <div class="row form-group">
        <div class="col-xs-12">
            <h3 class="row">Choisissez <strong>une date</strong></h3>
            <div class="datepicker-inline">
                {!! Form::hidden('datetime_reservation', '23/12/2017', ['class' => '']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <h3>Choisissez <strong>l'heure</strong></h3>
        <div class="form-horizontal">
            <div class="form-group">
                {!! Form::label('time[1]', 'Déjeuner', ['class' => 'col-xs-6 control-label']) !!}	
                <div class="col-xs-6">
                    {!! Form::time('time[1]', old('time'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('time[2]', 'Diner', ['class' => 'col-xs-6 control-label']) !!}	
                <div class="col-xs-6">
                    {!! Form::time('time[2]', old('time'), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h3>Pour <strong>combien de personnes</strong></h3>
        <div class="form-inline form-group text-center text-lowercase">
            {!! Form::selectRange('nb_adults', 1, 30) !!}
            &nbsp;personnes
        </div>
    </div>
    <div class="row booking-contact" style="text-transform: none;">
        <h3 class="text-uppercase">Info du <strong>contact</strong></h3>
        <div class="col-xs-12">
            Saisissez vos coordonnées pour finaliser votre réservation 
        </div>
        <br class="cleaner"/>
        <div class="col-xs-12 form-group">
            {!! Form::label('firstname','Prénom*') !!}
            {!! Form::text('firstname', old('firstname'), ['class' => 'form-control']) !!}
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('lastname','Nom*') !!}
            {!! Form::text('lastname',old('lastname'), ['class' => 'form-control']) !!}
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('email','Email*') !!}
            {!! Form::text('email',old('email'), ['class' => 'form-control']) !!}
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('phone_number','Portable*') !!}
            {!! Form::text('phone_number',old('phone_number'), ['class' => 'form-control']) !!}
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('comment','Ajouter une demande particulière*') !!}
            {!! Form::textarea('comment', old('content'), ['class' => 'form-control', 'placeholder' => 'Allergie/habitude alimentaire']) !!}  
        </div>
    </div>
    <div class="row booking-invitation" style="text-transform: none;">
        <h3 class="text-uppercase">Inviter des <strong>amis</strong></h3>
        <div class="col-xs-12 form-group">
            {!! Form::label('invited_emails', 'Pour l\'envoyer à plusieur amis, merci de séparer les emails par des virgules') !!}
            {!! Form::textarea('invited_emails', old('invited_emails'), ['class' => 'form-control']) !!}  
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('message','Message de l\'invitation') !!}
            {!! Form::textarea('message', old('message'), ['class' => 'form-control', 'placeholder' => 'Votre message']) !!}  
        </div>
        <div class="col-xs-12 checkbox">
            <label>
                {!! Form::checkbox('copy_invitation', 1, false) !!}
                Recevoir la copie de l'invitation par email
            </label>
        </div>
    </div>
    <div class="row booking-validation" style="text-transform: none;">
        <div class="col-xs-12">
            <div class="row ">
                <div class="col-xs-12">
                    {!! Form::button('Valider votre réservation', ['class' => 'book-button', 'type' => 'submit']) !!}
                </div>
            </div>
            <br class="cleaner"/>
            <div class="row">
                <div class="col-xs-12 validation-clause">
                    En cliquant sur valider votre réservation vous acceptez <a href="#">les conditions général de vente</a>
                </div>
            </div>
            <br class="cleaner"/>
            <div class="row">
                <div class="col-xs-12 validation-clause">
                    Nous renvoyons l’information au restaurant . Veuillez attendre la confirmation de votre table par email.
                </div>
            </div>
        </div>
    </div>
    {!! form::close() !!}
</div>