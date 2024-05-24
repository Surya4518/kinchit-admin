<script>
    $(function() {
        showlist()
    })

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#donor-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#donor-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('show-donor.index') }}",
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
                        return `<ul>
                         <li  style="list-style-type: none;"><a href="/user-profile/edit/${row.ID}" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editvolunteer"><i class="fa fa-edit"></i></a></li>
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
    function goBack() {
    window.history.back();
}

</script>
