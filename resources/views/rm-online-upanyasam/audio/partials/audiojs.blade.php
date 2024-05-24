<script>
    $(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.close').click(function() {
            $('.modal').modal('hide')
        })
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

        $('.multi-field-wrapper').each(function() {
            var $wrapper = $('.multi-fields', this);
            $(".add-field", $(this)).click(function(e) {
                $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find(
                    'input').val('').focus();
            });
            $('.multi-field .remove-field', $wrapper).click(function() {
                if ($('.multi-field', $wrapper).length > 1)
                    $(this).parent('.multi-field').remove();
            });
        });

        showlist()

        $('#create-rmonline-audio').on('click', function() {
            var formdata = new FormData($('#create_rmonline_audio_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('create-the-rm-audio.rm_audio') }}",
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
                            window.location.href = "/rm-audios";
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

        $('#update-rmonline-audio').on('click', function() {
            var formdata = new FormData($('#update_rmonline_audio_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('update-the-rmonline-audio.rm_audio') }}",
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

    // function GetTheParentAudio(id) {
    //     var csrfToken = $('meta[name="csrf-token"]').attr('content');
    //     $.ajax({
    //         type: 'post',
    //         url: "{{ route('get-rm-parent-audio.rm_audio') }}",
    //         data: {
    //             id: id
    //         },
    //         headers: {
    //             'X-CSRF-TOKEN': csrfToken
    //         },
    //         success: function(response) {
    //             if (response['status'] == 200) {
    //                 $('#parent_id').val(response['data1'][0].id)
    //                 $('#category_id').val(response['data1'][0].category_id)
    //                 // let html = ``;
    //                 // if (response['data'].length > 0) {
    //                 //     for (let i = 0; i < response['data'].length; i++) {
    //                 //         html += `<div class="multi-field  mg-t-20">
    //                 //                      <input type="text" class="form-control" value="${response['data'][i].download_url}" name="stuff[]" style="width: 85%;">
    //                 //                      <input type="hidden" value="${response['data'][i].id}" name="url_id[]">
    //                 //                      <button type="button" class="btn-transition btn btn-outline-secondary remove-field" style="float: right;margin-top: -36px;"><i class="fe fe-x" style="font-size: 14px;"></i></button>
    //                 //                    </div>`;
    //                 //     }
    //                 // } else {
    //                 //     html = `<div class="multi-field  mg-t-20">
    //                 //                 <input type="text" class="form-control" name="stuff[]" style="width: 85%;">
    //                 //                 <button type="button" class="btn-transition btn btn-outline-secondary remove-field" style="float: right;margin-top: -36px;"><i class="fe fe-x" style="font-size: 14px;"></i></button>
    //                 //               </div>`;
    //                 // }
    //                 // $('.addmoreinputs').html(html)
    //                 $('#update_download_urls_modal').modal('show')
    //             }
    //             if (response['status'] == 400) {
    //                 Swal.fire({
    //                     position: "top-right",
    //                     icon: "danger",
    //                     title: 'Failed..!',
    //                     text: response['message'],
    //                     timer: 2500
    //                 }).then(function() {
    //                     showlist()
    //                 });
    //             }
    //         },
    //         error: function(data) {
    //             console.log('Error:', data);
    //         }
    //     })
    // }

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
                url: "{{ route('get-rm-audios.rm_audio') }}",
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
                         <li  style="list-style-type: none;"><a href="/rm-audio/edit/${row.id}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-edit"></i></a></li>
                         <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:DeleteTheRMOnlineAudio(${row.id});" title="Delete Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-trash"></i></a></li>
                         </ul>`;
                    }
                        //  <li  style="list-style-type: none;margin-left: 10px;"><a href="javascript:GetTheParentAudio('${row.id}');" title="Update URLs" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary"><i class="fa fa-arrow-down"></i></a></li>
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

    function DeleteTheRMOnlineAudio(id) {
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
                    url: "{{ route('delete-rmonline-audio-data.rm_audio') }}",
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
