<!------------- RESTAURANT MENUS -------------------------------------->
@if(checkFlow($data, ['menus']))
<section class="container-fluid ets-menus">
    <div class="section-bg"></div>
    <div class="container">
        <h1>Notre <strong>menu</strong></h1>
        <div class="row">
            @foreach($data['menus'] as $menu)
            <div class="col-xs-6 col-sm-4 thumbnail-item gallery-box">
                <div class="thumbnail-name">
                    {{ $menu['name'] }}
                </div>
                <a role="button" class="btn btn-md menu-button" href="{{ $menu['file'] }}" target="_blank">
                    Télécharger menu
                    <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                </a>
            </div>                    
            @endforeach
        </div>
    </div>
</section>
@endif
<!------------- RESTAURANT DISHES -------------------------------------->
@if(checkFlow($data, ['dishes']))
<section class="container-fluid ets-staff">
    <div class="section-bg"></div>
    <div class="container">
        <h1>Nos <strong>assiettes</strong></h1>
        <div class="row">
            @foreach($data['dishes'] as $dish)
            <div class="col-xs-6 col-sm-4 thumbnail-item">
                <div class="thumbnail-visual">
                    <img src="{{ $dish['picture'] }}" alt="{{ $dish['name'] }} picture"/>
                    <div class="thumbnail-badge">
                        <div class="thumbnail-badge-inner">
                            <span class="currency">{{ $dish['currency'] }}</span>
                            <span class="price">{{ $dish['price'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="thumbnail-name">
                    {{ $dish['name'] }}
                </div>
                <div class="thumbnail-description">
                    {{ $dish['description'] }}
                </div>
            </div>                    
            @endforeach
        </div>
    </div>
</section>
@endif
<!------------- RESTAURANT MENUS -------------------------------------->
@if(checkFlow($data, ['daily_menu']))
<section class="container-fluid ets-menus">
    <div class="section-bg"></div>
    <div class="container">
        <h1><strong>Menu</strong> du jour</h1>
        <div class="row">
            @foreach($data['daily_menu'] as $dailyMenu)
            <div class="col-xs-6 col-xs-offset-3 col-sm-4 col-sm-offset-4 thumbnail-item gallery-box">
                <a role="button" class="btn btn-md menu-button" href="{{ $dailyMenu['file'] }}" target="_blank">
                    Télécharger menu
                    <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                </a>
            </div>                    
            @endforeach
        </div>
    </div>
</section>
@endif