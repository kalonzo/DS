@if(!isset($reloaded) || !$reloaded)
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dinerscope</title>

        <!-- Fonts -->
        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/sticky-footer.css" rel="stylesheet">
        <link href="/css/front.css" rel="stylesheet">
        @show
        @yield('css_imports')
        
        <script src="/js/kernelFunctions.js"></script>
        @yield('js_imports_head')
    </head>
    <body @if(isset($footerHidden) && $footerHidden) data-footer='hidden' @endif>
        <nav class="navbar navbar-inverse navbar-fixed-top" id="navbar">
            <div class="container-fluid">
                <div class="navbar-collapse collapse">
                    @if(!isset($disableQuickSearch) || !$disableQuickSearch)
                    {!! Form::open(['id'=>'quick-search-form', 'url'=>'/search', 'method' => 'post', 'class' => 'navbar-form navbar-left']) !!}
                        {!! Form::hidden('reset', '1'); !!}
                        <div class="input-group locationInputGroup group-quick-search">
                            <span class="input-group-addon clickable" onclick="$(this).parentsInclude('form').submit();" title="Cliquez ici pour rechercher autour de vous">
                                <span class="geolocMeIcon glyphicon glyphicon-search" aria-hidden="true"></span>
                            </span>
                            <input type="text" name="term" class="form-control" placeholder="Nom, type de cuisine" id="search_keywords">
                        </div>
                        <div class="input-group locationInputGroup group-location-search">
                            <span class="input-group-addon clickable" onclick="geolocateMe();" title="Cliquer ici pour me géolocaliser">
                                <span class="geolocMeIcon glyphicon glyphicon-screenshot" aria-hidden="true"></span>
                            </span>
                            <input type="text" class="form-control" data-toggle="popover" placeholder="Ville, adresse, NPA" id="search_location">
                        </div>
                    {!! form::close() !!}
                    @endif
                    <a class="navbar-brand" href="/">
                        <img alt="dinerscope" src="/img/LOGO-DINERSCOPE.svg"/>
                    </a>
                    <ul class="nav navbar-nav navbar-right">
                        @yield('navbar-right')
                        <?php
                        $eventController = Illuminate\Support\Facades\App::make(App\Http\Controllers\EventController::class);
                        $promosList = $eventController::getPromotionsDropdownFeed();
                        $eventsList = $eventController::getEventsDropdownFeed();
                        ?>
                        @component('components.navbar-dropdown', [
                                                                    'containerId' => 'promotionButton',
                                                                    'buttonImageSrc' => asset("/img/icons/ICONS-MAP-PROMOTIONS.svg"),
                                                                    'buttonImageAlt' => 'Promos',
                                                                    'dropdownTitle' => 'Promotions',
                                                                    'eventsList' => $promosList
                                                                    ])

                        @endcomponent
                        @component('components.navbar-dropdown', [
                                                                    'containerId' => 'eventButton',
                                                                    'buttonImageSrc' => asset("/img/icons/ICONS-CALENDAR-EVENTS.svg"),
                                                                    'buttonImageAlt' => 'Evénements',
                                                                    'dropdownTitle' => 'Evénements',
                                                                    'eventsList' => $eventsList
                                                                    ])

                        @endcomponent

                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img alt="user" src="/img/icons/ICONS-MENU-USER.svg"/>
                            </a>
                            <div class="dropdown-menu @if(!Auth::check()) login @else logout @endif" aria-labelledby="dLabel" id="login-dropdown">
                                @component('components.login')

                                @endcomponent
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="navbar-header">
                    <!-- MOBILE MENU -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
            </div>
        </nav>
           
        @component('components.page-feedback-alert')

        @endcomponent
        
        @yield('content')
                
        @if(!isset($footerHidden) || !$footerHidden)
        <div class="pre-footer">
            <div class="container">
                <div class="col col-sm-4">
                    <h2>A propos de nous</h2>
                    <ul>
                        <li><a href="#">Qui sommes-nous?</a></li>
                        <li><a href="#">Programme DinersScope</a></li>
                        <li><a href="#">Plan du site</a></li>
                    </ul>
                </div>
                <div class="col col-sm-4">
                    <h2>Besoin d'aide ?</h2>
                    <ul>
                        <li><a href="#">Contactez-nous</a></li>
                        <!--<li><a href="#">Questions fréquentes</a></li>-->
                        <li><a href="#">CGU et Mentions légales</a></li>
                    </ul>
                </div>
                <div class="col col-sm-4 socialNetworks">
                    <h2>Suivez-nous</h2>
                    <ul>
                        <li><a href="#"><img alt="facebook" src="/img/icons/Facebook.svg"/></a></li>
                        <li><a href="#"><img alt="twitter" src="/img/icons/Twitter.svg"/></a></li>
                        <li><a href="#"><img alt="instagram" src="/img/icons/Instagram.svg"/></a></li>
                        <li><a href="#"><img alt="skype" src="/img/icons/Skype.svg"/></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container text-center">
                <p class="">
                    DinerScope by TREND-ON-LINE, Avenue du Mont-Blanc 38, 1196 Gland, Suisse - Tél. +41 (0)22 362 34 78 - 
                    <a href="mailto:customercare@dinerscope.com">customercare@dinerscope.com</a>
                    <br/>
                    Dinerscope © {{ date('Y') }}
                </p>
            </div>
        </footer>
        @endif
        
        @component('components.ajax-modal')
        @endcomponent
        
        @if(!envDev())
        <!-- Google Analytics -->
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-108506955-1', 'auto');
        ga('send', 'pageview');
        </script>
        <!-- End Google Analytics -->
        @endif
        
        <script src="/js/app.js"></script>
        <script src="/js/extendMethods.js"></script>
        <script src="/js/functions.js"></script>
        <script src="/js/plugins.js"></script>    
        <script src="/js/geolocation.js"></script>    
        <script src="/js/form-validation.js"></script>
        @yield('js_imports_footer')
        <script src="/js/js-loaded-trigger.js"></script>    
    </body>
</html>
@endif
