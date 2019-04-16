$('body').on('click valid-form', '.form-data-button', function () {
    var form = $(this).parentsInclude('form');
    var $button = $(this);
    var $alert = $(form).find('#form-ajax-alert');
    if (checkExist(form)) {
        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            data: new FormData(form[0]),
//            data: $(form).serialize(),
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                $alert.hide();
                if(data.triggerMode){
                    $(form).trigger('ajaxFormSubmitted', data);
                } else if(data.relocateMode && !isEmpty(data.location)){
                    window.location = data.location;
                } else {
                    location.reload();
                }
            },
            error: function (data) {
                $(form).trigger('ajaxFormFailed', data);
                var errors = data.responseJSON;

                $(form).find('.has-error [data-toggle=tooltip]').tooltip('destroy');
                $(form).find('.has-error').removeClass('has-error');
                var first = true;
                var scrollRefIsBody = false;
                var $scrollRefElement = $(form).parentsInclude('.ref-scroller');
                if (!checkExist($scrollRefElement)) {
                    $scrollRefElement = $('body');
                    scrollRefIsBody = true;
                }
                $.each(errors, function (key, value) {
                    var inputName = key;
                    if(key.indexOf('.') !== -1){
                        var inputNameArray = key.split('.');
                        inputName = inputNameArray[0];
                        for(var i=1; i < inputNameArray.length; i++){
                            inputName  += '[' + inputNameArray[i] + ']';
                        }
                    }
                    var $input = $(form).find('[name="' + inputName + '"]:not([type=hidden])').first();
                    var $positionElementRef = $input;
                    var inputHidden = $input.css('display') == 'none' || $input.attr('type') == 'hidden';
                    if(inputHidden){
                        while($positionElementRef === null || $positionElementRef.css('display') == 'none' || $positionElementRef.attr('type') == 'hidden'){
                            $positionElementRef = $positionElementRef.parent();
                        }
                    }
                    if (checkExist($input)) {
                        if (first) {
                            first = false;
                            if (checkExist($scrollRefElement)) {
                                // Check if element is into a closed accordion
                                var $accordionPanel = $input.parentsInclude('.panel-collapse:not(.in)');
                                if(checkExist($accordionPanel)){
                                    $accordionPanel.collapse('show');
                                }
                                var inputTopOffset = $positionElementRef.offset().top;
                                var inputTopPosition = $positionElementRef.position().top;
                                var inputHeight = $positionElementRef.outerHeight();
                                var refScrollTopPosition = $scrollRefElement.position().top;
//                                var refScrollClientHeight = $scrollRefElement.get(0).clientHeight;
//                                var refScrollHeight = $scrollRefElement.height();
                                var refScrollScrolled = 0;
                                if(!scrollRefIsBody){
                                    refScrollScrolled = $scrollRefElement.scrollTop();
                                    var targetTopPosition = (refScrollScrolled - inputTopPosition - refScrollTopPosition) - (inputHeight);
                                } else {
                                    var targetTopPosition = (inputTopOffset - refScrollTopPosition) - (inputHeight + 100);
                                }
                                $($scrollRefElement).animate({
                                    scrollTop: targetTopPosition
                                }, 500);
                            }
                        }
                        var $formGroup = $input.parentsInclude('.form-group');
                        $formGroup.addClass('has-error');
                        var tooltipTitle = value;
                        if(typeof value === 'object'){
                            tooltipTitle = value.join(', ');
                        }
                        $positionElementRef.tooltip({
                            title: tooltipTitle,
                            trigger: 'manual',
                            html: true,
                            template: '<div class="tooltip form-error-tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                        }).tooltip('show');
                        $input.change(function () {
                            $positionElementRef.tooltip('destroy');
                            $formGroup.removeClass('has-error');
                        });
                    }
                });
                if(typeof errors != 'undefined' && typeof errors.error != 'undefined'){
                    if(!checkExist($alert)){
                        $alert = $('<div id="form-ajax-alert" class="alert alert-danger alert-dismissible" role="alert">\n\
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n\
                                            <span class="alert-message">Attention!</span>\n\
                                        </div>');
                        $button.before($alert);
                    }
                    $alert.find('.alert-message').empty().html(errors.error);
                    $alert.show();
                } else {
                    if(!checkExist($alert)){
                        $alert = $('<div id="form-ajax-alert" class="alert alert-danger alert-dismissible" role="alert">\n\
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n\
                                            <span class="alert-message">Attention!</span>\n\
                                        </div>');
                        $button.before($alert);
                    }
                    $alert.find('.alert-message').empty().html("Une erreur est survenue, votre demande ne peut être traitée pour le moment.");
                    $alert.show();
                }
            }
        });
    }
});