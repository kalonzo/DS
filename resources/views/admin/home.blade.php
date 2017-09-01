@extends('layouts.admin')

@section('sidebar')
<ul class="nav nav-sidebar">
    <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
    <li><a href="#">Clients</a></li>
    <li><a href="#">Produits</a></li>
    <li><a href="#">Commandes</a></li>
    <li><a href="#">Paniers</a></li>
</ul>
@endsection

@section('content')

@component('components.tile', ['title' => 'Etablissements', 'add_href' => '/establishment/create', 
                                'tabledata' => $establishment_datatable])

@endcomponent

@component('components.tile', ['title' => 'Réservation', 'tabledata' => $booking_datatable])

@endcomponent

@component('components.tile', ['title' => 'Type de catégorie restaurant', 'tabledata' => $business_category_datatable])

@endcomponent

@endsection