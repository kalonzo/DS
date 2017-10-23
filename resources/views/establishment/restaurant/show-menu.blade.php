@php
$loadDelay = 0.6
@endphp
<!------------- RESTAURANT MENUS -------------------------------------->
@if(checkFlow($data, ['menus']))
<section class="container-fluid ets-menus">
    <div class="section-bg"></div>
    <div class="container">
        <h1 class="wow fadeInLeft" data-wow-delay="{{$loadDelay}}s">Notre <strong>menu</strong></h1>
        <div class="row wow fadeInRight" data-wow-delay="{{$loadDelay}}s">
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
<section class="container-fluid ets-dishes">
    <div class="section-bg"></div>
    <div class="container">
        <h1 class="wow fadeInLeft" data-wow-delay="{{$loadDelay}}s">Nos <strong>assiettes</strong></h1>
        <div class="row wow fadeInRight" data-wow-delay="{{$loadDelay}}s">
            @foreach($data['dishes'] as $dish)
            <div class="col-xs-6 col-sm-4 thumbnail-item">
                <div class="thumbnail-visual">
                    <div class="thumbnail-picture" style="background-image: url('{{ asset($dish['picture']) }}');">
                        <img src="/img/square-pattern.png" alt="square pattern" class="square-pattern"/>
                    </div>
                    <div class="thumbnail-badge">
                        <div class="thumbnail-badge-inner">
                            <?php
                            $price = $dish['price'];
                            $splitter = ',';
                            $priceArray = explode(',', $dish['price']);
                            if(count($priceArray) === 1){
                                $priceArray = explode('.', $dish['price']);
                                $splitter = '.';
                            }
                            $priceLeft = $priceArray[0];
                            $priceRight = '';
                            if(isset($priceArray[1])){
                                $priceRight = $priceArray[1];
                            }
                            ?>
                            <div class="price">
                                <span class="currency">{{ $dish['currency'] }}</span>
                                <span class="priceLeft">{{ $priceLeft }}</span>
                                @if(!empty($priceRight))
                                    <span class="splitter">{{ $splitter }}</span>
                                    <span class="priceRight">{{ $priceRight }}</span>
                                @endif
                            </div>
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
        <h1 class="wow fadeInLeft" data-wow-delay="{{$loadDelay}}s"><strong>Menu</strong> du jour</h1>
        <div class="row wow fadeInRight" data-wow-delay="{{$loadDelay}}s">
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