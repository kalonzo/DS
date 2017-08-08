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
    $searckKeywordInstance = $("#search_keywords").autocomplete("instance");
    $searckKeywordInstance._renderMenu = function (ul, items) {
        var that = this;
        $(ul).addClass('searchKeywordDropdown');
        var currentCategory = "";
        var indexCategory = 0;
        $.each(items, function (index, item) {
            if (item.section != currentCategory) {
                indexCategory++;
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
                li.attr("data-index", indexCategory);
            }
        });
        if(typeof map !== 'undefined'){
            $(map).trigger('locationsUpdated', {items: items});
        }
    };
    $searckKeywordInstance._renderItem = function( ul, item ) {
        var that = this;
        var li = $( "<li>" );
        var wrapper = $("<div>", {title: item.label});
        
        if(!item.avatar_bg_color){
            item.avatar_bg_color = '#FFF';
        }
        var avatar = "<div class='ui-menu-item-avatar' style='background-color: "+item.avatar_bg_color+";'>";
        if(item.picture){
            avatar += "<img class='ui-menu-item-picture' src='"+ item.picture+"' alt='Logo'/>";
        }
        if(item.avatar_text){
            avatar += "<span class='ui-menu-item-avatar-text'>"+ item.avatar_text+"</span>";
        }
        avatar += "</div>";
        wrapper.append(avatar);
        
        if ( item.label ) {
                wrapper.append("<span class='ui-menu-item-text'>"+ item.label+"</span>");
        } else {
                wrapper.html( "&#160;" );
        }
        if ( item.text_right ) {
                wrapper.append("<span class='ui-menu-item-text-right'>"+ item.text_right+"</span>");
        }
        if ( item.disabled ) {
            that._addClass( li, null, "ui-state-disabled" );
        }

        return li.append( wrapper ).appendTo( ul );
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
            var minValue = $(this).attr('data-min');
            var maxValue = $(this).attr('data-max');
            if(isEmpty(filterValue)){
                filterValue = maxValue;
            }
            $(this).slider({
                range: true,
                min: 0,
                max: maxValue,
                step: 10,
                values: [0, filterValue],
                slide: function( event, ui ) {
                    var value = ui.value;
                    if(value < minValue){
                        event.stopPropagation();
                        return false;
                    } else {
                        $('#price-slider-max').html(value);
                    }
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
    
    $('body').on('hide.bs.collapse', '#search-results-filters-body', function(){
        dsSetCookie('searchFilterCollapsed', 1, 1);
    });
    $('body').on('show.bs.collapse', '#search-results-filters-body', function(){
        dsSetCookie('searchFilterCollapsed', 0, 1);
    });
    
    $('#filterModal').on('show.bs.modal', function(e){
        var triggerElement = e.relatedTarget;
        var formGroup = $(triggerElement).parentsInclude('.form-group').clone();
        $(this).find('.modal-body').empty().append(formGroup);
    });
    
    $('body').on('click', '#search-results-filters .filterResetTrigger button', function(e){
        reloadSearch('reset', 1);
    });
    
    $(document).on('click', '.pagination a', function (e) {
        var page = $(this).attr('href').split('page=')[1];
        e.preventDefault();
        reloadSearch('page', page);
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
