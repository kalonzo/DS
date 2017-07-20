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
                var liSection = "<li class='ui-autocomplete-category' onclick=\"document.location.href='/search?order_by="+ item.order_by +"'\">"
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
    
    $(document).on('search-ready ajaxSuccess', function(){
        $('#distance-slider:not(.sliderProcessed)').each(function(){
            $(this).addClass('sliderProcessed');
            var filterValue = $(this).attr('data-value');
            $(this).slider({
                range: true,
                min: 0,
                max: 20,
                step: 5,
                values: [0, filterValue],
                slide: function( event, ui ) {
                    var value = ui.value;
                    $('#distance-slider-max').html(value);
                },
                stop: function( event, ui ) {
                    reloadSearch('distance', ui.value);
                }
            });
        });
    });
    
    $('body').on('change', '.search-filter-input', function(){
        var value = $(this).val();
        var label = $(this).attr('name');
        reloadSearch(label, value);
    });
    
    function reloadSearch(filterName, value){
        var ajaxParams = {};
        ajaxParams['reload'] = true;
        ajaxParams[filterName] = value;
        
        $.ajax({
            url: '/search',
            data: ajaxParams
        })
        .done(function( data ) {
            $('#search-container').empty().html(data);
            $(document).trigger('searchUpdated');
        });
    };
    
    /**************************************************************************/
    $(document).trigger('search-ready');
});
