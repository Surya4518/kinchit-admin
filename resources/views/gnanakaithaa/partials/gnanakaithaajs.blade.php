<script>
    $(function() {
        showlist()
        $('.close').click(function() {
            $('.modal').modal('hide')
        })
        $('.select2').select2()
    })

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#gnanakaitha-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#gnanakaitha-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-gnanakaitha-requests.gnanakaitha') }}",
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
                    data: 'name_of_student',
                    name: 'name_of_student'
                },
                {
                    data: 'contact_no',
                    name: 'contact_no'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'volunteer_contact_number',
                    name: 'volunteer_contact_number'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="/gnanakaithaa/${row.id}" title="${row.is_approved != '0' ? 'Verify It' : 'Verified'}" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary is_verified"><i class="fa fa-eye"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:ApproveTheRequest(${row.id});" title="Approve It" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary is_approve"><i class="fa fa-check"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:Request_reject_modal(${row.id});" title="Reject It" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary is_reject"><i class="fas fa-times"></i></a></li>
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

    function Request_reject_modal(id) {
        $('#request_id').val(id)
        $('#reject_request_modal').modal('show')
    }

    function VerifyRequest(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to verify the request!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('verify-gnanakaitha-request.gnanakaitha') }}",
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
                                title: 'Success..!',
                                text: response['message'],
                                showConfirmButton: false,
                                timer: 2500
                            }).then(function() {
                                window.location.href = '/gnanakaitha';
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
                                location.reload()
                            });
                        }
                    },
                    error: function(data) {

                        console.log('Error:', data);
                    }
                });
            } else {}
        })
    }

    function ApproveTheRequest(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "{{ route('approve-gnanakaitha-request.gnanakaitha') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    if (response['is_approved'] == '1') {
                        Swal.fire({
                            position: "top-right",
                            icon: "success",
                            title: 'Success..!',
                            text: response['message'],
                            showConfirmButton: false,
                            timer: 2500
                        }).then(function() {
                            showlist()
                        });
                    }
                    if (response['is_approved'] == '0') {
                        Swal.fire({
                            icon: "warning",
                            title: 'warning..!',
                            text: response['message'],
                            showConfirmButton: true,
                            showCancelButton: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/gnanakaithaa/' + id;
                            } else {
                                showlist()
                            }
                        })
                    }
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
        })
    }

    function RejectTheRequest() {
        if ($('#request_reject_reason').val() == '') {
            $('#request_reject_reason_error').text('Please give the reason to reject. *')
            return false;
        }
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#reject_request_modal').modal('hide')
        $.ajax({
            type: "POST",
            url: "{{ route('reject-gnanakaitha-request.gnanakaitha') }}",
            data: {
                reason: $('#request_reject_reason').val(),
                id: $('#request_id').val()
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
               function goBack() {
    window.history.back();
}
</script>
