/**
 * Created by bento on 8/13/16.
 */

function notification(text, type) {
    noty({
        width: 400,
        text: text,
        type: type,
        dismissQueue: true,
        timeout: 4000,
        layout: "bottomCenter",
    });
}

$(function() {

    $('.select').select2();

    $('.select-nosearch').select2({
        minimumResultsForSearch: Infinity
    })

    $('button[name=draft], button[name=cancel], button[name=approve], button[name=receive]').click(function(event) {
        event.preventDefault();
        var form = $(this).parents('form:first');
        var title = this.name
        var text = "Save this document as 'Draft' ? You can edit this document later."
        if (title == 'approve') {
            text = "Approved this document ? You cannot undo this action."
        } else if (title == 'cancel') {
            text = "Cancel this document ? You cannot undo this action."
        } else if (title == 'receive') {
            text = "Complete document to receive this goods ? You cannot undo this action."
        } else if (title == 'close') {
            text = "Closing document ? You cannot undo this action."
        }

        swal({
            title: "Are you sure?",
            text: text,
            type: "question",
            showCancelButton: true,
            cancelButtonColor: "red",
            confirmButtonColor: "grey",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then(function() {
            if (title == 'draft') {
                $(form).append('<input name=draft value=1>');
            } else if (title == 'approve') {
                $(form).append('<input name=approve value=1>');
            } else if (title == 'cancel') {
                $(form).append('<input name=cancel value=1>');
            } else if (title == 'receive') {
                $(form).append('<input name=receive value=1>');
            } else if (title == 'close') {
                $(form).append('<input name=close value=1>');
            }
            $(form).trigger('submit');
        });
    });

})



