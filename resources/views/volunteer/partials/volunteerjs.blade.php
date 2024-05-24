<script>
    $(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.select2').select2()
        $('.form-control').on('keyup change', function() {
            $('.validate_errors').text('')
        })
        $('#user_type').on('change', function() {
            if ($('#user_type').val() === 'member') {
                $('.volunteer_list').removeClass('d-none');
            } else {
                $('.volunteer_list').addClass('d-none');
            }
        });
        showlist()
        $('.close').click(function() {
            $('#send_request_modal').modal('hide')
        })
        $('#request_types').change(function() {
            $('#request_types_error').text('')
        })
        
        $('#state_name').select2({
            ajax: {
                url: "http://kinchitapi.senthil.in.net/api/get-state",
                type: "post",
                dataType: 'json',
                delay: 400,
                data: function(params) {
                    return {
                        search: params.term, // search term
                    };
                },
                processResults: function(response) {
                    const data = response.data;
                    if (data.length === 0) {
                        return { results: [] };
                    }
                    const formattedData = data.map(item => ({
                        id: item.id,
                        text: item.name
                    }));
                    return { results: formattedData };
                },
                cache: true
            }
        });
        
        $('#city_name').select2({
            ajax: {
                url: "http://kinchitapi.senthil.in.net/api/get-city",
                type: "post",
                dataType: 'json',
                delay: 400,
                data: function(params) {
                    return {
                        search: params.term, // search term
                        state_id: $('#state_name').val()
                    };
                },
                processResults: function(response) {
                    const data = response.data;
                    if (data.length === 0) {
                        return { results: [] };
                    }
                    const formattedData = data.map(item => ({
                        id: item.id,
                        text: item.name
                    }));
                    return { results: formattedData };
                },
                cache: true
            }
        });

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

        $('#user-profile-create').on('click', function() {
            var formdata = new FormData($('#user_profile_create_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('create-the-user-profile.index') }}",
                data: formdata,
                processData: false,
                contentType: false,
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

        $('#user-profile-update').on('click', function() {
            var formdata = new FormData($('#user_profile_update_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('update-user-datas.index') }}",
                data: formdata,
                processData: false,
                contentType: false,
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

    function ShowPass(id) {
        if ($('#' + id).attr("type") == "password") {
            $('#' + id).attr("type", "text");
            $('#eye_' + id).html('<i class="fa fa-eye-slash"></i>')
        } else {
            $('#' + id).attr("type", "password");
            $('#eye_' + id).html('<i class="fa fa-eye"></i>')
        }
    }

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = new DataTable('#vol-table');
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#vol-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('show-volunteer.index') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            },
            // dom: 'Bfrtip',
            // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        // Use meta.row to get the row index
                        return meta.row + 1; // Add 1 to start the serial number from 1
                    }
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
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="/user-profile/edit/${row.ID}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editvolunteer"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;""><a href="/members/${row.user_login}" target="_blank" title="Show Members" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary showmember"><i class="fa fa-eye"></i></a></li>
                         </ul>`;
                    }
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

    function open_vol_modal(usr) {
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

    function DeleteTheUserImage(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the image!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-user-image.index') }}",
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
                                location.reload()
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
                                location.reload()
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

    // function ChangeMembersToVolunteer() {
    //     if ($('#request_types').val() == '') {
    //         $('#request_types_error').text('Please select volunteer. *')
    //         return false;
    //     }
    //     $('#send_request_modal').modal('hide')
    //     var csrfToken = $('meta[name="csrf-token"]').attr('content');
    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: 'You want to change your members to another volunteer!',
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
    //                     to_vol: $('#request_types').val()
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

   document.getElementById('user_first_name').addEventListener('input', function() {
        this.value = this.value.replace(/[^A-Za-z]/, '');
    });
        document.getElementById('user_last_name').addEventListener('input', function() {
        this.value = this.value.replace(/[^A-Za-z]/, '');
    });
    document.getElementById('user_sms_no').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, ''); 
});

document.getElementById('user_wa_no').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, ''); 
});

</script>
