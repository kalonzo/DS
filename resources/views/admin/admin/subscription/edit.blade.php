@if(checkModel($subscription))
{!! Form::model($subscription, ['url' => '/admin/update/subscriptions/'.$subscription->getUuid(), 'method' => 'POST', 'files' => true]) !!}
@else
{!! Form::open(['url'=>'/admin/create/subscriptions', 'method' => 'PUT', 'files' => true]) !!}
@endif

<?php
if($subscription instanceof \App\Models\Subscription){
    $bill = $subscription->bill()->first();
    $user = $subscription->user()->first();
    $establishment = $subscription->establishment()->first();
    $buyableItem = $subscription->buyableItem()->first();
    $contract = null;
    if(checkModel($bill)){
        $contract = $bill->contract()->first();
    }
//    $results[$uuid]['num_contract'] = $queryResult->contract_number;
//    $results[$uuid]['num_bill'] = $queryResult->bill_number;
//    $results[$uuid]['user'] = $queryResult->owner;
//    $results[$uuid]['ets'] = $queryResult->ets_name;
//    $results[$uuid]['subscription'] = $queryResult->subscription_label;
//    $results[$uuid]['start_date'] = formatDate(new DateTime($queryResult->start_date));
//    $results[$uuid]['end_date'] = formatDate(new DateTime($queryResult->end_date));
//    $results[$uuid]['status'] = Subscription::getLabelFromStatus($queryResult->status);
}
?>

@if(checkModel($contract))
<div class="row">
    <div class="col-xs-12">
        <label class="col-sm-2"><strong>Contrat N°</strong></label>
        <div class="col-sm-10">
            {{ $contract->getNumber() }}
        </div>
    </div>
</div>
@endif
@if(checkModel($bill))
<div class="row">
    <div class="col-xs-12">
        <label class="col-sm-2"><strong>Facture N°</strong></label>
        <div class="col-sm-10">
            {{ $bill->getNumber() }}
        </div>
    </div>
</div>
@endif
@if(checkModel($user))
<div class="row">
    <div class="col-xs-12">
        <label class="col-sm-2"><strong>Client</strong></label>
        <div class="col-sm-10">
            {{ $user->getFirstname().' '.$user->getLastname() }}
            <br/>
            <a href='mailto:{{ $user->getEmail() }}'>{{ $user->getEmail() }}</a>
            <br/>
            <?php
            $phoneNumber = $user->getMainCallNumber();
            if(checkModel($phoneNumber)){
                $formattedPhoneNumber = formatPhone($phoneNumber->getPrefix(), $phoneNumber->getPhoneNumber(), 
                    \App\Http\Controllers\GeolocationController::getLocaleCountry());
                ?>
                <a href='tel:{{ $formattedPhoneNumber }}'>{{ $formattedPhoneNumber }}</a>
                <?php
            } else {
                echo "Aucun numéro de téléphone";
            }
            ?>
            <br/><br/>
        </div>
    </div>
</div>
@endif

@if(checkModel($establishment))
<div class="row">
    <div class="col-xs-12">
        <label class="col-sm-2"><strong>Etablissement</strong></label>
        <div class="col-sm-10">
            <?php
            if(!empty($establishment->getName())){
                ?>
                {{ $establishment->getName() }}
                <?php
            } else {
                echo "Création en attente";
            }
            ?>
            <br/>
            <?php
            $address = $establishment->address()->first();
            if(checkModel($address)){
                echo $address->getDisplayable();
                ?>
                <br/>
                <?php
            }
            ?>
            <strong>Business status:</strong> {{ $establishment->getBusinessStatus() }}%
            <br/>
            <strong>Statut:</strong> 
            <?php
            echo \App\Utilities\StyleTools::buildColoredSpan($establishment->getStatusLabel(), $establishment->getStatusColorClass());
            ?>
        </div>
    </div>
</div>
<br class="cleaner"/>
@endif

<div class="row">
    <div class="col-xs-12">
        <label class="col-sm-2"><strong>Abonnement</strong></label>
        <div class="col-sm-10">
            {{ $buyableItem->getDesignation() }}
            <br/>
            <?php
            echo formatPrice($buyableItem->getNetPrice(), App\Models\Currency::getCurrencyLabel($buyableItem->getIdCurrency()));
            ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <label class="col-sm-2"><strong>Statut</strong></label>
        <div class="col-sm-10">
            <?php
            echo \App\Utilities\StyleTools::buildColoredSpan($subscription->getStatusLabel(), $subscription->getStatusColorClass());
            ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <label class="col-sm-2"><strong>Date de début</strong></label>
        <div class="col-sm-10">
            {{ formatDate(new DateTime($subscription->getStartDate())) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <label class="col-sm-2"><strong>Date de fin</strong></label>
        <div class="col-sm-10">
            {{ formatDate(new DateTime($subscription->getEndDate())) }}
        </div>
    </div>
</div>
<br class="cleaner"/>
<div class="row">
    <div class="col-xs-12">
        <label class="col-sm-2"><strong>Paiement(s)</strong></label>
        <div class="col-sm-10">
            <?php
            $payments = $bill->payments()->orderBy('created_at')->get();
            if(!empty($payments)){
                ?><ul><?php
                foreach($payments as $payment){
                    ?>
                    <li>
                        Paiement enregistré le <?php echo formatDate(new DateTime($payment->created_at), \IntlDateFormatter::GREGORIAN, \IntlDateFormatter::SHORT); ?>
                        <br/>
                        <?php echo formatPrice($payment->getAmount(), App\Models\Currency::getCurrencyLabel($payment->getIdCurrency()));?>
                        <br/>
                        <?php echo App\Models\PaymentMethod::getLabelFromMethod($payment->getIdPaymentMethod());?>
                        <br/>
                        <?php echo \App\Utilities\StyleTools::buildColoredSpan($payment->getStatusLabel(), $payment->getStatusColorClass());?>
                    </li>
                    <?php
                }
                ?></ul><?php
            } else {
                echo "Aucun paiement";
            }
            ?>
        </div>
    </div>
</div>
        
{{--
<div class="row">
    <div class="col-xs-12 col-sm-6 form-group">
        {!! Form::label('status', 'Statut') !!}
        {!! Form::select('status', $status, old('status'), ['class' => 'form-control']) !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        {!! Form::button('Enregistrer', ['type' => 'button', 'class' => 'form-data-button btn btn-default pull-right']) !!}
    </div>
</div>
--}}
{!! Form::close() !!}