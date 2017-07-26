@extends('layouts.front')

@section('js_imports_head')
@endsection

@section('content')
<div class="content">
    <div id="homeAdvertCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($slider_ets as $establishment)
            <li data-target="#homeAdvertCarousel" data-slide-to="{{ $loop->index }}" class="@if( $loop->iteration == 1) active @endif"></li>
            @endforeach
        </ol>
        <div class="carousel-inner" role="listbox">
            @foreach($slider_ets as $establishment)
            <div class="item @if( $loop->iteration == 1) active @endif"> 
                <img class="" src="{{ $establishment->getDefaultPicture() }}" alt="{{ $establishment->getName() }}" />
                <div class="carousel-caption d-none d-md-block">
                    <img src="{{ $establishment->getDefaultPicture() }}" alt="Logo establishment"/>
                    <h3>{{ $establishment->getName() }} | </h3>
                    <p>Type ETS</p>
                </div>
            </div>
            @endforeach
        </div>
        <a class="left carousel-control" href="#homeAdvertCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Précédent</span>
        </a>
        <a class="right carousel-control" href="#homeAdvertCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Suivant</span>
        </a>
    </div>
    
    <div class="container-fluid" id="home-highlight-sections">
        <!-- DINERSCOPE SELECTION ------------------------------------------------->
        <div class="home-highlight-section">
            <div class="container">
                <div class="home-highlight-header">
                    <h2>La sélection du <strong>DinerScope</strong></h2>
                    <div class="carousel-control-container">
                        <a class="carousel-control left" href="#dsSelectionCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Précédent</span>
                        </a>
                        <a class="carousel-control right" href="#dsSelectionCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Suivant</span>
                        </a>
                    </div>
                </div>
                <div id="dsSelectionCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner" role="listbox">
                        @foreach($ds_selection as $establishment)
                            @if( $loop->index % 4 == 0)
                            <div class="item @if( $loop->iteration == 1) active @endif">
                            @endif

                                @component('components.establishment_thumbnail', ['establishment' => $establishment])

                                @endcomponent

                            @if( $loop->iteration / 4 == 1 OR $loop->last)
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- BEST PROMOS ---------------------------------------------------------->
        <div class="home-highlight-section">
            <div class="container">
                <div class="home-highlight-header">
                    <h2>Les <strong class="text-highlight">meilleures</strong> promotions</h2>
                    <div class="carousel-control-container">
                        <a class="carousel-control left" href="#bestPromoCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Précédent</span>
                        </a>
                        <a class="carousel-control right" href="#bestPromoCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Suivant</span>
                        </a>
                    </div>
                </div>
                <div id="bestPromoCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner" role="listbox">
                        @foreach($ds_selection as $establishment)
                            @if( $loop->index % 4 == 0)
                            <div class="item @if( $loop->iteration == 1) active @endif">
                            @endif

                                @component('components.establishment_thumbnail', ['establishment' => $establishment])

                                @endcomponent

                            @if( $loop->iteration / 4 == 1 OR $loop->last)
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (Route::has('login'))
<div class="container-fluid">
    <div class="main row">
        <div class="col-xs-12">
            <div class="top-right links">
                @if (Auth::check())
                <a href="{{ url('/admin') }}">Home</a>
                @else
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('js_imports_footer')
<script src="/js/search.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection