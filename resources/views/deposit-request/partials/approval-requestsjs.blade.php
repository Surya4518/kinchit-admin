<script>
    $(function() {
        initializeSelect2InsideModal("#approve_request_modal_volunteer", "#volunteer_request_volunteers");
        initializeSelect2InsideModal("#approve_request_modal_member", "#member_request_volunteers");
        initializeSelect2InsideModal("#approve_request_modal_donor", "#donor_request_volunteers");
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
        var existingTable = $('#approved-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#approved-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('show-deposit-requests.index') }}",
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
                    data: null,
                    render: function(data, type, row) {
                        return row.first_name + ' ' + row.last_name;
                    }
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<ul style="display: flex;">
                <li style="list-style-type: none;margin-left: 10px;""><a href="javascript:Request_modal(${row.id});" title="Approve It" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary is_approve"><i class="fa fa-check"></i></a></li>
                <li style="list-style-type: none;margin-left: 10px;""><a href="javascript:Request_reject_modal(${row.id});" title="Reject It" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary is_reject"><i class="fas fa-times"></i></a></li>
                <a href="/deposit-approve-request-view/${row.id}" style="list-style-type: none;margin-left: 10px;" title="View" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fas fa-eye"></i></a>
            </ul>`;
                    }
                }
            ]
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
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to Approve This Request!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "deposit-approve-status/" + id,
                    data: {
                        id: id,
                        status: 1 // Set the status to 1 (approved)
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                position: "top-right",
                                title: 'Approved',
                                text: response.message,
                                icon: 'success', // 'success' instead of 'Success'
                                // showCancelButton: true,

                            })
                            window.location.href = '/deposit-pending-requests';
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
    }

    function Request_reject_modal(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to Rejected This Request!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "deposit-rejected-status/" + id,
                    data: {
                        id: id,
                        status: 2 // Set the status to 1 (approved)
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                position: "top-right",
                                title: 'Rejected',
                                text: response.message,
                                icon: 'success', // 'success' instead of 'Success'
                                // showCancelButton: true,

                            })
                            window.location.href = '/deposit-pending-requests';
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
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