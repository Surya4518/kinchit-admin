<script>
    $(function() {
        $('.donationcreatemodal').click(function() {
            $('#donation_create_modal').modal('show')
        })
        $('.close').click(function() {
            $('#donation_create_modal').modal('hide')
            $('#donation_edit_modal').modal('hide')
        })
        $('#donation_title').keyup(function() {
            if ($('#donation_title').val() == '') {
                $('#donation_title_error').text('Please fill the title. *')
            } else {
                $('#donation_title_error').text('')
            }
        })
        $('#edit_donation_title').keyup(function() {
            if ($('#edit_donation_title').val() == '') {
                $('#edit_donation_title_error').text('Please fill the title. *')
            } else {
                $('#edit_donation_title_error').text('')
            }
        })
        showlist()
    })

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#donation-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#donation-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-donation-list.donation') }}",
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
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="javascript:EditDonation(${row.id});" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editdonation"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheDonation(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary deletedonation"><i class="fa fa-trash"></i></a></li>
                         </ul>`;
                    }
                    
                }
            ],
             createdRow: function(row, data, dataIndex) {
            $(row).attr('id', 'row_' + data.id); // Assuming `data.id` is the unique identifier for each row
            }
        });
    }

    function CreateDonation() {
        if ($('#donation_title').val() == '') {
            $('#donation_title_error').text('Please fill the title. *')
            return false;
        }
        $('#donation_create_modal').modal('hide')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = $('#create_donation_form').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('create-donation.donation') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#create_donation_form")[0].reset();
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
        })
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

    function EditDonation(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('get-donation-data.donation') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $("#edit_donation_form")[0].reset();
                if (response['status'] == 200) {
                    $('#edit_donation_id').val(response['data'][0].id)
                    $('#edit_category_name').val(response['data'][0].category_name)
                    $('#edit_amount').val(response['data'][0].amount)
                    $('#edit_status').val(response['data'][0].status)
                    $('#edit_short_order').val(response['data'][0].short_order)
                  
                    $('#donation_edit_modal').modal('show')
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

    function UpdateTheDataOfDonation() {
        if ($('#edit_donation_title').val() == '') {
            $('#edit_donation_title_error').text('Please fill the title. *')
            return false;
        }
        
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = $('#edit_donation_form').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('update-donation-data.donation') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                
                if (response['status'] == 200) {
              $('#donation_edit_modal').modal('hide')
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: 'Success...!',
                        text: response['message'],
                        timer: 2500,
                          showConfirmButton: false
                    }).then(function() {
                         var table = $('#donation-table').DataTable();
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
                $('#donation_edit_modal').modal('hide')
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

    function DeleteTheDonation(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the Donation!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-donation-data.donation') }}",
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
                                 var table = $('#donation-table').DataTable();
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
</script>
