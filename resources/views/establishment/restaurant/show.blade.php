@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
<link href="/css/sidebar.css" rel="stylesheet">
@endsection

@section('navbar-right')
    <li>
        <button type="button" class="btn book-button sidebar-booking-toggler" >Réservez une table</button>
    </li>
@endsection

@section('content')
    <aside id="sidebar-booking" class="custom-sidebar sidebar-fixed-right ref-scroller" data-toggler=".sidebar-booking-toggler">
           @component('establishment.form.booking', ['establishment' => $establishment, 'form_data' => $form_data])
           @endcomponent
    </aside>
    <div class="content show-page custom-sidebar-content-wrapper">
        <div id="ets-nav-bookmarks">
            <div class="ets-nav-bookmark bookmark-voucher" title="Bon cadeau">
                <a href="{{ $establishment->getUrl() }}#voucher" class="simple">
                    <span>Bon cadeau</span>
                    <span class="bookmark-icon glyphicon glyphicon-gift" aria-hidden="true"></span>
                </a>
            </div>
            <div class="ets-nav-bookmark bookmark-contact" title="Nous contacter">
                <a href="{{ $establishment->getUrl() }}#contact" class="simple">
                    <span>Nous contacter</span>
                    <span class="bookmark-icon glyphicon glyphicon-phone" aria-hidden="true"></span>
                </a>
            </div>
            @if(isset($data['events']) || isset($data['promo']))
            <div class="ets-nav-bookmark bookmark-event" title="Promotions et événements">
                <span>Promotions et événements</span>
                <a href="{{ $establishment->getUrl() }}#events" class="simple">
                    <!--<span class="bookmark-icon glyphicon glyphicon-calendar" aria-hidden="true"></span>-->
                    <img class="bookmark-icon" alt="events" src="/img/icons/ICONS-CALENDAR-EVENTS.svg"/>
                    <!--<img class="bookmark-icon" alt="events" src="/img/icons/ICONS-MAP-PROMOTIONS.svg"/>-->
                </a>
            </div>
            @endif
            @if($page != null)
            <div class="ets-nav-bookmark bookmark-home" title="Le restaurant">
                <a href="{{ $establishment->getUrl() }}" class="simple">
                    <span>Le restaurant</span>
                    <span class="bookmark-icon glyphicon glyphicon-home" aria-hidden="true"></span>
                </a>
            </div>
            @endif
            @if($page != 'menu')
            <div class="ets-nav-bookmark bookmark-menu" title="Menus">
                <a href="{{ $establishment->getUrl() }}menu" class="simple">
                    <span>Menus</span>
                    <span class="bookmark-icon glyphicon glyphicon-cutlery" aria-hidden="true"></span>
                </a>
            </div>
            @endif
            @if($page != 'photos')
            <div class="ets-nav-bookmark bookmark-photos" title="Photos">
                <a href="{{ $establishment->getUrl() }}photos" class="simple">
                    <span>Photos</span>
                    <span class="bookmark-icon glyphicon glyphicon-picture" aria-hidden="true"></span>
                </a>
            </div>
            @endif
        </div>
        <!------------- RESTAURANT INTRO -------------------------------------->
        <section class="container-fluid ets-intro">
            @component('components.divcell', ['style' => 'height: 100%;'])
                @slot('content')
                    <h1>{{ $establishment->getName() }}</h1>
            {{ Route::currentRouteName() }}
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
        <section class="container-fluid ets-events" id="events">
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
        <!------------- RESTAURANT TIMETABLE ---------------------------------->
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
         <section class="container-fluid ets-contact" id="contact">
            <div class="container">
                <h1><strong>Nous</strong> contacter</h1>
                <div class="quick-map" data-lat="{{ $establishment->getLatitude() }}" data-lng="{{ $establishment->getLongitude() }}"></div>
                <div class="row ets-address">
                    <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                    {{ $data['address'] }}
                </div>
                <div class="row">
                    <button type="button" class="btn book-button sidebar-booking-toggler" >Réservez une table</button>
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
<script src="/js/sidebar.js"></script>
<script src="/js/form-validation.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection
