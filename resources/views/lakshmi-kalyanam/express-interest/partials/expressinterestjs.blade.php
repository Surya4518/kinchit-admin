<script>
    $(function() {
        $('.close').click(function() {
            $('.modal').modal('hide')
        })
        $('.form-control,.form-select').on('keyup change', function() {
            $('.validate_errors').text('')
        })
        showlist()
    })

    function showlist() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var existingTable = $('#express-interest-table').DataTable();
        if (existingTable) {
            existingTable.destroy();
        }
        new DataTable('#express-interest-table', {
            processing: true,
            searching: true,
            ajax: {
                url: "{{ route('get-express-interest.express_interest') }}",
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
                    data: 'eisender',
                    name: 'eisender'
                },
                {
                    data: 'eireceiver',
                    name: 'eireceiver'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<textarea readonly>${row.eimsg}</textarea>`;
                    }
                },
                {
                    data: 'eirec_accept',
                    name: 'eirec_accept'
                },
                {
                    data: 'eisentdt',
                    name: 'eisentdt',
                    render: function(data, type, row) {
                        // Assuming row.eisentdt is in 'yyyy-mm-dd' format
                        var date = new Date(row.eisentdt);
                        var formattedDate = date.toLocaleDateString(
                        'en-GB'); // Change the format as needed
                        return formattedDate;
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
</script>
