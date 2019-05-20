/**
 * Created by dira on 21/12/18.
 */
function notification(title,text, type,bg) {
    new PNotify({
        title: title,
        text: text,
        type: type,
        addclass: bg
    });
}

$('.select').select2();

$('.select-nosearch').select2({
    minimumResultsForSearch: Infinity
})

// Setting datatable defaults
$.extend( $.fn.dataTable.defaults, {
    processing: true,
    serverSide: true,
    pageLength: 20,
    scrollX: false,
    autoWidth: false,
    order: [0, 'desc'],
    lengthMenu: [ 10, 20, 50, 75, 100 ],
    select: {
        style: 'multi',
        selector: 'td:first-child'
    },
    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    language: {
        search: '<span style="margin-left: 30px">Search:</span> _INPUT_',
        lengthMenu: '<span>Show:</span> _MENU_',
        paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
    },
    drawCallback: function () {
        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
    },
    preDrawCallback: function() {
        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
    }
});