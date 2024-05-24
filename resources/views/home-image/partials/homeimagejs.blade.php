<script>
    $(function() {
        $('.articlecreatemodal').click(function() {
            $('#service_artical_create_modal').modal('show')
        })
        $('.close').click(function() {
            $('#service_artical_create_modal').modal('hide')
            $('#service_artical_edit_modal').modal('hide')
        })
        $('#service_title').keyup(function() {
            if ($('#service_title').val() == '') {
                $('#service_title_error').text('Please fill the title. *')
            } else {
                $('#service_title_error').text('')
            }
        })
        $('#edit_service_title').keyup(function() {
            if ($('#edit_service_title').val() == '') {
                $('#edit_service_title_error').text('Please fill the title. *')
            } else {
                $('#edit_service_title_error').text('')
            }
        })
        showlist()
    })

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#home-image-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#home-image-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-home-image.home-image') }}",
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
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'content',
                    name: 'content'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<select class="form-control" name="service_status${row.id}" id="service_status${row.id}" onchange="ServiceStatusChange(${row.id})">
                                 <option ${row.status == 'Active' ? 'selected' : ''} value="Active">Active</option>
                                <option ${row.status == 'Inactive' ? 'selected' : ''} value="Inactive">Inactive</option>
                            </select>`;
                    }
                },

                {
                   data: null,
                   render: function(data, type, row) {
                       return `<ul style="display: flex;">
                               <li style="list-style-type: none;"><a href="javascript:EditServices(${row.id});" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editservices"><i class="fa fa-edit"></i></a></li>
                               <li style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheService(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary deleteservices"><i class="fa fa-trash"></i></a></li>
                           </ul>`;
                   }
                    
                }
            ],
             createdRow: function(row, data, dataIndex) {
            $(row).attr('id', 'row_' + data.id); // Assuming `data.id` is the unique identifier for each row
            }
        });
    }

    function CreateService() {
    if ($('#service_title').val() == '') {
        $('#service_title_error').text('Please fill the title. *');
        return false;
    }
    $('#service_artical_create_modal').modal('hide');
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var formData = new FormData($('#create_service_form')[0]);
    $.ajax({
        type: 'post',
        url: "{{ route('create-home-image.home-image') }}",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            $("#create_service_form")[0].reset();
            if (response.status == 200) {
                Swal.fire({
                    position: "top-right",
                    icon: "success",
                    title: response.message,
                    timer: 2500,
                    showConfirmButton: false
                }).then(function() {
                    showlist();
                });
            }
            if (response.status == 400) {
                Swal.fire({
                    position: "top-right",
                    icon: "danger",
                    title: response.message,
                    timer: 2500,
                    showConfirmButton: false
                }).then(function() {
                    showlist();
                });
            }
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
}


    function ServiceStatusChange(id) {
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
                    url: "{{ route('home-image-change-status.home-image') }}",
                    data: {
                        id: id,
                        status: $('#service_status' + id).val()
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
                                showConfirmButton: false,
                                timer: 2500
                            }).then(function() {
                                showlist()
                            });
                        }
                        if (response['status'] == 400) {
                            Swal.fire({
                                position: "top-right",
                                icon: "danger",
                                title: response['message'],
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

    function EditServices(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('get-home-image-data.home-image') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#edit_service_form")[0].reset();
                if (response['status'] == 200) {
                    $('#edit_title').val(response['data'][0].title)
                    $('#edit_content').val(response['data'][0].content)
                    $('#edit_status').val(response['data'][0].status)
                    $('#edit_shord_order').val(response['data'][0].shord_order)
                    $('#edit_service_id').val(response['data'][0].id)
                    $('#edit_service_url').val(response['data'][0].service_url)
                    $('#view_image').attr('src', response['data'][0].image);
                    $('#service_artical_edit_modal').modal('show')
                }
                if (response['status'] == 400) {
                    Swal.fire({
                        position: "top-right",
                        icon: "danger",
                        title: response['message'],
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

    function UpdateTheDataOfService() {
    if ($('#edit_service_title').val() == '') {
        $('#edit_service_title_error').text('Please fill the title. *')
        return false;
    }

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var formData = new FormData($('#edit_service_form')[0]);
    $.ajax({
        type: 'post',
        url: "{{ route('update-home-image-data.home-image') }}",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            if (response['status'] == 200) {
                $('#service_artical_edit_modal').modal('hide')
                Swal.fire({
                    position: "top-right",
                    icon: "success",
                    title: 'Success...!',
                    text: response['message'],
                    timer: 2500,
                    showConfirmButton: false
                }).then(function() {
                    var table = $('#home-image-table').DataTable();
                    var rowId = response['updatedRowData']['id'];
                    var rowData = response['updatedRowData'];
                    var row = table.row('#row_' + rowId);
                    if (row.length) {
                        row.data(rowData).draw();
                    } else {
                        showlist();
                    }
                });
            } else if (response['status'] == 401) {
                const obj = response['errors'];
                for (const fieldName in obj) {
                    if (obj.hasOwnProperty(fieldName)) {
                        $(`[id="${fieldName}_error"]`).text(obj[fieldName][0])
                        const inputField = $(`[id="${fieldName}"]`);
                        inputField.focus();
                        $('html, body').animate({
                            scrollTop: inputField.offset().top - 80
                        }, 500);
                        break;
                    }
                }
            } else if (response['status'] == 400) {
                $('#service_artical_edit_modal').modal('hide')
                Swal.fire({
                    position: "top-right",
                    icon: "danger",
                    title: response['message'],
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


    function DeleteTheService(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the service!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-data-home-image.home-image') }}",
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
                                var table = $('#home-image-table').DataTable();
                                table.row('#row_' + id).remove().draw(false);
                            });
                        }

                        if (response['status'] == 400) {
                            Swal.fire({
                                position: "top-right",
                                icon: "danger",
                                title: response['message'],
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

    function goBack() {
        window.history.back();
    }
</script>