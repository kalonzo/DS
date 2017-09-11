$('body').on('click', '.form-data-button', function () {
    var form = $(this).parentsInclude('form');
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
                location.reload();
            },
            error: function (data) {
                var errors = data.responseJSON;

                $(form).find('.has-error [data-toggle=tooltip]').tooltip('destroy');
                $(form).find('.has-error').removeClass('has-error');
                var first = true;
                var $scrollRefElement = $(form).parentsInclude('.ref-scroller');
                if (!checkExist($scrollRefElement)) {
                    $scrollRefElement = $('body');
                }
                $.each(errors, function (key, value) {
                    var $input = $(form).find('[name="' + key + '"]');
                    if (checkExist($input)) {
                        if (first) {
                            first = false;
                            if (checkExist($scrollRefElement)) {
                                var inputTopPosition = $input.offset().top;
                                var inputHeight = $input.outerHeight();
                                var refScrollTopPosition = $scrollRefElement.offset().top;
                                var refScrollHeight = $scrollRefElement.height();
                                
                                var targetTopPosition = refScrollTopPosition - inputTopPosition + refScrollHeight - (inputHeight + 50);
                                $($scrollRefElement).animate({
                                    scrollTop: targetTopPosition
                                }, 500);
                            }
                        }
                        var $formGroup = $input.parentsInclude('.form-group');
                        $formGroup.addClass('has-error');
                        $input.tooltip({
                            title: value.join(', '),
                            trigger: 'manual'
                        }).tooltip('show');
                        $input.change(function () {
                            $(this).tooltip('destroy');
                            $formGroup.removeClass('has-error');
                        });
                    }
                });
            }
        });
    }
});