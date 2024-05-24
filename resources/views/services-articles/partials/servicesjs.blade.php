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
        var existingTable = $('#services-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#services-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-list-service.service') }}",
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
                    data: 'service_title',
                    name: 'service_title'
                },
                {
                    data: 'page_slug',
                    name: 'page_slug'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<select class="form-control" name="service_status${row.id}" id="service_status${row.id}" onchange="ServiceStatusChange(${row.id})">
                                 <option ${row.status == '0' ? 'selected' : ''} value="0">Active</option>
                                <option ${row.status == '1' ? 'selected' : ''} value="1">Inactive</option>
                            </select>`;
                    }
                },

                {
                   data: null,
                   render: function(data, type, row) {
                       return `<ul style="display: flex;">
                               <li style="list-style-type: none;"><a href="javascript:EditServices(${row.id});" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editservices"><i class="fa fa-edit"></i></a></li>
                               <li style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheService(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary deleteservices"><i class="fa fa-trash"></i></a></li>
                               <li style="list-style-type: none;margin-left: 10px;"><a href="/services/${row.id}" title="Contents" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary updatecontents"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
                           </ul>`;
                   }
                    
                }
            ],
             createdRow: function(row, data, dataIndex) {
            $(row).attr('id', 'row_' + data.id); // Assuming `data.id` is the unique identifier for each row
            }
        });
    }

    // function showlist() {
    //     var csrfToken = $('meta[name="csrf-token"]').attr('content');
    //     var existingTable = $('#services-table').DataTable();
    //     if (existingTable) {
    //         existingTable.destroy();
    //     }
    //     $('#services-table').DataTable({
    //         processing: true,
    //         searching: true,
    //         serverSide: true, // Use server-side processing
    //         ajax: {
    //             url: "/get-service-list",
    //             type: 'POST',
    //             headers: {
    //                 'X-CSRF-TOKEN': csrfToken
    //             },
    //         },
    //         columns: [{
    //                 data: 'id',
    //                 name: 'id'
    //             }, // Add 'id' column for row index
    //             {
    //                 data: 'service_title',
    //                 name: 'service_title'
    //             },
    //             {
    //                 data: 'page_slug',
    //                 name: 'page_slug'
    //             },
    //             {
    //                 data: 'status',
    //                 name: 'status',
    //                 render: function(data, type, row) {
    //                     return `<select class="form-control" name="service_status_${row.id}" id="service_status_${row.id}" onchange="ServiceStatusChange(${row.id})">
    //                             <option ${data == '0' ? 'selected' : ''} value="0">Active</option>
    //                             <option ${data == '1' ? 'selected' : ''} value="1">Inactive</option>
    //                         </select>`;
    //                 }
    //             },
    //             {
    //                 data: null,
    //                 render: function(data, type, row) {
    //                     return `<ul style="display: flex;">
    //                             <li style="list-style-type: none;"><a href="javascript:EditServices(${row.id});" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editservices"><i class="fa fa-edit"></i></a></li>
    //                             <li style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheService(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary deleteservices"><i class="fa fa-trash"></i></a></li>
    //                             <li style="list-style-type: none;margin-left: 10px;"><a href="/services/${row.id}" title="Contents" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary updatecontents"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
    //                         </ul>`;
    //                 }
    //             }
    //         ],
    //         // Other DataTable options...
    //     });
    // }


    function CreateService() {
        if ($('#service_title').val() == '') {
            $('#service_title_error').text('Please fill the title. *')
            return false;
        }
        $('#service_artical_create_modal').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = $('#create_service_form').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('create-service-article.service') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#create_service_form")[0].reset();
                if (response['status'] == 200) {
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: response['message'],
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
                    url: "{{ route('service-change-status.service') }}",
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
            url: "{{ route('get-service-data.service') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#edit_service_form")[0].reset();
                if (response['status'] == 200) {
                    $('#edit_service_title').val(response['data'][0].service_title)
                    $('#edit_meta_title').val(response['data'][0].meta_title)
                    $('#edit_meta_url').val(response['data'][0].page_slug)
                    $('#edit_meta_description').val(response['data'][0].meta_descp)
                    $('#edit_meta_key').val(response['data'][0].meta_key)
                    $('#edit_service_id').val(response['data'][0].id)
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
        var formdata = $('#edit_service_form').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('update-service-data.service') }}",
            data: formdata,
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
                        var table = $('#services-table').DataTable();
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
                    url: "{{ route('delete-data-service.service') }}",
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
                                var table = $('#services-table').DataTable();
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