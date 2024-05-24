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

        $('#update_matrimony_profile').on('click', function() {
            var formdata = new FormData($('#profile_update_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('update-the-profile.laksh_profile') }}",
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

    function getphoneNumber() {
        $('#profile_mobile1').val(iti.getNumber())
    }

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    let subsecid = $('#subsecid').val();
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
                        text: item.name,
                        selected: (item.id == subsecid)
                    }));
                    return {
                        results: formattedData
                    };
                }
            },
            cache: true
        }

    })
</script>
