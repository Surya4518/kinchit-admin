<script>
    $(function() {
        $('.summernote').summernote()
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#update_site_config').on('click', function() {
            var formdata = $('#update_site_config_form').serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('update-site-configuration.index') }}",
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
                            location.reload()
                        });
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

</script>
