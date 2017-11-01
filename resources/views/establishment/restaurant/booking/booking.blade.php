<div class="container-fluid" id="booking-container">
    {!! Form::open(['url' => '/establishment/booking/'.$establishment->getUuid(),'method' => 'POST']) !!}
    <div class="row form-group">   
        <input type="hidden" name="date_now" value="<?php echo $form_data['datetime_reservation']; ?> "/>
        <div class="col-xs-12">
            <h3 class="row">Choisissez <strong>une date</strong></h3>
            <div id="datepicker-booking">     
                {!! Form::hidden('datetime_reservation', $form_data['datetime_reservation']) !!}
            </div>
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(event) { 

                    $('#datepicker-booking').each(function(){
                        var $input = $(this).find('input[type=hidden]');
                        if(checkExist($input)){
                            var options = {
                                dateFormat: "dd/mm/yy",
                                defaultDate: $input.val(),
                                minDate: 0,
                                onSelect: function(dateText, inst){
                                    $($input).val(dateText).change();
                                    
                                    var ajaxParams = {};
                                    ajaxParams['action'] = 'change_date';
                                    ajaxParams['date'] = dateText;
                                    $.ajax({
                                        url: '/establishment/booking/{!!$establishment->getUuid()!!}/ajax',
                                        data: ajaxParams,
                                        dataType: 'json',
                                        method: 'POST',
                                        success: function( data ) {
                                            if(data.success){
                                                $('#time-booking').empty().html(data.content);
                                            }
                                        }
                                    });
                                }
                            };
                            $.datepicker.setDefaults($.datepicker.regional[ "fr" ]);
                            $.datepicker.setDefaults({dayNamesMin: $.datepicker._defaults.dayNamesShort});
                            $(this).datepicker(options);
                        }
                    });
                });
            </script>
        </div>
    </div>
    <div class="row">
        <h3>Choisissez <strong>l'heure</strong></h3>
        <div id="time-booking">
            @component('establishment.restaurant.booking.booking-hours', ['establishment' => $establishment, 'form_data' => $form_data])

            @endcomponent
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
        <?php
        $firstname = old('firstname');
        $lastname = old('lastname');
        $email = old('email');
        $prefix = $form_data['id_country'];
        $phone_number = old('phone_number');
        if(Illuminate\Support\Facades\Auth::check()){
            $user = Illuminate\Support\Facades\Auth::user();
            $firstname = $user->getFirstname();
            $lastname = $user->getLastname();
            $email = $user->getEmail();
            $callNumber = $user->getMainCallNumber();
            if(checkModel($callNumber)){
                $prefix = $callNumber->getPrefix();
                $phone_number = $callNumber->getNumber();
            }
        }
        ?>
        <div class="col-xs-12 form-group">
            {!! Form::label('firstname','Prénom*') !!}
            {!! Form::text('firstname', $firstname, ['class' => 'form-control']) !!}
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('lastname','Nom*') !!}
            {!! Form::text('lastname', $lastname, ['class' => 'form-control']) !!}
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('email','Email*') !!}
            {!! Form::email('email', $email, ['class' => 'form-control']) !!}
        </div>
        <div class="col-xs-12 phone-form-group">
            {!! Form::label('phone_number','Téléphone / Mobile') !!}
            <div class="form-group form-inline">                        
                {!! Form::select('prefix', $form_data['country_prefixes'], $prefix, 
                ['class' => 'form-control select2', 'placeholder' => 'Indicatif']) !!}
                {!! Form::text('phone_number', $phone_number, ['class' => 'form-control']) !!}
            </div>
        </div>
        @if(!Auth::check())
        <div class="col-xs-12 checkbox">
            <label>
                {!! Form::checkbox('create_account', 1, true) !!}
                Créer un compte utilisateur
            </label>
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('password','* Mot de passe') !!}	
            {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="col-xs-12 form-group">
            {!! Form::label('password_confirmation','* Confirmer votre mot de passe') !!}	
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
        </div>
        @endif
        <div class="col-xs-12 form-group">
            {!! Form::label('comment','Ajouter une demande particulière') !!}
            {!! Form::textarea('comment', old('content'), ['class' => 'form-control', 'placeholder' => 'Allergie/habitude alimentaire']) !!}  
        </div>
    </div>
    <div class="row booking-invitation" style="text-transform: none;">
        <h3 class="text-uppercase">Inviter des <strong>amis</strong></h3>
        <div class="col-xs-12 form-group">
            {!! Form::label('invited_emails', 'Pour l\'envoyer à plusieurs amis, merci de séparer les emails par des virgules') !!}
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
                    {!! Form::button('Valider votre réservation', ['class' => 'book-button form-data-button', 'type' => 'button']) !!}
                </div>
            </div>
            <br class="cleaner"/>
            <div class="row">
                <div class="col-xs-12 validation-clause">
                    En cliquant sur valider votre réservation vous acceptez <a href="#">les conditions générales de vente</a>
                </div>
            </div>
            <br class="cleaner"/>
            <div class="row">
                <div class="col-xs-12 validation-clause">
                    Nous envoyons l’information au restaurant. Veuillez attendre la confirmation de votre table par email.
                </div>
            </div>
        </div>
    </div>
    {!! form::close() !!}
</div>