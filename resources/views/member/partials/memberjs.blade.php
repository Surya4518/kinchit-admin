<script>
    $(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#member_filter').select2()
        showlist()
        $('.close').click(function(){
            $('#send_request_modal').modal('hide')
        })
        $('#request_types').select2({
            ajax: {
                url: "{{ route('get-requesttypes.index') }}",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dataType: 'json',
                delay: 400,
                data: function(params) {
                    // Merge your formDataObject with the Select2 request parameters
                    return {
                        search: params.term,
                        user: $('#for_user_id').val(),
                    };
                },
                processResults: function(response) {
                    const data = response.data;
                    //  console.log(data.length);
                    if (data.length == 0) {
                        return {
                            results: []
                        };
                    }
                    if (data.length > 0) {
                        console.log(data.length);
                        const formattedData = data.map(item => ({
                            id: item.id,
                            text: item.request_type
                        }));
                        return {
                            results: formattedData
                        };
                    }
                },
                cache: true
            }
        });
    })

    function showlist(id, status) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        // if(id != undefined){
        //     $('#members_filter').html('<i class="fa fa-spinner fa-spin" style="font-size: larger;margin-left: 10px;"></i>');
        // }
        var existingTable = $('#mem-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#mem-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('show-member.index') }}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
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
                    data: 'parent',
                    name: 'parent'
                },
                {
                    data: 'user_login',
                    name: 'user_login'
                },
                {
                    data: 'display_name',
                    name: 'display_name'
                },
                {
                    data: 'user_email',
                    name: 'user_email'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<select class="form-control" name="memberstatus${row.ID}" id="memberstatus${row.ID}" onchange="MemberStatusChange(${row.ID})">
                                                <option ${ row.user_status == '0' ? 'selected' : '' } value="0">Active</option>
                                                <option ${ row.user_status == '1' ? 'selected' : '' } value="1">Inactive</option>
                                            </select>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="/user-profile/edit/${row.ID}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editvolunteer"><i class="fa fa-edit"></i></a></li>
                         </ul>`;
                        //  <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:void(0);" onclick="open_vol_modal('${row.user_login}')" title="Change the volunteer" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary changevolunteer"><i class="fa fa-swap-arrows"></i></a></li>
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
        // $('#members_filter').html('')
    }

    function showmemberlist() {
        showlist($('#member_filter').val(), $('#member_status_filter').val());
    }

    function MemberStatusChange(id) {
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
                    url: "{{ route('status-member.index') }}",
                    data: {
                        id: id,
                        status: $('#memberstatus' + id).val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response['status'] == 200) {
                            Swal.fire({
                                position: "top-right",
                                icon: "success",
                                title: response['message'],
                                showConfirmButton: false,
                                timer: 2500
                            }).then(function() {
                                showlist($('#member_filter').val(), $('#member_status_filter').val())
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
                                showlist($('#member_filter').val(), $('#member_status_filter').val())
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

    function open_vol_modal(usr){
        $('#for_user_id').val(usr)
        $('#send_request_modal').modal('show')
    }

    function SendRequest() {
        if ($('#request_types').val() == '') {
            $('#request_types_error').text('Please select request type. *')
            return false;
        }
        $('#send_request_modal').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "{{ route('approval-request.store') }}",
            data: {
                from_user: $('#for_user_id').val(),
                request_type: $('#request_types').val(),
                reason: $('#approval_request_reason').val()
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: response['message'],
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

    }

    // function ChangeMembersToAnotherVolunteer() {
    //     if($('#volunteer_filter_forchange').val() == ''){
    //         $('#volunteer_filter_forchange_error').text('Please select volunteer. *')
    //         return false;
    //     }
    //     $('#send_request_modal').modal('hide')
    //     var csrfToken = $('meta[name="csrf-token"]').attr('content');
    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: 'You want to change your volunteer!',
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: 'Yes!',
    //         cancelButtonText: 'No',
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 type: "POST",
    //                 url: "{{ route('one-to-another.post') }}",
    //                 data: {
    //                     from_vol: $('#for_change_volunteer_id').val(),
    //                     to_vol: $('#volunteer_filter_forchange').val()
    //                 },
    //                 headers: {
    //                     'X-CSRF-TOKEN': csrfToken
    //                 },
    //                 success: function(response) {
    //                     if (response['status'] == 200) {
    //                         Swal.fire({
    //                             position: "top-right",
    //                             icon: "success",
    //                             title: response['message'],
    //                             showConfirmButton: true,
    //                             timer: 2500
    //                         }).then(function() {
    //                             showlist()
    //                         });
    //                     }
    //                     if (response['status'] == 400) {
    //                         Swal.fire({
    //                             position: "top-right",
    //                             icon: "danger",
    //                             title: response['message'],
    //                             showConfirmButton: true,
    //                             timer: 2500
    //                         }).then(function() {
    //                             showlist()
    //                         });
    //                     }
    //                 },
    //                 error: function(data) {
    //
    //                     console.log('Error:', data);
    //                 }
    //             });
    //         } else {
    //             $
    //         }
    //     })
    // }
function goBack() {
    window.history.back();
}

</script>
