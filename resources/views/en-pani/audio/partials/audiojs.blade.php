<script>
    $(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.close').click(function() {
            $('.modal').modal('hide')
        })
        $('#enpani_audio_category').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            placeholder: "Select categories",
        });
        // $('.summernote').summernote()
        $('.summernote').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
        $('.form-control').on('keyup change', function() {
            $('.validate_errors').text('')
        })
        showlist()

        $('#create-enpani-audio').on('click', function() {
            var formdata = new FormData($('#create_enpani_audio_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('create-the-enpani-audio.enpani_audio') }}",
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
                            window.location.href = "/enpani-audios";
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

        $('#update-enpani-audio').on('click', function() {
            var formdata = new FormData($('#update_enpani_audio_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('update-the-enpani-audio.enpani_audio') }}",
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

    function PlayAudio(id, url) {
        $('#tutorial_audio_track').html('<audio autoplay="true"controls><source type = "audio/mp3" src = "' + window.location.origin + '/public/' + url + '"></source></audio>');
        $('#play_audio_modal').modal('show')
    }

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#enpani-audio-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#enpani-audio-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-enpani-audios.enpani_audio') }}",
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
                    data: 'audio_name',
                    name: 'audio_name'
                },
                {
                    data: 'audio_category',
                    name: 'audio_category'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="/enpani-audio/edit/${row.id}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheEnpanilAudio(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-trash"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;">
                         <div id="player-container">
                         <div onclick="PlayAudio(${row.ID},'${row.audio_url}')" id="play-pause${row.id}" class="play play-pause">Play</div>
                         </div>
                         </li>
                         </ul>`;
                    }
                    // <li  style="list-style-type: none;margin-left: 10px;""><a href="/members/${row.user_login}" target="_blank" title="Show Members" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary showmember"><i class="fa fa-eye"></i></a></li>
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

    function DeleteTheEnpanilAudio(id) {
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
                    url: "{{ route('delete-enpani-audio-data.enpani_audio') }}",
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
</script>
