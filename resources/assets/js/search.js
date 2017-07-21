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
        $('#price-slider:not(.sliderProcessed)').each(function(){
            $(this).addClass('sliderProcessed');
            var filterValue = $(this).attr('data-value');
            var maxValue = $(this).attr('data-max');
            if(isEmpty(filterValue)){
                filterValue = maxValue;
            }
            $(this).slider({
                range: true,
                min: 0,
                max: maxValue,
                step: 5,
                values: [0, filterValue],
                slide: function( event, ui ) {
                    var value = ui.value;
                    $('#price-slider-max').html(value);
                },
                stop: function( event, ui ) {
                    reloadSearch('price', ui.value);
                }
            });
        });
    });
    
    $('body').on('change', '.search-filter-input', function(){
        var filterLabel = $(this).attr('name');
        var filterValue = $(this).val();
        switch(this.tagName){
            case 'INPUT':
                switch($(this).attr('type')){
                    case 'checkbox':
                        var inputLabel = $(this).attr('name');
                        if(filterLabel.indexOf('[]') !== -1){
                            var formGroup = $(this).parentsInclude('.form-group');
                            filterLabel = filterLabel.replace('[]', '');
                            var $siblings = $(formGroup).find('.search-filter-input[name="'+inputLabel+'"]:checked');
                            $siblings.add(this);
                            filterValue = $.map($siblings, function(c){return c.value; });
                            if(isEmptyArray(filterValue)){
                                filterValue = null;
                            }
                        }
                        break;
                }
                break;
//            case 'SELECT':
//                filterLabel = inputLabel;
//                break;
//            case 'DIV':
//                
//                break;
        }
        
        reloadSearch(filterLabel, filterValue);
    });
    
    $('#filterModal').on('show.bs.modal', function(e){
        var triggerElement = e.relatedTarget;
        var formGroup = $(triggerElement).parentsInclude('.form-group').clone();
        $(this).find('.modal-body').empty().append(formGroup);
    });
    
    function reloadSearch(filterName, value){
        var ajaxParams = {};
        ajaxParams['reload'] = true;
        ajaxParams[filterName] = value;
        
        $.ajax({
            url: '/search',
            data: ajaxParams,
//            method: 'POST'
        })
        .done(function( data ) {
            $('#search-container').empty().html(data);
            $(document).trigger('searchUpdated');
        });
    };
    
    /**************************************************************************/
    $(document).trigger('search-ready');
});
