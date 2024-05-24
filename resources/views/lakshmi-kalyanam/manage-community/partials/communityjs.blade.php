<script>
    $(function() {
        $('.close').click(function() {
            $('.modal').modal('hide')
        })
        $('.form-control,.form-select').on('keyup change', function() {
            $('.validate_errors').text('')
        })
        showlist()
    })

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#community-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#community-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-manage-community.laksh_community') }}",
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
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'sortorder',
                    name: 'sortorder'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<select class="form-control" name="status_es${row.id}" id="status_es${row.id}" onchange="Status_es_Change(${row.id})">
                                                <option ${ row.status == 'Active' ? 'selected' : '' } value="Active">Active</option>
                                                <option ${ row.status == 'InActive' ? 'selected' : '' } value="InActive">Inactive</option>
                                            </select>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="javascript:EditData(${row.id});" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteData(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-trash"></i></a></li>
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
                    url: "{{ route('change-community-status.laksh_community') }}",
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
                                timer: 2500
                            }).then(function() {
                                var table = $('#community-table').DataTable();
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
                                icon: "danger",
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

    function DeleteData(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-community-data.laksh_community') }}",
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
                                var table = $('#community-table').DataTable();
                                table.row('#row_' + id).remove().draw(false);
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

    function CreateData() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = $('#data_create_form').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('create-the-community.laksh_community') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    $("#data_create_form")[0].reset();
                    $('#create_community_modal').modal('hide')
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
                if (response['status'] == 401) {
                    const obj = response['errors'];
                    for (const fieldName in obj) {
                        if (obj.hasOwnProperty(fieldName)) {
                            $(`[id="${fieldName}_error"]`).text(obj[fieldName][0])
                            const inputField = $(`[id="${fieldName}"]`);
                            inputField.focus();
                            $('html, body').animate({
                                scrollTop: inputField.offset().top -
                                    80
                            }, 500);
                            break;
                        }
                    }
                }
                if (response['status'] == 400) {
                    $("#data_create_form")[0].reset();
                    $('#create_community_modal').modal('hide')
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

    function EditData(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('get-the-community.laksh_community') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#data_update_form")[0].reset();
                if (response['status'] == 200) {
                    $('#edit_community_title').val(response['data'].name)
                    $('#edit_sort_order').val(response['data'].sortorder)
                    $('#edit_status_of_data').val(response['data'].status)
                    $('#edit_id').val(response['data'].id)
                    $('#edit_community_modal').modal('show')
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

    function UpdateTheData() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = $('#data_update_form').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('update-the-community.laksh_community') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    $("#data_update_form")[0].reset();
                    $('#edit_community_modal').modal('hide')
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: 'Success..!',
                        text: response['message'],
                        timer: 2500,
                          showConfirmButton: false
                    }).then(function() {
                         var table = $('#community-table').DataTable();
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
                if (response['status'] == 401) {
                    const obj = response['errors'];
                    for (const fieldName in obj) {
                        if (obj.hasOwnProperty(fieldName)) {
                            $(`[id="${fieldName}_error"]`).text(obj[fieldName][0])
                            const inputField = $(`[id="${fieldName}"]`);
                            inputField.focus();
                            $('html, body').animate({
                                scrollTop: inputField.offset().top -
                                    80
                            }, 500);
                            break;
                        }
                    }
                }
                if (response['status'] == 400) {
                    $("#data_update_form")[0].reset();
                    $('#edit_community_modal').modal('hide')
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
</script>
