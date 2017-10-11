@if(!isset($reloaded) || !$reloaded)
@extends('layouts.front')

@section('js_imports_head')
@endsection
@section('content')
<div class="content mainPageReloadContainer">
@endif
    <div id="homeAdvertCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($slider_ets as $establishment)
            <li data-target="#homeAdvertCarousel" data-slide-to="{{ $loop->index }}" class="@if( $loop->iteration == 1) active @endif"></li>
            @endforeach
        </ol>
        <div class="carousel-inner" role="listbox">
            @foreach($slider_ets as $establishment)
            <a class="item @if( $loop->iteration == 1) active @endif" style="background-image: url('{{ $establishment->getDefaultBanner() }}');"
               href="{{ $establishment->getUrl() }}"> 
                <div class="carousel-caption d-none d-md-block">
                    <div class="carousel-caption-picture" style="background-image: url('{{ $establishment->getDefaultPicture() }}');">
                        <img src="/img/square-pattern.png" alt="square pattern" class="square-pattern"/>
                    </div>
                    <h3>{{ $establishment->getName() }} | </h3>
                    <p>{{ $establishment->cooking_type }}</p>
                </div>
            </a>
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
                            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                            <span class="sr-only">Précédent</span>
                        </a>
                        <a class="carousel-control right" href="#dsSelectionCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                            <span class="sr-only">Suivant</span>
                        </a>
                    </div>
                </div>
                <div id="dsSelectionCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner" role="listbox">
                        @foreach($ds_selection as $establishment)
                            @if( $loop->index % 6 == 0)
                            <div class="item @if( $loop->iteration == 1) active @endif">
                            @endif

                                @component('components.establishment_thumbnail', ['establishment' => $establishment])

                                @endcomponent

                            @if( $loop->iteration % 6 == 0 OR $loop->last)
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- BEST PROMOS ---------------------------------------------------------->
        @if(!empty($promotions))
        <div class="home-highlight-section">
            <div class="container">
                <div class="home-highlight-header">
                    <h2>Les <strong class="text-promo">meilleures</strong> promotions</h2>
                    <div class="carousel-control-container">
                        <a class="carousel-control left" href="#bestPromoCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                            <span class="sr-only">Précédent</span>
                        </a>
                        <a class="carousel-control right" href="#bestPromoCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                            <span class="sr-only">Suivant</span>
                        </a>
                    </div>
                </div>
                <div id="bestPromoCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner" role="listbox">
                        @foreach($promotions as $establishment)
                            @if( $loop->index % 6 == 0)
                            <div class="item @if( $loop->iteration == 1) active @endif">
                            @endif

                            @component('components.establishment_thumbnail', ['establishment' => $establishment])

                            @endcomponent

                            @if( $loop->iteration % 6 == 0 OR $loop->last)
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- MOST VISITED ---------------------------------------------------------->
        <div class="home-highlight-section">
            <div class="container">
                <div class="home-highlight-header">
                    <h2>Les <strong>plus visités</strong> cette semaine</h2>
                    <div class="carousel-control-container">
                        <a class="carousel-control left" href="#mostVisitedCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                            <span class="sr-only">Précédent</span>
                        </a>
                        <a class="carousel-control right" href="#mostVisitedCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                            <span class="sr-only">Suivant</span>
                        </a>
                    </div>
                </div>
                <div id="mostVisitedCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner" role="listbox">
                        @foreach($most_visited as $establishment)
                            @if( $loop->index % 6 == 0)
                            <div class="item @if( $loop->iteration == 1) active @endif">
                            @endif

                            @component('components.establishment_thumbnail', ['establishment' => $establishment])

                            @endcomponent

                            @if( $loop->iteration % 6 == 0 OR $loop->last)
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@if(!isset($reloaded) || !$reloaded)
</div>

@endsection

@section('js_imports_footer')
<script src="/js/search.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection
@endif