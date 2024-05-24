<script>
    $(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#replies_filter').select2()
        $('#reply_parent_thread_id').select2()
        showlist()
        // $('.summernote').summernote()
        $('.summernote').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
        $('.form-control').on('keyup change', function() {
            $('.validate_errors').text('')
        })

        $('#create-reply').on('click', function() {
            var formdata = $('#create_reply_frm').serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('create-the-reply.reply') }}",
                data: formdata,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response['status'] == 200) {
                        Swal.fire({
                            position: "top-right",
                            icon: "success",
                            title: response['message'],
                            timer: 2500,
                             showConfirmButton: false
                        }).then(function() {
                            window.location.href = "/replies";
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
                        Swal.fire({
                            position: "top-right",
                            icon: "warning",
                            title: response['message'],
                            timer: 2500,
                             showConfirmButton: false
                        }).then(function() {
                            // Your callback logic here
                        });
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            })
        })

        $('#update-reply').on('click', function() {
            var formdata = $('#update_reply_frm').serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('update-the-reply.reply') }}",
                data: formdata,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response['status'] == 200) {
                        Swal.fire({
                            position: "top-right",
                            icon: "success",
                            title: response['message'],
                            timer: 2500,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload()
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
                        Swal.fire({
                            position: "top-right",
                            icon: "warning",
                            title: response['message'],
                            timer: 2500,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload()
                        });
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            })
        })

    })

    function showlist(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        // if(id != undefined){
        //     $('#members_filter').html('<i class="fa fa-spinner fa-spin" style="font-size: larger;margin-left: 10px;"></i>');
        // }
        var existingTable = $('#reply-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#reply-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('show-replies.reply') }}",
                method: 'POST',
                data: {
                    id: id
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
                    data: 'post_title',
                    name: 'post_title'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<textarea readonly>${row.post_name}</textarea>`;
                    }
                },
                {
                    data: 'post_date',
                    name: 'post_date'
                },
                {
                    data: 'post_status',
                    name: 'post_status'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                            <li  style="list-style-type: none;"><a href="/user-profile/edit/${row.post_author}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-user"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="/reply/edit/${row.ID}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheReply(${row.ID});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-trash"></i></a></li>
                         <li style="list-style-type: none; margin-left: 10px;">
                         <a href="javascript:ChangeThePublishStatus(${row.ID}, '${row.post_status === 'publish' ? '1' : '0'}');" title="${row.post_status === 'publish' ? 'Change to pending' : 'Publish It'}" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary">
                         <i class="fa ${row.post_status === 'publish' ? 'fa-eye-slash' : 'fa-eye'}"></i>
                         </a>
                         </ul>`;
                    }
                    // <li  style="list-style-type: none;margin-left: 10px;""><a href="/members/${row.user_login}" target="_blank" title="Show Members" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary showmember"><i class="fa fa-eye"></i></a></li>
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
        });
    }

    function showRepliesList() {
        showlist($('#replies_filter').val());
    }

    function DeleteTheReply(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the reply!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-reply-data.reply') }}",
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
                                icon: "danger",
                                title: response['message'],
                                showConfirmButton: true,
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
            } else {
                consol.log('failed')
            }
        })
    }

    function ChangeThePublishStatus(id, status) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: `You want to Change the thread to ${status == '0' ? 'publish' : 'pending'}!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('change-the-status-of-reply.reply') }}",
                    data: {
                        id: id,
                        status: status
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
                                timer: 2500,
                                showConfirmButton: false
                            }).then(function() {
                                showlist();
                            });
                        } else if (response['status'] == 400) {
                            Swal.fire({
                                position: "top-right",
                                icon: "warning",
                                title: response['message'],
                                showConfirmButton: true,
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
            } else {
                consol.log('failed')
            }
        })
    }
</script>
