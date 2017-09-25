$(document).on('click', '.datatable-container .pagination a', function (e) {
    var dtContainer = $(this).parentsInclude('.datatable-container');
    var dtId = $(dtContainer).find('.datatable').attr('id');
    var page = $(this).attr('href').split('page=')[1];
    e.preventDefault();
    var ajaxParams = {};
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