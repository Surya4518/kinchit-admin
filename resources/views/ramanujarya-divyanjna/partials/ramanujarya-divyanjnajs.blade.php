<script>
    $(function() {
        showlist()
        $('#date_from').on('change', function(){
            $('#date_to').attr('min', this.value)
        })
        $('.form-control').on('keyup change', function() {
            $('.validate_errors').text('')
        })
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#no_of_ppl').on('change', function() {

            var htmlString = "";

            for (var i = 1; i <= $('#no_of_ppl').val(); i++) {
                htmlString += `<div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">People No ${i}</label>
                                    <input type="text" class="form-control" name="ppl_names[]" id="ppl_names${i-1}" placeholder="Enter the no ${i} people name">
                                    <p class="validate_errors" id="ppl_names.${i-1}_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                </div>`;
            }
            $(".additional").html(htmlString);

        })

        $('#kkt_or_not').on('change', function() {

            var htmlString = "";

            if ($('#kkt_or_not').val() == 'yes') {
                htmlString = `<div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Membership ID</label>
                        <input type="text" class="form-control" name="membership_id" id="membership_id" placeholder="Enter Membership Id">
                        <p class="validate_errors" id="membership_id_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                    </div>`;
            }

            $(".additional1").html(htmlString);

        })

        $('#rdbook-create').on('click', function() {
            var formdata = new FormData($('#rdbook_create_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('book-the-rd-booking.rdbooking') }}",
                data: formdata,
                contentType: false,
                processData: false,
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
                            window.location.href = "/rd-booking";
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
                            title: 'Failed..!',
                            text: response['message'],
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

    })

    function updatethebookdata() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = new FormData($('#rdbook_update_form')[0]);
        $.ajax({
            type: 'post',
            url: "{{ route('updatebook-the-rd-booking.rdbooking') }}",
            data: formdata,
            contentType: false,
            processData: false,
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
                        location.reload()
                    });
                }
                if (response['status'] == 401) {
                    const obj = response['errors'];
                    for (const fieldName in obj) {
                        if (obj.hasOwnProperty(fieldName)) {
                            $(`[id="${fieldName}_error"]`).text(obj[
                                fieldName][0])
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
                        title: 'Failed..!',
                        text: response['message'],
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
    }

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#rdbooking-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#rdbooking-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-booking-datas.rdbooking') }}",
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
                    data: 'date_from',
                    name: 'date_from'
                },
                {
                    data: 'date_to',
                    name: 'date_to'
                },
                {
                    data: 'booker_name',
                    name: 'booker_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                            <li  style="list-style-type: none;"><a href="/book-detail/${row.id}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none; margin-left: 10px;"><a href="javascript:DeleteTheBooking(${row.id})" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-trash"></i></a></li>
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
    function DeleteTheBooking(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the audio!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-booking.rdbooking') }}",
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
