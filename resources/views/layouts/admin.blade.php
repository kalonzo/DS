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
        <link href="/css/dashboard.css" rel="stylesheet">
        <link href="/css/admin.css" rel="stylesheet">
        
        <link href="/libraries/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
        
        <!-- ============================================
        ================= Stylesheets ===================
        ============================================= -->
        <!-- vendor css files -->
        <link rel="stylesheet" href="/dashboard-innovate/css/vendor/animate.css">
        <link rel="stylesheet" href="/dashboard-innovate/css/vendor/font-awesome.min.css">
        <!--<link rel="stylesheet" href="/dashboard-innovate/js/vendor/animsition/css/animsition.min.css">-->
        <link rel="stylesheet" href="/dashboard-innovate/js/vendor/daterangepicker/daterangepicker-bs3.css">
<!--        <link rel="stylesheet" href="/dashboard-innovate/js/vendor/morris/morris.css">
        <link rel="stylesheet" href="/dashboard-innovate/js/vendor/owl-carousel/owl.carousel.css">
        <link rel="stylesheet" href="/dashboard-innovate/js/vendor/owl-carousel/owl.theme.css">
        <link rel="stylesheet" href="/dashboard-innovate/js/vendor/rickshaw/rickshaw.min.css">-->
        <link rel="stylesheet" href="/dashboard-innovate/js/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css">
<!--        <link rel="stylesheet" href="/dashboard-innovate/js/vendor/datatables/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="/dashboard-innovate/js/vendor/datatables/datatables.bootstrap.min.css">
        <link rel="stylesheet" href="/assets/js/vendor/datatables/datatables.bootstrap.min.css">
        <link rel="stylesheet" href="/assets/js/vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css">
        <link rel="stylesheet" href="/assets/js/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css">
        <link rel="stylesheet" href="/assets/js/vendor/datatables/extensions/ColVis/css/dataTables.colVis.min.css">
        <link rel="stylesheet" href="/assets/js/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css">-->
<!--        <link rel="stylesheet" href="/dashboard-innovate/js/vendor/chosen/chosen.css">
        <link rel="stylesheet" href="/dashboard-innovate/js/vendor/summernote/summernote.css">-->

        <!-- project main css files -->
        <link rel="stylesheet" href="/dashboard-innovate/css/main.css">
        <!--/ stylesheets -->
        
        <!-- ==========================================
        ================= Modernizr ===================
        =========================================== -->
        <!--<script src="/dashboard-innovate/js/vendor/modernizr/modernizr-2.8.3-respond-1.4.2.min.js"></script>-->
        <!--/ modernizr -->
        @show
        
        @yield('css_imports')
        
        <script src="/js/kernelFunctions.js"></script>
        @yield('js_imports_head')
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" id="navbar">
            <div class="container-fluid">
                <div class="navbar-collapse collapse">
                    <!--
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
                    -->
                    <a class="navbar-brand" href="/">
                        <img alt="dinerscope" src="/img/LOGO-DINERSCOPE.svg"/>
                    </a>
                    <ul class="nav navbar-nav navbar-right">
                        <li id="promotionButton" class="app-disabled hidden">
                            <a href="#">
                                <img alt="user" src="/img/icons/ICONS-MAP-PROMOTIONS.svg"/>
                                <span class="badge">42</span>
                            </a>
                        </li>
                        <li id="eventButton" class="app-disabled hidden">
                            <a href="#">
                                <img alt="user" src="/img/icons/ICONS-CALENDAR-EVENTS.svg"/>
                                <span class="badge">8</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img alt="user" src="/img/icons/ICONS-MENU-USER.svg"/>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dLabel" id="login-dropdown">
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
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar" id="sidebar-left">
                    @yield('sidebar')
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    @yield('content')
                </div>
            </div>
        </div>
            
        <footer class="footer">
            
        </footer>
        
        @component('components.ajax-modal')
        @endcomponent
        
        <script src="/js/app.js"></script>
        <script src="/js/extendMethods.js"></script>
        <script src="/js/functions.js"></script>
        <script src="/js/plugins.js"></script>    
        <script src="/js/form-validation.js"></script>
        
        <script src="/js/datatables.js"></script>
        
        <script src="/libraries/bootstrap-fileinput/js/plugins/sortable.min.js"></script>
        <script src="/libraries/bootstrap-fileinput/js/fileinput.js"></script>
        
        <!-- ============================================
        ============== Vendor JavaScripts ===============
        ============================================= -->
        <script src="/dashboard-innovate/js/vendor/jRespond/jRespond.min.js"></script>

<!--        <script src="/dashboard-innovate/js/vendor/d3/d3.min.js"></script>
        <script src="/dashboard-innovate/js/vendor/d3/d3.layout.min.js"></script>-->

        <!--<script src="/dashboard-innovate/js/vendor/rickshaw/rickshaw.min.js"></script>-->

        <!--<script src="/dashboard-innovate/js/vendor/sparkline/jquery.sparkline.min.js"></script>-->

        <!--<script src="/dashboard-innovate/js/vendor/slimscroll/jquery.slimscroll.min.js"></script>-->

        <script src="/dashboard-innovate/js/vendor/daterangepicker/moment.min.js"></script>
        <script src="/dashboard-innovate/js/vendor/daterangepicker/daterangepicker.js"></script>

        <script src="/dashboard-innovate/js/vendor/screenfull/screenfull.min.js"></script>

<!--        <script src="/dashboard-innovate/js/vendor/flot/jquery.flot.min.js"></script>
        <script src="/dashboard-innovate/js/vendor/flot-tooltip/jquery.flot.tooltip.min.js"></script>
        <script src="/dashboard-innovate/js/vendor/flot-spline/jquery.flot.spline.min.js"></script>-->

        <!--<script src="/dashboard-innovate/js/vendor/easypiechart/jquery.easypiechart.min.js"></script>-->

<!--        <script src="/dashboard-innovate/js/vendor/raphael/raphael-min.js"></script>
        <script src="/dashboard-innovate/js/vendor/morris/morris.min.js"></script>-->

        <!--<script src="/dashboard-innovate/js/vendor/owl-carousel/owl.carousel.min.js"></script>-->

        <script src="/dashboard-innovate/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!--        <script src="/dashboard-innovate/js/vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="/dashboard-innovate/js/vendor/datatables/extensions/dataTables.bootstrap.js"></script>
        <script src="/assets/js/vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="/assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
        <script src="/assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
        <script src="/assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
        <script src="/assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js"></script>-->
        
        <!--<script src="/dashboard-innovate/js/vendor/chosen/chosen.jquery.min.js"></script>-->

        <!--<script src="/dashboard-innovate/js/vendor/summernote/summernote.min.js"></script>-->

<!--        <script src="/dashboard-innovate/js/vendor/coolclock/coolclock.js"></script>
        <script src="/dashboard-innovate/js/vendor/coolclock/excanvas.js"></script>-->
        <!--/ vendor javascripts -->

        <!-- ============================================
        ============== Custom JavaScripts ===============
        ============================================= -->
        <script src="/dashboard-innovate/js/main.js"></script>
        <!--/ custom javascripts -->
        
        @yield('js_imports_footer')
        <script src="/js/js-loaded-trigger.js"></script>    
    </body>
</html>
@endif
