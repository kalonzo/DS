$(document).on('click', '.datatable-container .pagination a', function (e) {
    e.preventDefault();
    var dtContainer = $(this).parentsInclude('.datatable-container');
    var dtId = $(dtContainer).find('.datatable').attr('id');
    var page = $(this).attr('href').split('page=')[1];
    
    var ajaxParams = {};
    var $filtersForm = $(dtContainer).find('form.datatable-filters');
    if(checkExist($filtersForm)){
        var formData = $filtersForm.serializeArray();
        $.each(formData, function(key, item){
            ajaxParams[item.name] = item.value;
        });
    }
    ajaxParams['page'] = page;
    ajaxParams['id'] = dtId;

    reloadDatatable(dtContainer, ajaxParams);
});

$(document).on('reload', '.datatable-container', function (e, params) {
    e.stopPropagation();
    reloadDatatable(this, params);
});
$(document).on('reload', '.datatable', function (e, params) {
    e.stopPropagation();
    reloadDatatable($(this).parentsInclude('.datatable-container'), params);
});

function reloadDatatable(datatable, params){
    var dtId = $(datatable).find('.datatable').attr('id');
    if(typeof params != 'array' && typeof params != 'object'){
        params = {};
    }
    if(typeof params['id'] == 'undefined'){
        params['id'] = dtId;
    }
    $.ajax({
        url: '/reload_datatable',
        data: params,
        method: 'POST'
    })
    .done(function( data ) {
        if(typeof data.success != 'undefined' && data.success == 0){
            alert('Un problème est survenu lors du chargement des données ['+dtId+']');
        } else {
            $(datatable).empty().html(data);
            $(document).trigger('datatableReloaded');
        }
    });
}

$(document).on('submit', '.datatable-filters', function(e){
    e.stopPropagation();
    e.preventDefault();
    return false;
});

function applyDatatableFilters(filterElement){
    var dtContainer = $(filterElement).parentsInclude('.datatable-container');
    var $filtersForm = $(filterElement).parentsInclude('form');
    var formData = $filtersForm.serializeArray();
    var params = {};
    $.each(formData, function(key, item){
        params[item.name] = item.value;
    });
    reloadDatatable(dtContainer, params);
}

$(document).on('change', '.datatable-container input, .datatable-container select', function(){
    applyDatatableFilters(this);
});

/*
datatableFiltersTimeout = {};
$(document).on('keyup', '.datatable-container input[type=text]', function(){
    var filterElement = this;
    var name = $(this).attr('name').replace('[', '.').replace(']', '');
    clearTimeout(datatableFiltersTimeout[name]);
    datatableFiltersTimeout[name] = setTimeout(function(){
        applyDatatableFilters(filterElement);
    }, 300);
});
*/