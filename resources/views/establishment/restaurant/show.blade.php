@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
<link href="/css/sidebar.css" rel="stylesheet">
<link href="/libraries/baguettebox/baguetteBox.min.css" rel="stylesheet">
@endsection

@section('navbar-right')
    <li>
        <button type="button" class="btn book-button sidebar-booking-toggler" >Réservez une table</button>
    </li>
@endsection

@section('content')
    <aside id="sidebar-booking" class="custom-sidebar sidebar-fixed-right ref-scroller" data-toggler=".sidebar-booking-toggler">
           @component('establishment.restaurant.feed.booking', ['establishment' => $establishment, 'form_data' => $form_data])
           @endcomponent
    </aside>
    <div class="content show-page custom-sidebar-content-wrapper">
        <div id="ets-nav-bookmarks">
            <div class="ets-nav-bookmark bookmark-voucher app-disabled" title="Bon cadeau">
                <a href="{{ $establishment->getUrl() }}#voucher" class="simple">
                    <span>Bon cadeau</span>
                    <span class="bookmark-icon glyphicon glyphicon-gift" aria-hidden="true"></span>
                </a>
            </div>
            <div class="ets-nav-bookmark bookmark-contact" title="Nous contacter">
                <a href="#contact" class="simple">
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
            <div class="section-bg"></div>
            @component('components.divcell', ['style' => 'height: 100%;'])
                @slot('content')
                    <h1>{{ $establishment->getName() }}</h1>
                    <h2>@lang('Cuisine') {{ $data['cooking_type'] }}</h2>
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
        @if($page === 'photos')
            @component('establishment.restaurant.show-gallery', ['establishment' => $establishment, 'form_data' => $form_data, 'data' => $data])
            @endcomponent
        @elseif($page === 'menu')
            @component('establishment.restaurant.show-menu', ['establishment' => $establishment, 'form_data' => $form_data, 'data' => $data])
            @endcomponent
        @else
            @component('establishment.restaurant.show-main', ['establishment' => $establishment, 'form_data' => $form_data, 'data' => $data])
            @endcomponent
        @endif
         <!------------- CONTACT -------------------------------------->
         <section class="container-fluid ets-contact" id="contact">
            <div class="section-bg"></div>
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
                @if(isset($data['phone_number']))
                <div class="row contact-number">
                    <a href="tel:{{ $data['phone_number'] }}">
                        <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                        {{ $data['phone_number'] }}
                    </a>
                </div>
                @endif
            </div>
        </section>
    </div>

    <?php
    if($establishment->homePictures()->exists()){
        ?><style>
        .show-page section{
            background-color: black !important;
        }
        <?php
        foreach($establishment->homePictures()->get() as $i => $media){
            ?>
            .show-page section:nth-of-type(<?php echo $i+1;?>) .section-bg{
                background-image: url('<?php echo asset($media->getLocalPath());?>');
                background-color: black;
            }
            <?php
        }
        ?></style><?php
    }
    ?>
@endsection

@section('js_imports_footer')
<script src="/js/sidebar.js"></script>
<script src="/libraries/baguettebox/baguetteBox.min.js"></script>
<script src="/js/search.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection
