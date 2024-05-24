<script>
    $(function() {
        showlist()
    })

    function showlist() {
        var currentUrl = window.location.href;
            var urlParts = currentUrl.split('/');
            var lastPart = urlParts[urlParts.length - 1];
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#mem-bel-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#mem-bel-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('show-bel-member-post.index') }}",
                method: 'POST',
                data: {
                    id: lastPart
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
                        return `<ul>
                         <li  style="list-style-type: none;"><a href="/user-profile/edit/${row.ID}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editvolunteer"><i class="fa fa-edit"></i></a></li>
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
        });
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
                $
            }
        })
    }

</script>
