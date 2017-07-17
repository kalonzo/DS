<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dinerscope</title>

        @yield('css_imports')
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/sticky-footer.css" rel="stylesheet">
        <link href="/css/front.css" rel="stylesheet">
        @show
        
        @yield('js_imports_head')
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div id="navbar" class="navbar-collapse collapse">
                    <form class="navbar-form navbar-left">
                        <input type="text" class="form-control" placeholder="Tapez vos envies..." id="search_keywords">
                        <div class="input-group locationInputGroup">
                            <span class="input-group-addon clickable" onclick="geolocateMe();">
                                <span class="geolocMeIcon glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                            </span>
                            <input type="text" class="form-control" placeholder="Ville, adresse, NPA" id="search_location">
                        </div>
                    </form>
                    <div class="navbar-left">
                        
                    </div>
                    <a class="navbar-brand navbar-left" href="/">
                        <img alt="dinerscope" src="/img/LOGO-DINERSCOPE.svg"/>
                    </a>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#">
                                <img alt="user" src="/img/ICONS-MENU-USER.svg"/>
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
        <div class="container-fluid">
            @yield('content')
        </div>
        
        <footer class="footer">
            <div class="container text-center">
                <p class="">DinerScope by TREND-ON-LINE, Avenue du Mont-Blanc 38, 1196 Gland, Suisse</p>
            </div>
        </footer>
        
        <script src="/js/app.js"></script>
        <script src="/js/functions.js"></script>
        @yield('js_imports_footer')
    </body>
</html>
