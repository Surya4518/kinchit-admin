<script>
    $(function() {
        $('.spec_contentcreatemodal').click(function() {
            $('#special_content_create_modal').modal('show')
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
        
        $('#spe_category').on('change', function(){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('get-special-programme-category.sp_cat') }}",
            data: {
                id: $(this).val()
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    $('#category_type').val(response['data'][0].type)
                    var html = ``;
                    html += `<div class="md-form mb-5"><label for="">Title : </label>
                <input type="text" class="form-control" name="spec_content_title" id="spec_content_title">
                <p class="validate_errors" id="spec_content_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p></div>`;
                    if(response['data'][0].type == 'audio'){
                        html += `<div class="md-form mb-5"><label for="">Upload Audio : </label>
                <input type="file" accept=".mp3,.ogg,.wav" class="form-control" name="spec_content_audio" id="spec_content_audio">
                <p class="validate_errors" id="spec_content_audio_error" style="color: red;font-size: 12px;margin-left: 2px;"></p></div>`;
                    }else if(response['data'][0].type == 'video'){
                        html += `<div class="md-form mb-5"><label for="">Upload Video : </label>
                <textarea class="form-control summernote" name="spec_content_video" id="spec_content_video"></textarea>
                <p class="validate_errors" id="spec_content_video_error" style="color: red;font-size: 12px;margin-left: 2px;"></p></div>`;
                    }else{
                        html += `<div class="md-form mb-5"><label for="">Upload Content : </label>
                <textarea class="form-control summernote" name="spec_content_content" id="spec_content_content"></textarea>
                <p class="validate_errors" id="spec_content_content_error" style="color: red;font-size: 12px;margin-left: 2px;"></p></div>`;
                    }
                    html += `<div class="md-form mb-5">
                <label for="">Status : </label>
                <select class="form-control" name="spec_content_status" id="spec_content_status">
                    <option value="">Select Type</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <p class="validate_errors" id="spec_content_status_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Sort Order : </label>
                <input type="number" class="form-control" placeholder="Enter the sort order" name="spec_content_sort" id="spec_content_sort">
                <p class="validate_errors" id="spec_content_sort_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>`;
                    $(".want_change").html(html)
                    $('.summernote').summernote({
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['fontsize', ['fontsize']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['height', ['height']]
                        ]
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
        })
        
        $('#edit_spe_category').on('change', function(){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('get-special-programme-category.sp_cat') }}",
            data: {
                id: $(this).val()
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    $('#edit_category_type').val(response['data'][0].type)
                    var html = ``;
                    html += `<div class="md-form mb-5"><label for="">Title : </label>
                <input type="text" class="form-control" name="edit_spec_content_title" id="edit_spec_content_title">
                <p class="validate_errors" id="edit_spec_content_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p></div>`;
                    if(response['data'][0].type == 'audio'){
                        html += `<div class="md-form mb-5"><label for="">Upload Audio : </label>
                <input type="file" accept=".mp3,.ogg,.wav" class="form-control" name="edit_spec_content_audio" id="edit_spec_content_audio">
                <p class="validate_errors" id="edit_spec_content_audio_error" style="color: red;font-size: 12px;margin-left: 2px;"></p></div>`;
                    }else if(response['data'][0].type == 'video'){
                        html += `<div class="md-form mb-5"><label for="">Upload Video : </label>
                <textarea class="form-control summernote" name="edit_spec_content_video" id="edit_spec_content_video"></textarea>
                <p class="validate_errors" id="edit_spec_content_video_error" style="color: red;font-size: 12px;margin-left: 2px;"></p></div>`;
                    }else{
                        html += `<div class="md-form mb-5"><label for="">Upload Content : </label>
                <textarea class="form-control summernote" name="edit_spec_content_content" id="edit_spec_content_content"></textarea>
                <p class="validate_errors" id="edit_spec_content_content_error" style="color: red;font-size: 12px;margin-left: 2px;"></p></div>`;
                    }
                    html += `<div class="md-form mb-5">
                <label for="">Status : </label>
                <select class="form-control" name="edit_spec_content_status" id="edit_spec_content_status">
                    <option value="">Select Type</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <p class="validate_errors" id="edit_spec_content_status_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Sort Order : </label>
                <input type="number" class="form-control" placeholder="Enter the sort order" name="edit_spec_content_sort" id="edit_spec_content_sort">
                <p class="validate_errors" id="edit_spec_content_sort_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>`;
                    $(".want_change_edit").html(html)
                    $('.summernote').summernote({
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['fontsize', ['fontsize']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['height', ['height']]
                        ]
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
        })
        
    })
    
    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#specontent-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#specontent-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-special-programme-contents-list.sp_content') }}",
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
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'type',
                    name: 'type'
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
                                                <option ${ row.status == 'InActive' ? 'selected' : '' } value="InActive">Inactive</option>
                                            </select>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="javascript:EditContent(${row.id});" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary edittutcategory"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheContent(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary deletetutcategory"><i class="fa fa-trash"></i></a></li>
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
    
    function CreateContent() {
        if ($('#spe_category').val() == '') {
            $('#spe_category_error').text('Please select category. *')
            return false;
        }
        if ($('#spec_content_title').val() == '') {
            $('#spec_content_title_error').text('Please enter title. *')
            return false;
        }
        if($('#category_type').val() == 'audio'){
        if ($('#spec_content_audio').get(0).files.length === 0) {
            $('#spec_content_audio_error').text('Please select image. *')
            return false;
        }
        }
        if($('#category_type').val() == 'video'){
            if ($('#spec_content_video').val() == '') {
            $('#spec_content_video_error').text('Please enter video frame. *')
            return false;
        }
        }
        if($('#category_type').val() == 'content'){
            if ($('#spec_content_content').val() == '') {
            $('#spec_content_content_error').text('Please enter your page content. *')
            return false;
        }
        }
        if ($('#spec_content_status').val() == '') {
            $('#spec_content_status_error').text('Please select status. *')
            return false;
        }
        if ($('#spec_content_sort').val() == '') {
            $('#spec_content_sort_error').text('Please enter sort order. *')
            return false;
        }
        $('#special_content_create_modal').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = new FormData($('#create_special_Content_form')[0]);
        $.ajax({
            type: 'post',
            url: "{{ route('create-special-programme-content.sp_content') }}",
            data: formdata,
            processData: false,  // Important! Prevents jQuery from automatically transforming the data into a query string
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#create_special_Content_form")[0].reset();
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
    
    function EditContent(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('get-special-programme-content.sp_content') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#edit_special_Content_form")[0].reset();
                if (response['status'] == 200) {
                    var data = response.data[0];
                $('#edit_spe_category').val(data.category_id);
                $('#edit_content_id').val(data.id)
                $('#edit_category_type').val(data.type)
                var html = `
                    <div class="md-form mb-5">
                        <label for="">Title : </label>
                        <input type="text" class="form-control" name="edit_spec_content_title" value="${data.title}" id="edit_spec_content_title">
                        <p class="validate_errors" id="edit_spec_content_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                    </div>`;

                if (data.type == 'audio') {
                    html += `
                        <div class="md-form mb-5">
                            <label for="">Upload Audio : </label>
                            <input type="file" accept=".mp3,.ogg,.wav" class="form-control" name="edit_spec_content_audio" id="edit_spec_content_audio">
                            <audio autoplay controls>
                                <source src="http://kinchit-admin.senthil.in.net/public/${data.content}">
                            </audio>
                            <p class="validate_errors" id="edit_spec_content_audio_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                        </div>`;
                }
                if (data.type == 'video') {
                    html += `
                        <div class="md-form mb-5">
                            <label for="">Upload Video : </label>
                            <textarea class="form-control summernote" name="edit_spec_content_video" id="edit_spec_content_video">${data.content}</textarea>
                            <p class="validate_errors" id="edit_spec_content_video_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                        </div>`;
                } 
                if (data.type == 'content') {
                    html += `
                        <div class="md-form mb-5">
                            <label for="">Upload Content : </label>
                            <textarea class="form-control summernote" name="edit_spec_content_content" id="edit_spec_content_content">${data.content}</textarea>
                            <p class="validate_errors" id="edit_spec_content_content_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                        </div>`;
                }

                html += `
                    <div class="md-form mb-5">
                        <label for="">Status : </label>
                        <select class="form-control" name="edit_spec_content_status" id="edit_spec_content_status">
                            <option value="">Select Type</option>
                            <option ${data.status == 'Active' ? 'selected' : ''} value="Active">Active</option>
                            <option ${data.status == 'Inactive' ? 'selected' : ''} value="Inactive">Inactive</option>
                        </select>
                        <p class="validate_errors" id="edit_spec_content_status_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                    </div>
                    <div class="md-form mb-5">
                        <label for="">Sort Order : </label>
                        <input type="number" class="form-control" placeholder="Enter the sort order" value="${data.sort_order}" name="edit_spec_content_sort" id="edit_spec_content_sort">
                        <p class="validate_errors" id="edit_spec_content_sort_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                    </div>`;

                $(".want_change_edit").html(html);
                $('.summernote').summernote({
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['fontsize', ['fontsize']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]
                    ]
                });
                $('#special_content_edit_modal').modal('show');
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
    
    function UpdateContent() {
        if ($('#edit_spe_category').val() == '') {
            $('#edit_spe_category_error').text('Please select category. *')
            return false;
        }
        if ($('#edit_spec_content_title').val() == '') {
            $('#edit_spec_content_title_error').text('Please enter title. *')
            return false;
        }
        if($('#edit_category_type').val() == 'audio'){
        if ($('#edit_spec_content_audio').get(0).files.length === 0) {
            $('#edit_spec_content_audio_error').text('Please select image. *')
            return false;
        }
        }
        if($('#edit_category_type').val() == 'video'){
            if ($('#edit_spec_content_video').val() == '') {
            $('#edit_spec_content_video_error').text('Please enter video frame. *')
            return false;
        }
        }
        if($('#edit_category_type').val() == 'content'){
            if ($('#edit_spec_content_content').val() == '') {
            $('#edit_spec_content_content_error').text('Please enter your page content. *')
            return false;
        }
        }
        if ($('#edit_spec_content_status').val() == '') {
            $('#edit_spec_content_status_error').text('Please select status. *')
            return false;
        }
        if ($('#edit_spec_content_sort').val() == '') {
            $('#edit_spec_content_sort_error').text('Please enter sort order. *')
            return false;
        }
        $('#special_content_edit_modal').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = new FormData($('#edit_special_Content_form')[0]);
        $.ajax({
            type: 'post',
            url: "{{ route('update-special-programme-content.sp_content') }}",
            data: formdata,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#edit_special_Content_form")[0].reset();
                if (response['status'] == 200) {
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: 'Success...!',
                        text: response['message'],
                        timer: 2500,
                          showConfirmButton: false
                    }).then(function() {
                        var table = $('#specontent-table').DataTable();
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
            url: "{{ route('update-special-programme-content-sort.sp_content') }}",
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
                    url: "{{ route('update-special-programme-content-status.sp_content') }}",
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
    
    function DeleteTheContent(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the content!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-special-programme-content-status.sp_content') }}",
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
                                var table = $('#specontent-table').DataTable();
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