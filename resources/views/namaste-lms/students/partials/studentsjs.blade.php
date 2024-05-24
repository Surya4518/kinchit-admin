<script>
    $(function() {
        initializeSelect2InsideModal("#assign_student_for_course_modal", "#course_id");
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#student_filter,#course_id').select2()
        $('.close').click(function() {
            $('.modal').modal('hide')
        })
        $('.form-control,.form-select').on('keyup change', function() {
            $('.validate_errors').text('')
        })

        $('#student_filter').on('change', function() {
            showlist(this.value)
        })

    })

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('#student_id').select2({
        ajax: {
            url: "{{ route('get-students-filter.student') }}",
            type: "post",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            delay: 400,
            data: function(params) {
                return {
                    search: params.term, // search term
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
                        id: item.ID,
                        text: item.user_email
                    }));
                    return {
                        results: formattedData
                    };
                }
            },
            cache: true
        }
    })

    function ShowStudentsList() {
        showlist($('#student_filter').val())
    }

    function showlist(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#student-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#student-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-students.student') }}",
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
                        return `<select class="form-control" id="course_staus${row.ID}" name="course_staus${row.ID}" onchange="ChangeCourseStatus(${row.ID})">
                            <option value="">Select</option>
                            <option ${row.course_status == 'pending' ? 'selected' : ''} value="pending">Pending</option>
                            <option ${row.course_status == 'enrolled' ? 'selected' : ''} value="enrolled">Enrolled</option>
                            <option ${row.course_status == 'completed' ? 'selected' : ''} value="completed">Completed</option>
                            </select>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="/user-profile/edit/${row.ID}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;""><a href="javascript:void(0);" onclick="RemoveTheCourse('${row.ID}')" title="Remove The Course" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fe fe-x" style="font-size:16px;"></i></a></li>
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

    function initializeSelect2InsideModal(modalId, selectId) {
        $(document).ready(function() {
            $(selectId).select2({
                dropdownParent: $(modalId)
            });
        });
    }

    function AssignCourseForStudent() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = $('#assign_course_form').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('assign-course-for-student.student') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    $('#assign_student_for_course_modal').modal('hide')
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: response['message'],
                        timer: 2500,
                        
                          showConfirmButton: false
                    }).then(function() {
                        showlist($('#student_filter').val())
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
                    $('#assign_student_for_course_modal').modal('hide')
                    Swal.fire({
                        position: "top-right",
                        icon: "warning",
                        title: response['message'],
                        timer: 2500,
                          showConfirmButton: false
                    }).then(function() {
                        // Your callback logic here
                        showlist($('#student_filter').val())
                    });
                }
            },
            error: function(data) {
                console.log('Error:', data);
            }
        })
    }

    function RemoveTheCourse(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to remove the course!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('remove-course-for-student.student') }}",
                    data: {
                        user_id: id,
                        course_id: $('#student_filter').val()
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
                                showlist($('#student_filter').val())
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
                                showlist($('#student_filter').val())
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

    function ChangeCourseStatus(id) {
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
                    url: "{{ route('change-course-for-student-status.student') }}",
                    data: {
                        user_id: id,
                        course_id: $('#student_filter').val(),
                        status: $('#course_staus' + id).val()
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
                                showlist($('#student_filter').val())
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
                                showlist($('#student_filter').val())
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
