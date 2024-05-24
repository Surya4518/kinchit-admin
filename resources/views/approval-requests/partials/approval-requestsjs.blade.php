<script>
    $(function() {
        initializeSelect2InsideModal("#approve_request_modal_volunteer", "#volunteer_request_volunteers");
        initializeSelect2InsideModal("#approve_request_modal_member", "#member_request_volunteers");
        initializeSelect2InsideModal("#approve_request_modal_donor", "#donor_request_volunteers");
        initializeSelect2InsideModal("#request_approve_modal_volunteer_member", "#member_request_members");
        showlist()
        $('.close').click(function() {
            $('.modal').modal('hide')
        })
        $('.select2').select2()
        $('#request_filter').on('change', function() {
            showlist(this.value)
        })
    })

    function showlist(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#request-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#request-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('show-requests.index') }}",
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
                    data: 'from_id',
                    name: 'from_id'
                },
                {
                    data: 'to_id',
                    name: 'to_id'
                },
                {
                    data: 'request',
                    name: 'request'
                },
                {
                    data: 'request_reason',
                    name: 'request_reason'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;margin-left: 10px;""><a href="javascript:Request_modal(${row.id});" title="Approve It" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary is_approve"><i class="fa fa-check"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;""><a href="javascript:Request_reject_modal(${row.id});" title="Reject It" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary is_reject"><i class="fas fa-times"></i></a></li>
                          <a href="/approve-request-view/${row.id}" style="list-style-type: none;margin-left: 10px;"" title="View" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fas fa-eye"></i></a>
                         </ul>`;
                        //  <li  style="list-style-type: none;"><a href="javascript:void(0);" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editvolunteer"><i class="fa fa-edit"></i></a></li>
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
    }

    function Request_modal(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "{{ route('get-requests.index') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['id'] == 1) {
                    $('#volunteer_request_from_user_id').val(response['from_user'])
                    $('#approval_request_id').val(id)
                    $('#approve_request_modal_volunteer').modal('show')
                }
                if (response['id'] == 2) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('inactive-user.post') }}",
                        data: {
                            user_id: response['from_user'],
                            type: 'requested',
                            approval_request_id: id
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
                                    timer: 2500,
                                }).then(function() {
                                    showlist()
                                });
                            }
                            if (response['status'] == 400) {
                                Swal.fire({
                                    title: 'Warning!',
                                    text: response['message'],
                                    icon: 'warning',
                                    showConfirmButton: false,
                                    timer: 5000
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
                if (response['id'] == 3) {
                    $('#member_request_from_user_id').val(response['from_user'])
                    $('#member_request_old_volunteer_id').val(response['old_volunteer'])
                    $('#approval_request_id').val(id)
                    $('#approve_request_modal_member').modal('show')
                }
                if (response['id'] == 4) {
                    $('#donor_request_from_user_id').val(response['from_user'])
                    $('#approval_request_id').val(id)
                    $('#approve_request_modal_donor').modal('show')
                }
                if (response['id'] == 5) {
                    // alert('apply')
                    $.ajax({
                        type: "POST",
                        url: "{{ route('approve-to-be-volunteer.post') }}",
                        data: {
                            user_id: response['from_id'],
                            type: 'requested',
                            approval_request_id: id
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
                                    title: 'Warning!',
                                    text: response['message'],
                                    icon: 'warning',
                                    showConfirmButton: false,
                                    timer: 5000
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
                if (response['id'] == 6) {
                    
                    if (response['assigned_volunteer'] != '') {
                        $('#vol_member_request_from_user_id').val(response['to_id'])
                        $('#member_request_members').empty();
                        $('#member_request_members').append($('<option>', {
                            value: response['assigned_volunteer'],
                            text: response['assigned_volunteer']
                        }));
                    }else{
                        $('#vol_member_request_from_user_id').val(response['from_user'])
                    }
                    $('#approval_request_id').val(id)
                    $('#request_approve_modal_volunteer_member').modal('show')
                }
            },
            error: function(data) {

                console.log('Error:', data);
            }
        });
    }

    function Request_reject_modal(id) {
        $('#approval_request_id').val(id)
        $('#reject_request_modal').modal('show')
    }

    function ChangeMembersToAnotherVolunteer() {
        if ($('#volunteer_request_volunteers').val() == '') {
            $('#volunteer_request_volunteers_error').text('Please select volunteer. *')
            return false;
        }
        $('#approve_request_modal_volunteer').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to change your members to another volunteer!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('one-to-another.post') }}",
                    data: {
                        from_vol: $('#volunteer_request_from_user_id').val(),
                        to_vol: $('#volunteer_request_volunteers').val(),
                        type: 'requested',
                        approval_request_id: $('#approval_request_id').val()
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
            } else {
            }
        })
    }

    function ChangeVolunteerForMember() {
        if ($('#member_request_volunteers').val() == '') {
            $('#member_request_volunteers_error').text('Please select volunteer. *')
            return false;
        }
        $('#approve_request_modal_member').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to change your volunteer!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('change-volunteer.post') }}",
                    data: {
                        user_id: $('#member_request_from_user_id').val(),
                        new_vol: $('#member_request_volunteers').val(),
                        type: 'requested',
                        approval_request_id: $('#approval_request_id').val()
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
            } else {
                console.log('Not Confirmed');
            }
        })
    }

    function ChangeDonorToMember() {
        // alert($('#approval_request_id').val()+'----'+$('#donor_request_volunteers').val())
        if ($('#donor_request_volunteers').val() == '') {
            $('#donor_request_volunteers_error').text('Please select volunteer. *')
            return false;
        }
        $('#approve_request_modal_donor').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to change this user as a member under the selected volunteer!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('Change-to-member.post') }}",
                    data: {
                        user_id: $('#donor_request_from_user_id').val(),
                        vol_id: $('#donor_request_volunteers').val(),
                        type: 'requested',
                        approval_request_id: $('#approval_request_id').val()
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
            } else {
                console.log('Not Confirmed');
            }
        })
    }

    function RejectRequestApproval() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#reject_request_modal').modal('hide')
        $.ajax({
            type: "POST",
            url: "{{ route('reject-request.post') }}",
            data: {
                reason: $('#request_reject_reason').val(),
                approval_request_id: $('#approval_request_id').val()
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
    }

    function ChangeMembersToAnotherMember() {
        if ($('#member_request_members').val() == '') {
            $('#member_request_members_error').text('Please select volunteer. *')
            return false;
        }
        $('#request_approve_modal_volunteer_member').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to change your members to another Member!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('one-to-another-member.post') }}",
                    data: {
                        user_name: $('#vol_member_request_from_user_id').val(),
                        volunteer: $('#member_request_members').val(),
                        type: 'requested',
                        approval_request_id: $('#approval_request_id').val()
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
            } else {
            }
        })
    }


    function initializeSelect2InsideModal(modalId, selectId) {
        $(document).ready(function() {
            $(selectId).select2({
                placeholder: "00000",
                dropdownParent: $(modalId)
            });
        });
    }
function goBack() {
    window.history.back();
}
</script>
