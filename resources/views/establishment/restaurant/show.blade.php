@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content show-page">
        <div id="ets-nav-bookmarks">
            <div class="ets-nav-bookmark bookmark-voucher">
                <span>Bon cadeau</span>
                <span class="bookmark-icon glyphicon glyphicon-gift" aria-hidden="true"></span>
            </div>
            <div class="ets-nav-bookmark bookmark-contact">
                <span>Nous contacter</span>
                <span class="bookmark-icon glyphicon glyphicon-phone" aria-hidden="true"></span>
            </div>
            <div class="ets-nav-bookmark bookmark-event">
                <span>Promotions et événements</span>
                <!--<span class="bookmark-icon glyphicon glyphicon-calendar" aria-hidden="true"></span>-->
                <img class="bookmark-icon" alt="events" src="/img/icons/ICONS-CALENDAR-EVENTS.svg"/>
                <!--<img class="bookmark-icon" alt="events" src="/img/icons/ICONS-MAP-PROMOTIONS.svg"/>-->
            </div>
        </div>
        <!------------- RESTAURANT INTRO -------------------------------------->
        <section class="container-fluid ets-intro">
            @component('components.divcell', ['style' => 'height: 100%;'])
                @slot('content')
                    <h1>{{ $establishment->getName() }}</h1>
                    <h2>{{ $data['cooking_type'] }}</h2>
                    @if(isset($data['specialties']))
                    <h3>
                        @foreach($data['specialties'] as $specialty)
                            @if($loop->index > 0)
                            <span class='point-separator'>&#9679;</span>
                            @endif
                            {{ $specialty }}                            
                        @endforeach
                    </h3>
                    @endif
                @endslot
            @endcomponent
        </section>
        <!------------- RESTAURANT DETAILS ------------------------------------>
        <section class="container-fluid ets-details">
            <div class="container">
                <h1>Qui <strong>sommes-nous</strong></h1>
                <p class="description">
                    {{ $establishment->getDescription() }}
                </p>
                <!--
                VIDEO
                -->
                <div class="row">
                    @if(isset($data['services']))
                    <div class="col-sm-6">
                        <h2>Services</h2>
                        @foreach($data['services'] as $service)
                        <ul class="category-list">
                            <li>{{ $service }}</li>
                        </ul>                            
                        @endforeach
                    </div>
                    @endif
                    @if(isset($data['ambiences']))
                    <div class="col-sm-6">
                        <h2>Cadre & ambiance</h2>
                        @foreach($data['ambiences'] as $ambience)
                        <ul class="category-list">
                            <li>{{ $ambience }}</li>
                        </ul>                            
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <!------------- RESTAURANT EVENTS & PROMO ----------------------------->
        @if(isset($data['events']) || isset($data['promo']))
        <section class="container-fluid ets-events">
            <div class="container">
                <h1>Nos <strong>événements</strong> et <strong>promotions</strong></h1>
                <div class="row">
                    <div class="col-sm-4">
                        <!--
                        CALENDAR
                        -->
                    </div>
                    <div class="col-sm-8">
                        <!--
                        EVENT INFO
                        -->
                    </div>
                </div>
            </div>
        </section>
        @endif
        <!------------- RESTAURANT STAFF -------------------------------------->
        @if(isset($data['staff']))
        <section class="container-fluid ets-staff">
            <div class="container">
                <h1>Notre <strong>équipe</strong></h1>
                <div class="row">
                    @foreach($data['staff'] as $staff)
                    <div class="col-sm-3">
                        <!--
                        STAFF
                        -->
                    </div>                    
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        <!------------- RESTAURANT STAFF -------------------------------------->
        @if(isset($data['timetable']))
        <section class="container-fluid ets-timetable">
            <div class="container">
                <h1><strong>Horaires</strong> d'ouverture</h1>
                <div class="row">
                    <div class="col-xs-5_5 col-sm-2_5">
                        &nbsp;
                    </div> 
                    <div class="col-xs-5_5 col-sm-4_5 col-sm-offset-0_5 col-label">
                        Déjeuner
                    </div>    
                    <div class="hidden-xs col-xs-5_5 col-sm-4_5 col-sm-offset-0 col-label">
                        Diner
                    </div>    
                </div>
                <div class="row timetable-show">
                    @foreach($data['timetable'] as $dayLabel => $timeslot)
                    <div class="row timetable-row">
                        <div class="col-xs-5_5 col-sm-2_5 timetable-day">
                            {{ $dayLabel }}
                        </div>    
                        @if(isset($timeslot[1]['no_break']) && $timeslot[1]['no_break'] == true)
                            <div class="col-xs-6_5 col-sm-9 col-xs-offset-0_5 text-center timetable-col">
                                @if(isset($timeslot[1]['time']))
                                    {{ $timeslot[1]['time'] }}
                                @endif
                            </div>
                        @else
                            <div class="col-xs-5_5 col-xs-offset-0_5 col-sm-4_5 timetable-col timetable-col-am">
                                @if(isset($timeslot[1]['time']))
                                    {{ $timeslot[1]['time'] }}
                                @endif
                            </div>    
                            <div class="col-xs-5_5 col-xs-offset-0_5 col-sm-4_5 col-sm-offset-0 timetable-col timetable-col-pm">
                                @if(isset($timeslot[2]['time']))
                                    {{ $timeslot[2]['time'] }}
                                @endif
                            </div>  
                        @endif
                    </div>
                    @endforeach
                </div>
                @if(isset($data['close_periods']))
                <div class="row">
                    <div class="col-xs-5_5 col-sm-3">
                        Fermeture exceptionnelle
                    </div>   
                </div>
                @endif
            </div>
        </section>
        @endif
         <!------------- CONTACT -------------------------------------->
        <section class="container-fluid ets-contact">
            <div class="container">
                <h1><strong>Nous</strong> contacter</h1>
                <div class="quick-map" data-lat="{{ $establishment->getLatitude() }}" data-lng="{{ $establishment->getLongitude() }}"></div>
                <div class="row ets-address">
                    <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                    {{ $data['address'] }}
                </div>
                <div class="row">
                    <button type="button" class="btn btn-default book-button">Réservez une table</button>
                </div>
                <div class="row contact-number">
                    <a href="tel:{{ $data['phone_number'] }}">
                        <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                        {{ $data['phone_number'] }}
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js_imports_footer')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection
