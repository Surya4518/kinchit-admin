<script>
    $(function() {
        $('.close').click(function() {
            $('.modal').modal('hide')
        })
        $('.select2').select2()
        $('#photo_select').on('change', function() {
            showlist(this.value)
        })
    })

    function showlist(type1) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#photo-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#photo-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-photo-approval-images.pt_approval') }}",
                method: 'POST',
                data: {
                    type: type1
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
                    data: 'MatriID',
                    name: 'MatriID'
                },
                {
                    data: 'Name',
                    name: 'Name'
                },
                {
                    data: 'ConfirmEmail',
                    name: 'ConfirmEmail'
                },
                {
                    data: type1 + 'Approve',
                    name: type1 + 'Approve'
                },
                {
                    data: 'Status',
                    name: 'Status'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;margin-left: 10px;""><a href="javascript:ApproveRequest(${row.ID},'${type1}');" title="Approve It" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary is_approve"><i class="fa fa-check"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;""><a href="javascript:RejectRequest(${row.ID},'${type1}');" title="Reject It" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary is_reject"><i class="fas fa-times"></i></a></li>
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
             createdRow: function(row, data, dataIndex) {
            $(row).attr('id', 'row_' + data.id); // Assuming `data.id` is the unique identifier for each row
            }
        });
    }

    function ApproveRequest(id, type) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to approve it!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('approve-images.pt_approval') }}",
                    data: {
                        id: id,
                        type: type
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
                                 var table = $('#photo-table').DataTable();
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
            } else {}
        })
    }

    function RejectRequest(id, type) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to approve it!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('reject-images.pt_approval') }}",
                    data: {
                        id: id,
                        type: type
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
                                 var table = $('#photo-table').DataTable();
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
            } else {}
        })
    }
</script>
