<script>
    $(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 4000);

        $('.form-control').on('keyup', function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
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

    function ChangeAdminPassword() {
        if ($('#oldpass').val() == '') {
            show_alert('danger', 'Kindly fill the Old Password..!', 'Required!')
            return false;
        }
        if ($('#newpass').val() == '') {
            show_alert('danger', 'Kindly fill the New Password..!', 'Required!')
            return false;
        }
        if ($('#connewpass').val() == '') {
            show_alert('danger', 'Kindly fill the Confirm Password..!', 'Required!')
            return false;
        }
        if ($('#newpass').val() != $('#connewpass').val()) {
            show_alert('danger', 'Kindly enter the correct confirm password..!', 'Error..!')
            return false;
        }
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formdata = $('#sitesettings').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('change-password.index') }}",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // $("#sitesettings")[0].reset();
                if (response['status'] == 200) {
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: 'Success...!',
                        text: response['message'],
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = '/dashboard';
                    });
                }
                if (response['status'] == 401) {
                    const obj = response['errors'];
                    for (const fieldName in obj) {
                        if (obj.hasOwnProperty(fieldName)) {
                            show_alert('danger', obj[fieldName][0], 'Error!')
                            break;
                        }
                    }
                }
                if (response['status'] == 402) {
                    show_alert('danger', response['message'], 'Error!')
                }
                if (response['status'] == 400) {
                    $("#sitesettings")[0].reset();
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
    }

    function show_alert(status, msg, head) {
        $('.show_error').html(`<div class="alert alert-${status}" role="alert">
                                <strong>${head}</strong>&nbsp;&nbsp;&nbsp;&nbsp;${msg}
                            </div>`)
    }
</script>
