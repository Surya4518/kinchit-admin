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

        $('#create-tutorial-audio').on('click', function() {
            var formdata = new FormData($('#create_tutorial_audio_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('create-the-tutorial-audio.tut_audio') }}",
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
                            window.location.href = "/tutorial-audios";
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

        $('#update-tutorial-audio').on('click', function() {
            var formdata = new FormData($('#create_tutorial_audio_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('update-the-tutorial-audio.tut_audio') }}",
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

    function PlayAudio(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('get-tutorial-audio-track.tut_audio') }}",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    $('#tutorial_audio_track').html(
                        '<audio autoplay="true"controls><source type = "audio/mp3" src = "http://kinchit-admin.senthil.in.net/public/' + response[
                            'data'][0].guid + '"></source></audio>');
                    $('#play_audio_modal').modal('show')
                }
                if (response['status'] == 400) {
                    Swal.fire({
                        position: "top-right",
                        icon: "danger",
                        title: 'Failed..!',
                        text: response['message'],
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

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#audio-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#audio-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-tutorial-audios.tut_audio') }}",
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
                    data: 'post_title',
                    name: 'post_title'
                },
                {
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<input class="form-control" value="${row.sort_order == null ? '' : row.sort_order}" name="cat_sort_order${row.ID}" id="cat_sort_order${row.ID}" onkeyup="UpdateSortOrder(${row.ID})">`;
                    }
                },
                // {
                //     data: 'post_date',
                //     name: 'post_date'
                // },
                // {
                //     data: 'post_status',
                //     name: 'post_status'
                // },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Custom rendering logic goes here
                        return `<ul style="display: flex;">
                         <li  style="list-style-type: none;"><a href="/tutorial-audio/edit/${row.ID}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary edittutorialaudio"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheTutorialAudio(${row.ID});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary deletetutorialaudio"><i class="fa fa-trash"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;">
                         <div id="player-container">
                         <div onclick="PlayAudio(${row.ID})" id="play-pause${row.ID}" class="play play-pause">Play</div>
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

    function DeleteTheTutorialAudio(id) {
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
                    url: "{{ route('delete-tutorial-audio-data.tut_audio') }}",
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

    function UpdateSortOrder(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "{{ route('update-tutorial-audio-sortorder.tut_audio') }}",
            data: {
                id: id,
                sort_order: $('#cat_sort_order' + id).val()
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response['status'] == 200) {
                    Swal.fire({
                        position: "top-right",
                        icon: "success",
                        title: 'Success...!',
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
                        title: 'Failed...!',
                        text: response['message'],
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
    function goBack() {
    window.history.back();
}
</script>
