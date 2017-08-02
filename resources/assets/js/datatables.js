$(document).on('click', '.datatable-container .pagination a', function (e) {
    var dtContainer = $(this).parentsInclude('.datatable-container');
    var dtId = $(dtContainer).find('.datatable').attr('id');
    var page = $(this).attr('href').split('page=')[1];
    e.preventDefault();
    var ajaxParams = {};
        ajaxParams['page'] = page;
        ajaxParams['id'] = dtId;
        
        $.ajax({
            url: '/reload_datatable',
            data: ajaxParams,
            method: 'POST'
        })
        .done(function( data ) {
            if(typeof data.success != 'undefined' && data.success == 0){
                alert('Un problème est survenu lors du chargement des données ['+dtId+']');
            } else {
                $(dtContainer).empty().html(data);
                $(document).trigger('datatableReloaded');
            }
        });
});