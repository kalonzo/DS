$(function () {
    $("#search_keywords").autocomplete({
        source: "/search-autocomplete/",
        minLength: 2

    }).autocomplete("instance")._create = function() {
        this._super();
        this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
    };
    $("#search_keywords").autocomplete("instance")._renderMenu = function (ul, items) {
        var that = this;
        $(ul).addClass('searchKeywordDropdown');
        var currentCategory = "";
        $.each(items, function (index, item) {
            if (item.section != currentCategory) {
                ul.append("<li class='ui-autocomplete-category'><span class='category-label'>" + item.section + "</span><span class='category-opener'>+</span></li>");
                currentCategory = item.section;
            }
            var li;
            li = that._renderItemData(ul, item);
            if (item.section) {
                li.attr("aria-label", item.section + " : " + item.label);
            }
        });
    };
    $("#search_keywords").focus(function(){
        var autocomplete = $(this).autocomplete("instance");
        if(!isEmpty(autocomplete)){
            $(autocomplete.menu.element).show();
        }
    });
});