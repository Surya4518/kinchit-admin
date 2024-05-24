<script>
    $(function() {
        // $('.summernote').summernote()
        $('.summernote').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });

        $('.servicecontentcreate').click(function() {
            $('#service_content_create_modal').modal('show')
        })
        $('.close').click(function() {
            $('#service_content_create_modal').modal('hide')
            $('#service_content_edit_modal').modal('hide')
        })
        $('#service_content_title').keyup(function() {
            if ($('#service_content_title').val() == '') {
                $('#service_content_title_error').text('Please fill the title. *')
            } else {
                $('#service_content_title_error').text('')
            }
        })
        $('#service_content_description').keyup(function() {
            if ($('#service_content_description').val() == '') {
                $('#service_content_description_error').text('Please fill the Content. *')
            } else {
                $('#service_content_description_error').text('')
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
        var currentUrl = window.location.href;
        var segments = currentUrl.split('/');
        var lastSegment = segments[segments.length - 1];
        var existingTable = $('#service-content-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#service-content-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-service-content-list.service') }}",
                method: 'POST',
                data: {
                    id: lastSegment
                },
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
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<textarea readonly>${ $('<div/>').html(row.description).text() }</textarea>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<select class="form-control" name="service_content_status_0${row.id}" id="service_content_status_0${row.id}" onchange="ServiceContentStatusChange(${row.id})">
                                                <option ${ row.status == '0' ? 'selected' : '' } value="0">Active</option>
                                                <option ${ row.status == '1' ? 'selected' : '' } value="1">Inactive</option>
                                            </select>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="javascript:EditServiceContent(${row.id});" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editservicecontent"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteServiceContent(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary deleteservicecontent"><i class="fa fa-trash"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:UploadServiceContentImagesModal(${row.id},${row.service_id});" title="Upload Images" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary uploadservicecontentimagesmodal"><i class="fa fa-arrow-up" aria-hidden="true"></i></a></li>
                         </ul>`;
                    }
                    // <li  style="list-style-type: none;margin-left: 10px;""><a href="javascript:void(0);" onclick="open_vol_modal('${row.user_login}')" title="Swap the members" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary sendrequest"><i class="fa fa-swap-arrows"></i></a></li>
                    // <li  style="list-style-type: none;margin-left: 10px;""><a href="javascript:void(0);" onclick="open_vol_modal('${row.user_login}')" title="Swap the members" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary swapmembers"><i class="fa fa-swap-arrows"></i></a></li>
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

    function CreateServiceContent() {
        if ($('#service_content_title').val() == '') {
            $('#service_content_title_error').text('Please fill the title. *')
            return false;
        }
        if ($('#service_content_description').val() == '') {
            $('#service_content_description_error').text('Please fill the Content. *')
            return false;
        }
        $('#service_content_create_modal').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var currentUrl = window.location.href;
        var segments = currentUrl.split('/');
        var lastSegment = segments[segments.length - 1];
        $('#service_article_id').val(lastSegment)
        var formdata = $('#create_service_content_form').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('create-service-content.service') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#create_service_content_form")[0].reset();
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

    function ServiceContentStatusChange(id) {
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
                    url: "{{ route('service-content-change-status.service') }}",
                    data: {
                        id: id,
                        status: $('#service_content_status_0' + id).val()
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

    function EditServiceContent(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('get-service-content-data.service') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    $('#edit_service_content_title').val(response['data'][0].title)
                    $('#edit_service_content_description').summernote('code', response['data'][0]
                        .description);
                    $('#edit_service_content_id').val(response['data'][0].id)
                    $('#service_content_edit_modal').modal('show')
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

    function UpdateServiceContentData() {
        if ($('#edit_service_content_title').val() == '') {
            $('#edit_service_content_title_error').text('Please fill the title. *')
            return false;
        }
        if ($('#edit_service_content_description').val() == '') {
            $('#edit_service_content_description_error').text('Please fill the Content. *')
            return false;
        }
        $('#service_content_edit_modal').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = $('#edit_service_content_form').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('update-service-content-data.service') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#edit_service_content_form")[0].reset();
                if (response['status'] == 200) {
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: 'Success...!',
                        text: response['message'],
                        timer: 2500,
                          showConfirmButton: false
                    }).then(function() {
                         var table = $('#service-content-table').DataTable();
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

    function DeleteServiceContent(id) {
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
                    url: "{{ route('delete-service-content-data.service') }}",
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
                                var table = $('#service-content-table').DataTable();
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

    function UploadServiceContentImagesModal(content_id, service_id) {
        GetServiceContentImages(service_id, content_id)
        $('#imageupload_service_content_id').val(content_id)
        $('#imageupload_service_article_id').val(service_id)
        $('#service_content_image_upload_modal').modal('show')
    }

    function UploadServiceContentImages() {
        $('#service_content_image_error').text('');
        var inputFiles = $('#service_content_image')[0].files;

        if (inputFiles.length === 0) {
            $('#service_content_image_error').text('Please select at least one image.');
            return;
        }

        var invalidImages = [];

        for (var i = 0; i < inputFiles.length; i++) {
            var inputFile = inputFiles[i];

            if (!inputFile.type.match('image.*')) {
                invalidImages.push(inputFile.name);
            }

            var maxSize = 1 * 1024 * 1024; // 5MB
            if (inputFile.size > maxSize) {
                invalidImages.push(inputFile.name);
            }
        }

        if (invalidImages.length > 0) {
            $('#service_content_image_error').html('Invalid images: ' + invalidImages.join(', ') +
                '<br>Maximum 1MB file size is supported<br>Acceptable image format is jpg, jpeg, png, web only.');
            return false;
        }

        var formdata = new FormData(document.getElementById('service_content_image_upload_form'));
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#service_content_image_upload_modal').modal('hide')

        $.ajax({
            type: 'post',
            url: "{{ route('service-content-image-upload.service') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false, // Important: tell jQuery not to process the data
            contentType: false, // Important: tell jQuery not to set contentType
            success: function(response) {
                $("#service_content_image_upload_form")[0].reset();
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

    function GetServiceContentImages(service_id, content_id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
          var assetUrl = "{{ config('app.asset_url') }}";
        $.ajax({
            type: 'post',
            url: "{{ route('get-service-content-images.service') }}",
            data: {
                service_id: service_id,
                content_id: content_id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    console.log(response['data'].length);
                    var html = ``;
                    for (var i = 0; i < response['data'].length; i++) {
                        html +=
                           `<div class="col-3 text-center"><img src="${assetUrl}/images/${response['data'][i].image}"><i onclick="DeleteServiceContentImage(${response['data'][i].id})" style="cursor: pointer;" class="fa fa-trash"></i></div>`;
                    //console.log(asset('/images/' + response['data'][i].image));
                        
                    }
                    $('.showservicecontentimages').html(html);
                }
                if (response['status'] == 400) {
                    $('.showservicecontentimages').html(
                        '<div class="col-6"><p>There is no images</p></div>')
                }
            },
            error: function(data) {
                console.log('Error:', data);
            }
        })
    }

    function DeleteServiceContentImage(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#service_content_image_upload_modal').modal('hide')
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the image!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-service-content-image.service') }}",
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
                                // GetServiceContentImages(response['service_id'], response['content_id'])
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
                                // GetServiceContentImages(response['service_id'], response['content_id'])
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
