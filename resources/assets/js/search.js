$(function () {
    $("#search_keywords").autocomplete({
        source: "/search-autocomplete/",
        minLength: 2,

    }).autocomplete("instance")._create = function() {
        this._super();
        this.widget().menu({
            items: ".ui-menu-item:not(.ui-autocomplete-category)" 
        });
    };
    $("#search_keywords").autocomplete("instance")._renderMenu = function (ul, items) {
        var that = this;
        $(ul).addClass('searchKeywordDropdown');
        var currentCategory = "";
        $.each(items, function (index, item) {
            if (item.section != currentCategory) {
                var liSection = "<li class='ui-autocomplete-category' onclick=\"document.location.href='/search?section="+ item.section_id +"'\">"
//                            + "<a href='/search?section="+ item.section_id +"'>" 
                                + "<span class='category-label'>" 
                                    + item.section 
                                + "</span>"
                                + "<span class='category-opener'>+</span>"
//                            + "</a>"
                        + "</li>"
                ul.append(liSection);
                currentCategory = item.section;
            }
            var li;
            li = that._renderItemData(ul, item);
            if (item.section) {
                li.attr("aria-label", item.section + " : " + item.label);
            }
        });
        if(!isEmpty(map)){
            $(map).trigger('locationsUpdated', {items: items});
        }
    };
    $("#search_keywords").focus(function(){
        var autocomplete = $(this).autocomplete("instance");
        if(!isEmpty(autocomplete)){
            $(autocomplete.menu.element).show();
        }
    });
    $(document).on('positionSaved', function(){
        $("#search_keywords").autocomplete("search");
    });
    
    $('#distance-slider:not(.sliderProcessed)').on('ready ajax-complete', function(){
        $(this).addClass('sliderProcessed');
        $(this).slider({
            range: true,
            min: 0,
            max: 20,
            step: 5,
            values: [0, 5],
            slide: function( event, ui ) {
                var value = ui.value;
                $('#distance-slider-max').html(value);
            },
            stop: function( event, ui ) {
                var value = ui.value;
                $.ajax({
                    url: '/reload-search',
                    data: {'distance': value}
                })
                .done(function( data ) {
                    $('#search-container').empty().html(data);
                });
            }
        });
    });
});