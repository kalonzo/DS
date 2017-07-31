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
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/sticky-footer.css" rel="stylesheet">
        <link href="/css/front.css" rel="stylesheet">
        @show
        
        @yield('css_imports')
        
        @yield('js_imports_head')
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" id="navbar">
            <div class="container-fluid">
                <div class="navbar-collapse collapse">
                    <form class="navbar-form navbar-left">
                        <div class="input-group locationInputGroup">
                            <span class="input-group-addon clickable" onclick="document.location.href='/search'" title="Cliquer ici pour rechercher autour de moi">
                                <span class="geolocMeIcon glyphicon glyphicon-search" aria-hidden="true"></span>
                            </span>
                            <input type="text" class="form-control" placeholder="Nom, type de cuisine" id="search_keywords">
                        </div>
                        <div class="input-group locationInputGroup">
                            <span class="input-group-addon clickable" onclick="geolocateMe();" title="Cliquer ici pour me géolocaliser">
                                <span class="geolocMeIcon glyphicon glyphicon-screenshot" aria-hidden="true"></span>
                            </span>
                            <input type="text" class="form-control" placeholder="Ville, adresse, NPA" id="search_location">
                        </div>
                    </form>
                    <a class="navbar-brand" href="/">
                        <img alt="dinerscope" src="/img/LOGO-DINERSCOPE.svg"/>
                    </a>
                    <ul class="nav navbar-nav navbar-right">
                        <li id="promotionButton">
                            <a href="#">
                                <img alt="user" src="/img/icons/ICONS-MAP-PROMOTIONS.svg"/>
                                <span class="badge">42</span>
                            </a>
                        </li>
                        <li id="eventButton">
                            <a href="#">
                                <img alt="user" src="/img/icons/ICONS-CALENDAR-EVENTS.svg"/>
                                <span class="badge">8</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img alt="user" src="/img/icons/ICONS-MENU-USER.svg"/>
                            </a>
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
        
        @yield('content')
                
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
                        <li><a href="#">Questions fréquentes</a></li>
                        <li><a href="#">CGU et Mentions légales</a></li>
                    </ul>
                </div>
                <div class="col col-sm-4 socialNetworks">
                    <h2>Suivez-nous</h2>
                    <ul>
                        <li><a href="#"><img alt="facebook" src="/img/icons/ICONS-CALENDAR-EVENTS.svg"/></a></li>
                        <li><a href="#"><img alt="twitter" src="/img/icons/ICONS-CALENDAR-EVENTS.svg"/></a></li>
                        <li><a href="#"><img alt="instagram" src="/img/icons/ICONS-CALENDAR-EVENTS.svg"/></a></li>
                        <li><a href="#"><img alt="skype" src="/img/icons/ICONS-CALENDAR-EVENTS.svg"/></a></li>
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
        
        <script src="/js/app.js"></script>
        <script src="/js/kernelFunctions.js"></script>
        <script src="/js/extendMethods.js"></script>
        <script src="/js/functions.js"></script>
        <script src="/js/geolocation.js"></script>
        @yield('js_imports_footer')
    </body>
</html>
@endif
