@extends('layouts.admin')

@section('sidebar')
<ul class="nav nav-sidebar">
    <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
</ul>
@endsection

@section('content')
    <?php
    if(Request::get('display_locale')){
        echo "Locale : ".App::getLocale();
        echo "<br/>Browser conf : ".$_SERVER['HTTP_ACCEPT_LANGUAGE'];
        echo "<br/>Country Locale : ".\App\Http\Controllers\GeolocationController::getLocaleCountry();
    }
    ?>
    @component('components.tile', ['title' => 'Etablissements', 'add_href' => '/create/establishment', 
                                    'tabledata' => $dt_establishment_admin])

    @endcomponent
    
    @component('components.tile', ['title' => 'Clients', 'add_href' => '/admin/user_pro/register', 
                                    'tabledata' => $dt_user_pro_admin])

    @endcomponent

    @component('components.tile', ['title' => 'Modération des médias (établissements)', 'tabledata' => $dt_establishment_media_moderation])

    @endcomponent
    
    @component('components.booking-tile-calendar', ['title' => 'Réservations', 'tabledata' => $dt_booking_admin])

    @endcomponent

    @component('components.tile', ['title' => 'Catégories classificatives pour les restaurants', 'tabledata' => $dt_business_category_admin,
                                    'add_href' => 'javascript:getOnClickModal("Créer une catégorie", "/admin/create/business_categories")'])

    @endcomponent

    @component('components.tile', ['title' => 'Types de business', 'tabledata' => $dt_business_type_admin])

    @endcomponent

    @component('components.tile', ['title' => 'Promotions', 'add_href' => 'javascript:getOnClickModal("Créer une promotion", "/admin/create/promotions")', 
                                    'tabledata' => $dt_promotion_admin])

    @endcomponent
    
    @component('components.tile', ['title' => 'Evénements', 'add_href' => 'javascript:getOnClickModal("Créer un événement", "/admin/create/events")', 
                                    'tabledata' => $dt_event_admin])

    @endcomponent
    
    @component('components.tile', ['title' => 'Utilisateurs', 'add_href' => 'javascript:getOnClickModal("Créer un administrateur", "/admin/create/users")', 
                                    'tabledata' => $dt_user_admin])

    @endcomponent

@endsection
