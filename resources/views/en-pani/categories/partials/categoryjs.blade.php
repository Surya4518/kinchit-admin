<script>
    $(function() {
        $('.enpani_categorycreatemodal').click(function() {
            $('#enpani_category_create_modal').modal('show')
        })
        $('.close').click(function() {
            $('.modal').modal('hide')
        })
        $('.form-control').on('keyup change', function() {
            $('.validate_errors').text('')
        })
        showlist()
    })

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#enpani_category-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#enpani_category-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('show-enpani-category-list.enpani_category') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        // Use meta.row to get the row index
                        return meta.row + 1; // Add 1 to start the serial number from 1
                    }
                },
                {
                    data: 'post_title',
                    name: 'post_title'
                },
                {
                    data: 'post_name',
                    name: 'post_name'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="javascript:EditEnpaniCategory(${row.ID});" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheEnpaniCategory(${row.ID});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-trash"></i></a></li>
                         </ul>`;
                    }
                }
            ],
            //  responsive: {
            //       details: {
            //           type: 'column',
            //           target: 'tr'
            //       }
            //   }
        });
    }

    function CreateEnpaniCategory() {
        if ($('#enpani_category_name').val() == '') {
            $('#enpani_category_name_error').text('Please fill the category name. *')
            return false;
        }
        if ($('#enpani_category_publish_status').val() == '') {
            $('#enpani_category_publish_status_error').text('Please select publish status. *')
            return false;
        }
        $('#enpani_category_create_modal').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = $('#create_enpani_category_form').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('create-enpani-category.enpani_category') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#create_enpani_category_form")[0].reset();
                if (response['status'] == 200) {
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: 'Success..!',
                        text: response['message'],
                        timer: 2500,
                        showConfirmButton: false
                    }).then(function() {
                        showlist()
                    });
                }
                if (response['status'] == 400) {
                    Swal.fire({
                        position: "top-right",
                        icon: "danger",
                        title: 'Failed..!',
                        text: response['message'],
                        timer: 2500,
                        showConfirmButton: false
                    }).then(function() {
                        showlist()
                    });
                }
            },
            error: function(data) {
                console.log('Error:', data);
            }
        })
    }

    function EditEnpaniCategory(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('get-enpani-category-data.enpani_category') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#update_enpani_category_form")[0].reset();
                if (response['status'] == 200) {
                    $('#edit_enpani_category_name').val(response['data'][0].post_title)
                    $('#edit_enpani_category_publish_status').val(response['data'][0].post_status)
                    $('#edit_enpani_category_id').val(response['data'][0].ID)
                    $('#enpani_category_edit_modal').modal('show')
                }
                if (response['status'] == 400) {
                    Swal.fire({
                        position: "top-right",
                        icon: "danger",
                        title: 'Failed..!',
                        text: response['message'],
                        timer: 2500,
                         showConfirmButton: false
                    }).then(function() {
                        showlist()
                    });
                }
            },
            error: function(data) {
                console.log('Error:', data);
            }
        })
    }

    function UpdateTheDataEnpaniCategory() {
        if ($('#edit_enpani_category_name').val() == '') {
            $('#edit_enpani_category_name_error').text('Please fill the category name. *')
            return false;
        }
        if ($('#edit_enpani_category_publish_status').val() == '') {
            $('#edit_enpani_category_publish_status_error').text('Please select publish status. *')
            return false;
        }
        $('#enpani_category_edit_modal').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = $('#update_enpani_category_form').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('update-enpani-category-data.enpani_category') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#update_enpani_category_form")[0].reset();
                if (response['status'] == 200) {
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: 'Success...!',
                        text: response['message'],
                        timer: 2500,
                        showConfirmButton: false
                    }).then(function() {
                        showlist()
                    });
                }
                if (response['status'] == 400) {
                    Swal.fire({
                        position: "top-right",
                        icon: "warning",
                        title: 'Failed...!',
                        text: response['message'],
                        timer: 2500,
                        showConfirmButton: false
                    }).then(function() {
                        showlist()
                    });
                }
            },
            error: function(data) {
                console.log('Error:', data);
            }
        })
    }

    function DeleteTheEnpaniCategory(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the category!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-enpani-category-data.enpani_category') }}",
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response['status'] == 200) {
                            Swal.fire({
                                position: "top-right",
                                icon: "success",
                                title: 'Success',
                                text: response['message'],
                                timer: 2500,
                                showConfirmButton: false
                            }).then(function() {
                                showlist()
                            });
                        }
                        if (response['status'] == 400) {
                            Swal.fire({
                                position: "top-right",
                                icon: "warning",
                                title: 'Failed..!',
                                text: response['message'],
                                showConfirmButton: true,
                                timer: 2500,,
                                showConfirmButton: false
                            }).then(function() {
                                showlist()
                            });
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            } else {
                consol.log('failed')
            }
        })
    }

</script>
