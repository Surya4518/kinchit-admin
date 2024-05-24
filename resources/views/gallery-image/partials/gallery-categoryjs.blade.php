<script>
    $(function() {
        $('.gallerycreatemodal').click(function() {
            $('#gallery_create_modal').modal('show')
        })
        $('.close').click(function() {
            $('#gallery_create_modal').modal('hide')
            $('#tutorial_category_edit_modal').modal('hide')
        })
        $('#gallery_title').keyup(function() {
            if ($('#gallery_title').val() == '') {
                $('#gallery_title_error').text('Please fill the title. *')
            } else {
                $('#gallery_title_error').text('')
            }
        })
        $('#edit_gallery_title').keyup(function() {
            if ($('#edit_gallery_title').val() == '') {
                $('#edit_gallery_title_error').text('Please fill the title. *')
            } else {
                $('#edit_gallery_title_error').text('')
            }
        })
        showlist()
    })

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#gallery-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#gallery-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-gallery-image-list.gallery-image') }}",
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
                    data: 'sort_order',
                    name: 'sort_order'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<select class="form-control" name="status_es${row.id}" id="status_es${row.id}" onchange="Status_es_Change(${row.id})">
                                    <option ${row.status === 'Active' ? 'selected' : ''} value="Active">Active</option>
                                    <option ${row.status === 'Inactive' ? 'selected' : ''} value="Inactive">Inactive</option>
                                </select>`;
                    }
                },

                {
                    data: null,
                    render: function(data, type, row) {
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="javascript:EditGalleryCategory(${row.id});" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editdonation"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheGalleryImage(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary deletedonation"><i class="fa fa-trash"></i></a></li>
                         </ul>`;
                    }

                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).attr('id', 'row_' + data.id); // Assuming `data.id` is the unique identifier for each row
            }
        });
    }

    function CreateGalleryImage() {
        if ($('#gallery_category_title').val() == '') {
            $('#gallery_category_error').text('Please fill the title. *')
            return false;
        }
        $('#gallery_create_modal').modal('hide');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formData = new FormData();
        formData.append('upload_image', $('#upload_image')[0].files[0]);
        formData.append('category_name', $('#category_name').val());
        formData.append('tittle', $('#tittle').val());
        formData.append('short_order', $('#short_order').val());
        formData.append('status', $('#status').val());
        formData.append('description', $('#description').val());
        $.ajax({
            type: 'post',
            url: "{{ route('create-gallery-image.gallery-image') }}",
            data: formData,
            contentType: false, // Avoid auto-setting content type
            processData: false, // Prevent processing data
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#create_gallery_category_form")[0].reset();
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
                    url: "{{ route('service-change-status.service') }}",
                    data: {
                        id: id,
                        status: $('#service_status_0' + id).val()
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

    function EditGalleryCategory(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('get-gallery-image-data.gallery-image') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#edit_gallery_category_form")[0].reset();
                if (response['status'] == 200) {
                    $('#edit_gallery_category_id').val(response['data'][0].id)
                    var categoryName = response['data'][0].category_name;
                    $('#edit_category_name option').each(function() {
                        if ($(this).text() === categoryName) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('#edit_status').val(response['data'][0].status)
                    $('#edit_short_order').val(response['data'][0].sort_order)
                    $('#edit_tittle').val(response['data'][0].title)
                    $('#edit_description').val(response['data'][0].description)
                    $('#edit_image').attr('src', response['data'][0].image);
                    $('#gallery_category_edit_modal').modal('show')
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

    function UpdateTheDataOfGalleryImage() {
        if ($('#edit_gallery_category_title').val() == '') {
            $('#edit_gallery_category_title_error').text('Please fill the title. *')
            return false;
        }

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formData = new FormData();
        formData.append('edit_gallery_category_id', $('#edit_gallery_category_id').val());

        var fileInput = $('#edit_upload_image')[0];
        if (fileInput.files.length > 0) {
            formData.append('upload_image', fileInput.files[0]);
        }
        formData.append('edit_category_name', $('#edit_category_name').val());
        formData.append('edit_tittle', $('#edit_tittle').val());
        formData.append('edit_short_order', $('#edit_short_order').val());
        formData.append('edit_status', $('#edit_status').val());
        formData.append('edit_description', $('#edit_description').val());
        $.ajax({
            type: 'post',
            url: "{{ route('update-gallery-image-data.gallery-image') }}",
            data: formData, // Use formData instead of formdata
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {

                if (response['status'] == 200) {
                    $('#gallery_category_edit_modal').modal('hide')
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: 'Success...!',
                        text: response['message'],
                        timer: 2500,
                        showConfirmButton: false
                    }).then(function() {
                        var table = $('#gallery-table').DataTable();
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
                    $('#gallery_category_edit_modal').modal('hide')
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

    function DeleteTheGalleryImage(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the Gallery Image!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-gallery-image-data.image') }}",
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
                                var table = $('#gallery-table').DataTable();
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
                    url: "{{ route('change-gallery-image-status.image') }}",
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
                                var table = $('#gallery-table').DataTable();
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
</script>