@extends('layouts.front') 

<!--Change here for changing the load delay variable for animation-->
@php
$loadDelay = 0.6
@endphp

<!--Git push again-->
@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
<link href="/css/sidebar.css" rel="stylesheet">
<link href="/libraries/baguettebox/baguetteBox.min.css" rel="stylesheet">
<!--Uses animation library from the first version beta-->
<link href="/libraries/wow/animate.css" rel="stylesheet">
@endsection

@if($establishment->getAcceptBooking())
@section('navbar-right')
    <li>
        <button type="button" class="btn book-button sidebar-booking-toggler" >Réservez une table</button>
    </li>
@endsection
@endif

@section('content')
    @if($establishment->getAcceptBooking())
    <aside id="sidebar-booking" class="custom-sidebar sidebar-fixed-right ref-scroller" data-toggler=".sidebar-booking-toggler">
           @component('establishment.restaurant.feed.booking', ['establishment' => $establishment, 'form_data' => $form_data])
           @endcomponent
    </aside>
    @endif
    <?php
    $establishementUrl = $establishment->getUrl();
    if(isset($preview) && $preview){
        $establishementUrl = $establishment->getPreviewUrl();
    }
    ?>
    <div class="content show-page custom-sidebar-content-wrapper">
        <div id="ets-nav-bookmarks">
            <div class="ets-nav-bookmark bookmark-voucher app-disabled hidden" title="Bon cadeau">
                <a href="{{ $establishementUrl }}#voucher" class="simple">
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
                <a href="{{ $establishementUrl }}#events" class="simple">
                    <!--<span class="bookmark-icon glyphicon glyphicon-calendar" aria-hidden="true"></span>-->
                    <img class="bookmark-icon" alt="events" src="/img/icons/ICONS-CALENDAR-EVENTS.svg"/>
                    <!--<img class="bookmark-icon" alt="events" src="/img/icons/ICONS-MAP-PROMOTIONS.svg"/>-->
                </a>
            </div>
            @endif
            <div class="ets-nav-bookmark bookmark-home" title="Le restaurant">
                <a href="{{ $establishementUrl }}" class="simple">
                    <span>Le restaurant</span>
                    <span class="bookmark-icon glyphicon glyphicon-home" aria-hidden="true"></span>
                </a>
            </div>
            <div class="ets-nav-bookmark bookmark-menu" title="Menus">
                <a href="{{ $establishementUrl }}menu" class="simple">
                    <span>Menus</span>
                    <span class="bookmark-icon glyphicon glyphicon-cutlery" aria-hidden="true"></span>
                </a>
            </div>
            <div class="ets-nav-bookmark bookmark-photos" title="Photos">
                <a href="{{ $establishementUrl }}photos" class="simple">
                    <span>Photos</span>
                    <span class="bookmark-icon glyphicon glyphicon-picture" aria-hidden="true"></span>
                </a>
            </div>
        </div>
        <!------------- RESTAURANT INTRO -------------------------------------->
        <section class="container-fluid ets-intro">
            <div class="section-bg"></div>
            @component('components.divcell', ['style' => 'height: 100%;'])
                @slot('content')
                    <h1 class="hdng__off2 wow fadeInLeft animated" data-wow-delay="{{$loadDelay}}s">{{ $establishment->getName() }}</h1>
                    <h2 class="hdng__off2 wow fadeInRight animated" data-wow-delay="{{$loadDelay}}s">@lang('Cuisine') {{ $data['cooking_type'] }}</h2>
                    @if(isset($data['specialties']))
                    <h3 class="hdng__off2 wow fadeInLeft animated" data-wow-delay="{{$loadDelay}}s">
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
                <h1 class="wow fadeInLeft" data-wow-delay="{{$loadDelay}}s"><strong>Nous</strong> contacter</h1>
                <div class="quick-map wow fadeInRight" data-wow-delay="{{$loadDelay}}s" data-lat="{{ $establishment->getLatitude() }}" data-lng="{{ $establishment->getLongitude() }}"></div>
                <div class="row ets-address wow fadeInLeft" data-wow-delay="{{$loadDelay}}s">
                    <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                    {{ $data['address'] }}
                </div>
                @if($establishment->getAcceptBooking())
                <div class="row">
                    <button type="button" class="wow fadeInLeft btn book-button sidebar-booking-toggler" data-wow-delay="{{$loadDelay}}s">Réservez une table</button>
                </div>
                @endif
                @if(isset($data['phone_number']))
                <div class="wow fadeInRight row contact-number" data-wow-delay="{{$loadDelay}}s">
                    <a href="tel:{{ $data['phone_number'] }}">
                        <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                        {{ $data['phone_number'] }}
                    </a>
                </div>
                @endif
                @if(isset($data['website']) && !empty($data['website']))
                <div class="wow fadeInLeft row contact-website" data-wow-delay="{{$loadDelay}}s">
                    <a href="{{ formatUrl($data['website']) }}" target="_blank">
                        <span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
                        Visiter le site web
                    </a>
                </div>
                @endif
            </div>
        </section>
    </div>

    <style>
        .show-page section{
            background-color: black !important;
        }
        <?php
        $nbSection = 7;
        $i = 0;
        $homePicturesQuery = $establishment->homePictures()->where('status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
        if($homePicturesQuery->exists()){
            foreach($homePicturesQuery->get() as $i => $media){
                ?>
                .show-page section:nth-of-type(<?php echo $i+1;?>) .section-bg{
                    background-image: url('<?php echo asset($media->getLocalPath());?>');
                    background-color: black;
                }
                <?php
            }
        }
        while($i < $nbSection){
            ?>
            .show-page section:nth-of-type(<?php echo $i+1;?>) .section-bg{
                background-image: url('/img/background_ds/DS-BG-<?php echo rand(1, 34);?>.jpg');
                background-color: black;
            }
            <?php
            $i++;
        }
        ?>
    </style>
@endsection

@section('js_imports_footer')
<script src="/js/sidebar.js"></script>
<script src="/libraries/baguettebox/baguetteBox.min.js"></script>
<script src="/js/search.js"></script>
<script src="/js/bookmarkslider.js"></script>
<script src="/libraries/wow/wow.js"></script>
<script>
new WOW().init();
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection
