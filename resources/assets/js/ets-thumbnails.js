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
        
$(document).on('ajaxSuccess', function(){
    resizeEtsThumbnailCornerLogos();
});
resizeEtsThumbnailCornerLogos();

flexEtsThumbnailUnderLayer = function(etsThumbnail){
    var $underLayer = $(etsThumbnail).find('.thumbnail-under-layer');
    var $etsLabel = $underLayer.find('.thumbnail-label');
    var $etsExtraText = $underLayer.find('.thumbnail-text-extra');

    var memShrink = $etsLabel.css('flex-shrink');
    $etsLabel.css('flexShrink', 0);
    var etsLabelRefHeight = $etsLabel.height();
    $etsLabel.css('flexShrink', memShrink);
        
    if(etsLabelRefHeight > $etsLabel.height()){
        $etsExtraText.find('.thumbnail-full-address').hide();
    } else {
        $etsExtraText.find('.thumbnail-full-address').show();
    }
}

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
            $('body').find('.ets-thumbnail.thumbnail-revealed').find('.thumbnail-logo-corner').click();
            flexEtsThumbnailUnderLayer($thumbnail);
            
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