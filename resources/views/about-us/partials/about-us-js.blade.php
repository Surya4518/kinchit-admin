<script>
    $(function() {
        $('.articlecreatemodal').click(function() {
            $('#service_artical_create_modal').modal('show')
        })
        $('.close').click(function() {
            $('#service_artical_create_modal').modal('hide')
            $('#service_artical_edit_modal').modal('hide')
        })
        $('.summernote').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
        $('#title').keyup(function() {
            if ($('#title').val() == '') {
                $('#title_error').text('Please fill the title. *')
            } else {
                $('#title_error').text('')
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
        var existingTable = $('#about-us-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#about-us-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-about-us.about-us') }}",
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
                        return `<select class="form-control" name="service_status${row.id}" id="service_status${row.id}" onchange="AboutUsStatusChange(${row.id})">
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
                               <li style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheAboutUs(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary deleteservices"><i class="fa fa-trash"></i></a></li>
                           </ul>`;
                   }
                    
                }
            ],
             createdRow: function(row, data, dataIndex) {
            $(row).attr('id', 'row_' + data.id); // Assuming `data.id` is the unique identifier for each row
            }
        });
    }

    function CreateAboutUs() {
    if ($('#title').val() == '') {
        $('#title_error').text('Please fill the title. *');
        return false;
    }
    if ($('#content').val() == '') {
        $('#content_error').text('Please fill the content. *');
        return false;
    }
    if ($('#status').val() == '') {
        $('#status_error').text('Please fill the status. *');
        return false;
    } 
    if ($('#video_content').val() == '') {
        $('#video_content_error').text('Please fill the video content. *');
        return false;
    } 
    if ($('#shord_order').val() == '') {
        $('#shord_order_error').text('Please fill the video shord order. *');
        return false;
    }
    $('#service_artical_create_modal').modal('hide');
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var formData = new FormData($('#create_service_form')[0]);
    $.ajax({
        type: 'post',
        url: "{{ route('create-about-us.about-us') }}",
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


    function AboutUsStatusChange(id) {
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
                    url: "{{ route('about-us-change-status.about-us') }}",
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
            url: "{{ route('get-about-us-data.about-us') }}",
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
                    // $('#edit_content').val(response['data'][0].content)
                    $('#edit_content').summernote('code', response['data'][0].content)
                    $('#edit_status').val(response['data'][0].status)
                    $('#edit_shord_order').val(response['data'][0].shord_order)
                    $('#edit_service_id').val(response['data'][0].id)
                    $('#edit_video_content').val(response['data'][0].iframe_url)
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

    function UpdateTheDataOfAboutUs() {
        if ($('#edit_title').val() == '') {
        $('#edit_title_error').text('Please fill the title. *');
        return false;
    }
    if ($('#edit_content').val() == '') {
        $('#edit_content_error').text('Please fill the content. *');
        return false;
    }
    if ($('#edit_status').val() == '') {
        $('#edit_status_error').text('Please fill the status. *');
        return false;
    } 
    if ($('#edit_video_content').val() == '') {
        $('#edit_video_content_error').text('Please fill the video content. *');
        return false;
    } 
    if ($('#edit_shord_order').val() == '') {
        $('#edit_shord_order_error').text('Please fill the video shord order. *');
        return false;
    }

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var formData = new FormData($('#edit_service_form')[0]);
    $.ajax({
        type: 'post',
        url: "{{ route('update-about-us-data.about-us') }}",
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
                    var table = $('#about-us-table').DataTable();
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


    function DeleteTheAboutUs(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the About Us!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-data-about-us.about-us') }}",
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
                                var table = $('#about-us-table').DataTable();
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