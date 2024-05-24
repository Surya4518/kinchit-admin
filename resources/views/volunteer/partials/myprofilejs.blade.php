<script>
    $(function() {
        $('#user-profile-update').on('click', function() {
               var formdata = new FormData($('#user_profile_update')[0]);
               var csrfToken = $('meta[name="csrf-token"]').attr('content');
               $.ajax({
                   type: 'post',
                   url: "{{ route('update-my-profile') }}",
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
     document.getElementById('user_first_name').addEventListener('input', function() {
        this.value = this.value.replace(/[^A-Za-z]/, '');
    });
        document.getElementById('user_last_name').addEventListener('input', function() {
        this.value = this.value.replace(/[^A-Za-z]/, '');
    });
    
    function goBack() {
    window.history.back();
}
function goForward() {
    window.history.forward();
}

   </script>
