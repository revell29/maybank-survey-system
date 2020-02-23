<script>
    $(function() {
    
            // Select all checkbox
            $('#select-all').on('click', function(){
                this.checked ? table.rows().select() : table.rows().deselect();
            });

    
            setSelect2ForAction();
            function setSelect2ForAction() {
                $(".dataTables_filter select").select2({
                    minimumResultsForSearch: Infinity,
                    closeOnSelect: true,
                    width: 'auto'
                });
            };
    
            $('#table-action').change(function() {
                this.value > 0 ? confirmAction(table, this.value) : 0;
            })
    
            // Check if no records in datatables, then disabled some features
            table.on('xhr', function() {
                var json = table.ajax.json();
                if (json.data.length == 0) {
                    $('#table-action').prop('disabled', true);
                    $(".dataTables_length select").prop('disabled', true);
                } else {
                    $('#table-action').prop('disabled', false);
                    $(".dataTables_length select").prop('disabled', false);
                }
            })
    
            // On selected row event, activate or deactivate Action selection
            table.on('select', function() {
                checkMoreAction();
            })
    
            // On deselected row event, activate or deactivate Action selection
            table.on('deselect', function() {
                checkMoreAction();
            })
    
            function checkMoreAction() {
                if (table.rows({selected: true}).indexes().length > 0) {
                    $(".dataTables_filter select#table-action").find("option[value='1']").prop('disabled', false);
                    $(".dataTables_filter select#table-action").find("option[value='2']").prop('disabled', false);
                    $(".dataTables_filter select#table-action").find("option[value='3']").prop('disabled', false);
                } else {
                    $(".dataTables_filter select#table-action").find("option[value='1']").prop('disabled', true);
                    $(".dataTables_filter select#table-action").find("option[value='2']").prop('disabled', true);
                    $(".dataTables_filter select#table-action").find("option[value='3']").prop('disabled', true);
                }
                setSelect2ForAction();
            }
    
            // Add placeholder to the datatable filter option
            $('.dataTables_filter input[type=search]').attr('placeholder','Type here..');
    
            // Enable Select2 select for the length option
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });
    
            // Styling select all checkbox
            $(".styled, .multiselect-container input").uniform({
                radioClass: 'choice'
            });
    
        })
    
        function confirmAction(table, option, url) {
            var ids = $.map(table.rows({ selected: true }).data(), function (item) {
                return item.id
            });
    
            if (option == 1) {
                url = $('#data-table').data('url') + '/restore/' + ids;
                confirm(table, 1, url, 'POST')
            } else if (option == 2) {
                url = $('#data-table').data('url') + '/delete/' + ids;
                confirm(table, 2, url, 'GET') // Sebelum nya DELETE
            } else if (option == 3) {
                url = $('#data-table').data('url') + '/remove/' + ids;
                confirm(table, 3, url, 'DELETE')
            }
    
            $('#table-action').val(0).change();
        }
    
        function confirm(table, option, url, type) {
            var title = option == 2 ? '{{ trans('warning.delete.title') }}' : '{{ trans('warning.restore.title') }}';
            var text = option == 2 ? '{{ trans('warning.delete.text') }}' : '{{ trans('warning.restore.text') }}';
            var conf = option == 2 ? '{{ trans('warning.delete.confirm.yes') }}' : '{{ trans('warning.restore.confirm.yes') }}';
            var canc = option == 2 ? '{{ trans('warning.delete.confirm.no') }}' : '{{ trans('warning.restore.confirm.no') }}';
    
            if (option == 3) {
                title = '{{ trans('warning.remove.title') }}';
                text = '{{ trans('warning.remove.text') }}';
                conf = '{{ trans('warning.remove.confirm.yes') }}';
                canc = '{{ trans('warning.remove.confirm.no') }}';
            }
    
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: type,
                        success: function() {
                            if (option == 3) {
                                notification('Success','{{ trans('warning.remove.isConfirm.text') }}', 'success','bg-success border-success');
                            } else if (option == 2) {
                                notification('Success','{{ trans('warning.delete.isConfirm.text') }}', 'success','bg-success border-success');
                            } else {
                                notification('Success','{{ trans('warning.restore.isConfirm.text') }}', 'success','bg-success border-success');
                            }
                            table.ajax.reload();
                            // location.reload();
                        },
                        error: function() {
                            if (option == 3) {
                                notification('Error','{{ trans('warning.remove.isError') }}', 'error','bg-danger border-danger');
                            } else if (option == 2) {
                                notification('Error','{{ trans('warning.delete.isError') }}', 'error','bg-danger border-danger');
                            } else {
                                notification('Error','{{ trans('warning.restore.isError') }}', 'error','bg-danger border-danger');
                            }

                        }
                    })
                }
            })        
        }
    
</script>