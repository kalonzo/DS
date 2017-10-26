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
                    <!--
                    <div class="carousel-caption-picture" style="background-image: url('{{ $establishment->getDefaultPicture() }}');">
                        <img src="/img/square-pattern.png" alt="square pattern" class="square-pattern"/>
                    </div>
                    -->
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
<script type="text/javascript">
    resizeEtsThumbnailCornerLogos = function(){
        var etsThumbnailRef = $('.ets-thumbnail:visible').first();
        if(checkExist(etsThumbnailRef)){
            $('.ets-thumbnail:not(.cornerLogoProcessed)').each(function(){
                $(this).addClass('cornerLogoProcessed');
                var size = $(etsThumbnailRef).width();
                $('.thumbnail-logo').width(size);
                $('.thumbnail-logo').height(size);
            });
        }
    }
    document.addEventListener("DOMContentLoaded", function(event) { 
        
        $(document).on('ajaxSuccess', function(){
            resizeEtsThumbnailCornerLogos();
        });
        resizeEtsThumbnailCornerLogos();
        
        $('body').on('mouseover', '.ets-thumbnail:not(.thumbnail-anim-reveal):not(.thumbnail-anim-back):not(.thumbnail-revealed)', function(e){
            var $thumbnail = $(this);
            var $cornerContainer = $thumbnail.find('.thumbnail-logo-corner');
            var $cornerShadow = $thumbnail.find('.thumbnail-logo-corner-shadow');
            
            var delay = 200; 
            $cornerContainer.stop()
                        .animate({
                            top: 0,
                            left: 0,
                        }, delay, 'linear');
            $cornerShadow.stop()
                        .animate({
                            top: 50,
                            left: 0,
                        }, delay, 'linear', function(){
                            $thumbnail.addClass('thumbnail-corner-revealed');
                        });
        });
        
        $('body').on('mouseout', '.ets-thumbnail:not(.thumbnail-anim-reveal):not(.thumbnail-anim-back):not(.thumbnail-revealed)', function(e){
            var $thumbnail = $(this);
            var $cornerContainer = $thumbnail.find('.thumbnail-logo-corner');
            var $cornerShadow = $thumbnail.find('.thumbnail-logo-corner-shadow');
            
            $thumbnail.removeClass('thumbnail-corner-revealed');
            var delay = 300; 
            $cornerContainer.stop()
                        .animate({
                            top: -50,
                            left: -50,
                        }, delay, 'linear');
            $cornerShadow.stop()
                        .animate({
                            top: 0,
                            left: -50,
                        }, delay, 'linear');
        });
        
        $('body').on('click', '.thumbnail-logo-corner', function(e){
            e.stopPropagation();
            e.preventDefault();
            var $cornerContainer = $(this);
            var $thumbnail = $cornerContainer.parentsInclude('.ets-thumbnail');
            
            if($thumbnail.hasClass('thumbnail-corner-revealed')){
                var $thumbnailTopLayer = $thumbnail.find('.thumbnail-top-layer');
                var $thumbnailTop = $thumbnail.find('.thumbnail-top');
                var $cornerLogo = $cornerContainer.find('.thumbnail-logo');
                var $thumbnailTopLayerImage = $thumbnailTopLayer.find('.thumbnail-image');
                var $corner = $cornerContainer.find('.thumbnail-corner');
                var $cornerShadow = $thumbnail.find('.thumbnail-logo-corner-shadow');

                var thumbnailHeight = $thumbnail.height();
                var thumbnailWidth = $thumbnail.width();
                var cornerWidth = $cornerContainer.width();

                if(!$thumbnail.hasClass('thumbnail-revealed')){

                    setTimeout(function(){
                        // Hide corner logo so that bottom layer take the lead
                        $cornerLogo.hide();
                    }, 200);

                    // Trigger the clip path animation on the top layer, so that it disappears from top left corner
                    $thumbnail.addClass('thumbnail-anim-reveal');

                    // Make the corner growing up until it takes a square space
                    $corner.stop().animate({
                            borderBottomWidth: thumbnailWidth+'px',
                            borderLeftWidth: thumbnailWidth+'px',
                        }, 400, 'linear', function(){
                            // Move the corner container to the bottom of the thumbnail
                            $cornerContainer.animate({
                                    top: (thumbnailHeight - cornerWidth)
                                }, 600, 'linear');
                            // Move the top layer content to the right bottom so that it disappears
                            $thumbnailTopLayer.stop()
                                .animate({
                                    top: thumbnailHeight,
                                    left: thumbnailWidth,
                                }, 800, 'linear', function(){
                                    // Final call of the animation
                                    $thumbnail.addClass('thumbnail-revealed');
                                    
                                    var newTooltip = $cornerContainer.attr('data-title-toggle');
                                    $cornerContainer.attr('data-title-toggle', $cornerContainer.attr('title'));
                                    $cornerContainer.attr('title', newTooltip);
                                });
                    });

                    // Move the corner shadow so that if follows the corner translation until the square space
                    $cornerShadow.stop().animate({
                            borderTopWidth: thumbnailWidth +'px',
                            borderRightWidth: thumbnailWidth +'px',
                            top: thumbnailWidth,
                        }, 400, 'linear', function(){
                            // Move the corner shadow through the bottom part so that it disappears completely
                            $cornerShadow.animate({
                                    borderTopWidth: (thumbnailWidth + 100) +'px',
                                    borderRightWidth: (thumbnailWidth + 100) +'px',
                                    top: thumbnailHeight,
                                }, 280, 'linear');
                        }
                    );

                    // Resize corner container to allow corner to grow up
                    $cornerContainer.stop()
                        .animate({
                            width: thumbnailWidth+'px',
                            height: thumbnailWidth+'px',
                        }, 400, 'linear', function(){
                            $cornerContainer.width(thumbnailWidth);
                            $cornerContainer.height('100%');
                        });
                } else {
                    // Trigger the clip path animation on the top layer, so that it disappears from top left corner
                    $thumbnail.addClass('thumbnail-anim-back');
                    $thumbnail.removeClass('thumbnail-revealed');
                    
                    $thumbnailTopLayer.stop()
                        .animate({
                            top: 0,
                            left: 0,
                        }, 800, 'linear', function(){
                            $corner.stop().animate({
                                borderBottomWidth: '50px',
                                borderLeftWidth: '50px',
                            }, 400, 'linear');
                            
                            $cornerContainer
                                .animate({
                                    width: '50px',
                                    height: '50px',
                                }, 400, 'linear', function(){
                                    $thumbnail.removeClass('thumbnail-corner-revealed')
                                    $cornerContainer.animate({
                                        top: -50,
                                        left: -50
                                    }, 200, 'linear', function(){
                                        // Final call of the animation
                                        $thumbnail.removeClass('thumbnail-anim-back');
                                        
                                        var newTooltip = $cornerContainer.attr('data-title-toggle');
                                        $cornerContainer.attr('data-title-toggle', $cornerContainer.attr('title'));
                                        $cornerContainer.attr('title', newTooltip);
                                    });
                                });
                            
                            setTimeout(function(){
                                $thumbnail.removeClass('thumbnail-anim-reveal');
                            }, 50);
                        });
                        
                    setTimeout(function(){
                        $cornerContainer.animate({
                                    top: 0,
                                    left: 0
                                }, 600, 'linear');
                    }, 200);
                       
                    $cornerShadow.hide();
                        
                    setTimeout(function(){
                        // Show corner logo back
                        $cornerLogo.show();
                    }, 1200);
                }
            }
        });
    });
</script>
@if(!isset($reloaded) || !$reloaded)
</div>

@endsection

@section('js_imports_footer')
<script src="/js/search.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection
@endif