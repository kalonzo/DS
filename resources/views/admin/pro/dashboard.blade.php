@extends('layouts.admin')

@section('sidebar')
<ul class="nav nav-sidebar">
    <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
</ul>
@endsection

@section('content')
    
    @component('components.booking-tile-calendar', ['title' => 'Réservations', 'tabledata' => $dt_booking_pro])

    @endcomponent

    @component('components.tile', ['title' => 'Promotions', 'add_href' => 'javascript:getOnClickModal("Créer une promotion", "/admin/create/promotions")', 
                                    'tabledata' => $dt_promotion_admin])

    @endcomponent
    
    @component('components.tile', ['title' => 'Evénements', 'add_href' => 'javascript:getOnClickModal("Créer un événement", "/admin/create/events")', 
                                    'tabledata' => $dt_event_admin])

    @endcomponent

@endsection
