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

@component('components.datatable', ['rows' => $establishments, 'title' => 'Etablissements', 'add_href' => '/establishment/create',
                                    'columns' => ['name' => 'Nom', 'type' => 'Type', 'city' => 'Ville', 'updated_at' => 'Modifié le']])

@endcomponent

@endsection