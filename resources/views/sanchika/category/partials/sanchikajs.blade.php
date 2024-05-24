<script>
    $(function() {
        $('.sanchik_categorycreatemodal').click(function() {
            $('#sanchik_category_create_modal').modal('show')
        })
        // $('.summernote').summernote()
        $('.summernote').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
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
        var existingTable = $('#category-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#category-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-sanchika-categories-list.sanchik_cat') }}",
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
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'category_slug',
                    name: 'category_slug'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<input class="form-control" value="${row.sort_order == null ? '' : row.sort_order}" name="cat_sort_order${row.id}" id="cat_sort_order${row.id}" onkeyup="UpdateSortOrder(${row.id})">`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<select class="form-control" name="status_es${row.id}" id="status_es${row.id}" onchange="Status_es_Change(${row.id})">
                                                <option ${ row.status == 'Active' ? 'selected' : '' } value="Active">Active</option>
                                                <option ${ row.status == 'Inactive' ? 'selected' : '' } value="Inactive">Inactive</option>
                                            </select>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="javascript:EditCategory(${row.id});" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary edittutcategory"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheCategory(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary deletetutcategory"><i class="fa fa-trash"></i></a></li>
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
            createdRow: function(row, data, dataIndex) {
            $(row).attr('id', 'row_' + data.id); // Assuming `data.id` is the unique identifier for each row
            }
        });
    }
    
    function CreateCategory() {
        if ($('#sanchik_category_name').val() == '') {
            $('#sanchik_category_name_error').text('Please fill the name. *')
            return false;
        }
        if ($('#sanchik_category_status').val() == '') {
            $('#sanchik_category_status_error').text('Please select status. *')
            return false;
        }
        if ($('#sanchik_category_sort').val() == '') {
            $('#sanchik_category_sort_error').text('Please enter sort order. *')
            return false;
        }
        $('#sanchik_category_create_modal').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = new FormData($('#create_sanchik_category_form')[0]);
        $.ajax({
            type: 'post',
            url: "{{ route('create-sanchika-category.sanchik_cat') }}",
            data: formdata,
            processData: false,  // Important! Prevents jQuery from automatically transforming the data into a query string
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#create_sanchik_category_form")[0].reset();
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
    
    function EditCategory(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('get-sanchika-category.sanchik_cat') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#edit_sanchik_category_form")[0].reset();
                if (response['status'] == 200) {
                    $('#edit_sanchik_category_name').val(response['data'][0].category_name)
                    $('#edit_sanchik_category_status').val(response['data'][0].status)
                    $('#edit_sanchik_cat_id').val(response['data'][0].id)
                    $('#edit_sanchik_category_sort').val(response['data'][0].sort_order)
                    $('#edit_sanchik_category_modal').modal('show')
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
    
    function UpdateTheDataCategory() {
        if ($('#edit_sanchik_category_name').val() == '') {
            $('#edit_sanchik_category_name_error').text('Please fill the name. *')
            return false;
        }
        if ($('#edit_sanchik_category_status').val() == '') {
            $('#edit_sanchik_category_status_error').text('Please select status. *')
            return false;
        }
        if ($('#edit_sanchik_category_sort').val() == '') {
            $('#edit_sanchik_category_sort_error').text('Please enter sort order. *')
            return false;
        }
        $('#edit_sanchik_category_modal').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = new FormData($('#edit_sanchik_category_form')[0]);
        $.ajax({
            type: 'post',
            url: "{{ route('update-sanchika-category.sanchik_cat') }}",
            data: formdata,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#edit_sanchik_category_form")[0].reset();
                if (response['status'] == 200) {
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: 'Success...!',
                        text: response['message'],
                        timer: 2500,
                          showConfirmButton: false
                    }).then(function() {
                        var table = $('#category-table').DataTable();
                        var rowId = response['updatedRowData']['id']; 
                        var rowData = response['updatedRowData'];
                        var row = table.row('#row_' + rowId);
                        if (row.length) {
                            row.data(rowData).draw();
                        } else {
                            showlist();
                        }
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
    
    function UpdateSortOrder(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('update-sanchika-category-sort.sanchik_cat') }}",
            data: {
                id: id,
                sort_order: $('#cat_sort_order'+id).val()
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: 'Success...!',
                        text: response['message'],
                        timer: 2500,
                          showConfirmButton: false
                    }).then(function() {
                        var table = $('#category-table').DataTable();
                        var rowId = response['updatedRowData']['id']; 
                        var rowData = response['updatedRowData'];
                        var row = table.row('#row_' + rowId);
                        if (row.length) {
                            row.data(rowData).draw();
                        } else {
                            showlist();
                        }
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
    
    function Status_es_Change(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to change status!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('update-sanchika-category-status.sanchik_cat') }}",
                    data: {
                        id: id,
                        status: $('#status_es' + id).val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response['status'] == 200) {
                            Swal.fire({
                                position: "top-right",
                                icon: "success",
                                title: 'Success..!',
                                text: response['message'],
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                var table = $('#category-table').DataTable();
                                var rowId = response['updatedRowData']['id']; 
                                var rowData = response['updatedRowData'];
                                var row = table.row('#row_' + rowId);
                                // console.log(row.length)
                                if (row.length) {
                                    row.data(rowData).draw();
                                } else {
                                    showlist();
                                }
                            });
                        }
                        if (response['status'] == 400) {
                            Swal.fire({
                                position: "top-right",
                                icon: "danger",
                                title: 'Failed..!',
                                text: response['message'],
                                showConfirmButton: false,
                                timer: 2500
                            }).then(function() {
                                // showlist() --> it has lag to load
                                location.reload() // so use reload
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
    
    function DeleteTheCategory(id) {
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
                    url: "{{ route('delete-sanchika-category-status.sanchik_cat') }}",
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
                                // showlist()
                                // var table = $('#category-table').DataTable();
                                // table.ajax.reload(null, false);
                                var table = $('#category-table').DataTable();
                                table.row('#row_' + id).remove().draw(false);
                                // updateSerialNumbers(table);
                            });
                        }
                        if (response['status'] == 400) {
                            Swal.fire({
                                position: "top-right",
                                icon: "warning",
                                title: 'Failed..!',
                                text: response['message'],
                                showConfirmButton: false,
                                timer: 2500
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