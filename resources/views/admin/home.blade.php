@extends('layouts.admin')

@section('sidebar')
<ul class="nav nav-sidebar">
    <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
</ul>
@endsection

@section('content')

    @component('components.tile', ['title' => 'Etablissements', 'add_href' => '/establishment/create', 
                                    'tabledata' => $establishment_datatable])

    @endcomponent

    @component('components.booking-tile-calendar', ['title' => 'Réservations', 'tabledata' => $booking_pro_datatable])

    @endcomponent

    @component('components.tile', ['title' => 'Catégories classificatives pour les restaurants', 'tabledata' => $business_category_datatable])

    @endcomponent

    @component('components.tile', ['title' => 'Promotions', 'add_href' => 'javascript:getOnClickModal("Créer une promotion", "/admin/create/promotions")', 
                                    'tabledata' => $promotion_datatable])

    @endcomponent
    
    @component('components.tile', ['title' => 'Evénements', 'add_href' => 'javascript:getOnClickModal("Créer un événement", "/admin/create/events")', 
                                    'tabledata' => $event_datatable])

    @endcomponent

@endsection
