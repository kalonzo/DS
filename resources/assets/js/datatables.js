$(document).on('click', '.datatable-container .pagination a', function (e) {
    var dtContainer = $(this).parentsInclude('.datatable-container');
    var page = $(this).attr('href').split('page=')[1];
    e.preventDefault();
    var ajaxParams = {};
        ajaxParams['reload'] = true;
        ajaxParams['page'] = page;
        
        $.ajax({
            url: '/ajax/reload_datatable',
            data: ajaxParams,
        })
        .done(function( data ) {
            $(dtContainer).empty().html(data);
            $(document).trigger('datatableReloaded');
        });
});