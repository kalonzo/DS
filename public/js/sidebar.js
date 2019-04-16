/**
 * 
 * Sidebar positions : sidebar-fixed-left, sidebar-fixed-right, sidebar-stacked, sidebar-default
 */
$(document).ready(function () {
    $('.custom-sidebar').each(function () {
        var $sidebar = $(this);
        var togglerSelector = $(this).attr('data-toggler');
        var toggleButtons = $(togglerSelector);

        var sidebarId = $(this).attr('id');
        if (!isEmpty(sidebarId)) {
            var $overlay = $('.custom-sidebar-overlay[data-sidebar=' + sidebarId + ']');
            if (!checkExist($overlay)) {
                $overlay = $('<div class="custom-sidebar-overlay" data-sidebar="' + sidebarId + '"></div>');
                $('body').append($overlay);
            }
        }

        if ($sidebar.hasClass('sidebar-stacked')) {
            $('body').css('display', 'table');
        }

        $(toggleButtons).on('click', function () {
            $sidebar.toggleClass('open');
            if (($sidebar.hasClass('sidebar-fixed-left') || $sidebar.hasClass('sidebar-fixed-right')) && $sidebar.hasClass('open')) {
                $overlay.addClass('active');
            } else {
                $overlay.removeClass('active');
            }
        });

        $overlay.on('click', function () {
            $(this).removeClass('active');
            $sidebar.removeClass('open');
        });
    });
});


(function (removeClass) {

    jQuery.fn.removeClass = function (value) {
        if (value && typeof value.test === "function") {
            for (var i = 0, l = this.length; i < l; i++) {
                var elem = this[i];
                if (elem.nodeType === 1 && elem.className) {
                    var classNames = elem.className.split(/\s+/);

                    for (var n = classNames.length; n--; ) {
                        if (value.test(classNames[n])) {
                            classNames.splice(n, 1);
                        }
                    }
                    elem.className = jQuery.trim(classNames.join(" "));
                }
            }
        } else {
            removeClass.call(this, value);
        }
        return this;
    }

})(jQuery.fn.removeClass);