<script>
    $(function() {
        $('.summernote').summernote()
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#update_seo_config').on('click', function() {
            var formdata = $('#update_seo_config_form').serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('update-seo-configuration.index') }}",
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

</script>
