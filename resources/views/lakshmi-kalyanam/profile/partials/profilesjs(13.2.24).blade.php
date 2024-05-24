<script>
    $(function() {

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.close').click(function() {
            $('.modal').modal('hide')
        })
        $('.summernote').summernote()
        $('.form-control').on('keyup change', function() {
            $('.validate_errors').text('')
        })
        showlist()

        $('#profile_community').select2();
        $('#profile_mother_tongue').select2();

        var input = document.querySelector("#profile_mobile");
        var iti = window.intlTelInput(input, {
            separateDialCode: !0,
            initialCountry: "auto",
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
            geoIpLookup: function(e, t) {

                $.get("https://iplist.cc/api", function(t) {

                    e("" != t.countrycode ? t.countrycode : "us")

                })

            },
        });
        iti.promise.then(function() {
            var currentCountryCode = iti.getSelectedCountryData().iso2;
            iti.setCountry(currentCountryCode);
        });

        $('#profile_mobile').on('keyup change', function() {
            var selectedCountryData = iti.getSelectedCountryData();
            $('#profile_mobilecode').val('');
            $('#profile_mobilecode').val(selectedCountryData.dialCode);
        })

        $('#create_matrimony_profile').on('click', function() {
            var formdata = new FormData($('#profile_create_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('create-the-profile.laksh_profile') }}",
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
                            window.location.href =
                                "/lakshmi-kalyanam/profiles";
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

    function getphoneNumber() {
        $('#profile_mobile1').val(iti.getNumber())
    }

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('#profile_subsection').select2({
        ajax: {
            url: "{{ route('get-sub-section.laksh_profile') }}",
            type: "post",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            delay: 400,
            data: function(params) {
                return {
                    search: params.term, // search term
                    id: $('#profile_community').val()
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
                        text: item.name
                    }));
                    return {
                        results: formattedData
                    };
                }
            },
            cache: true
        }
    })

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#profile-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#profile-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-matrimony-profiles.laksh_profile') }}",
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
                    data: 'MatriID',
                    name: 'MatriID'
                },
                {
                    data: 'ConfirmEmail',
                    name: 'ConfirmEmail'
                },
                {
                    data: 'Name',
                    name: 'Name'
                },
                {
                    data: 'Mobile',
                    name: 'Mobile'
                },
                {
                    data: 'DOB',
                    name: 'DOB',
                    render: function(data, type, row) {
                        // Assuming row.eisentdt is in 'yyyy-mm-dd' format
                        var date = new Date(row.DOB);
                        var formattedDate = date.toLocaleDateString(
                            'en-GB'); // Change the format as needed
                        return formattedDate;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                        <select class="form-control" id="profile_status${row.ID}" name="profile_status${row.ID}" onchange="ProfileStatus(${row.ID})">
                            <option value="">Select</option>
                            <option ${row.Status == 'Active' ? `selected` : ``} value="Active">Active</option>
                            <option ${row.Status == 'InActive' ? `selected` : ``} value="InActive">InActive</option>
                        </select>`;

                    }
                },

                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="/lakshmi-kalyanam-profile/edit/${row.ID}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheProfile(${row.ID});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-trash"></i></a></li>
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

    function ProfileStatus(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        if ($('#profile_status' + id).val() == '') {
            Swal.fire({
                position: "center",
                icon: "warning",
                title: 'Warning',
                text: 'kindly select valid status..!',
                showConfirmButton: false,
                timer: 2500
            }).then(function() {
                showlist()
            });
            return false;
        }
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to change status..!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('status-of-profiles.laksh_profile') }}",
                    data: {
                        id: id,
                        status: $('#profile_status' + id).val()
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
                                icon: "warning",
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

    function DeleteTheProfile(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete the data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-profile-data.laksh_profile') }}",
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
                                icon: "warning",
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
</script>
