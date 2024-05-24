<script>
    $(function() {
        $('.select2').select2()

        $('#user_for_report').on('change', function() {
            if ($('.report-form .col-12').length > 1) {
                $('.report-form .rangepicker:last').remove();
                $('.report-form .generate-excel:last').remove();
            }
            $('.report-form').append(`<div class="col-12 mg-t-20 rangepicker">
                                        <label for="user_for_report"><strong>Pick Range</strong></label>
                                        <input type="text" name="date_range" id="date_range" class="form-control daterange-picker">
                                    </div>`);
            $('#date_range').daterangepicker({
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                    // format: 'DD/MM/YYYY hh:mm A'
                    format: 'DD/MM/YYYY'
                }
            });
            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate
                    .format('DD/MM/YYYY'));
                const base_url = "{{ route('generate-user-report.report') }}"
                const from_date = picker.startDate.format('YYYY-MM-DD');
                const to_date = picker.endDate.format('YYYY-MM-DD');
                const query_link = base_url+'?user='+$('#user_for_report').val()+'&from_date='+from_date+'&to_date='+to_date;
                $('.report-form .generate-excel:last').remove();
                $('.report-form').append(`<div class="col-12 mg-t-20 text-center generate-excel">
                    <a href="${query_link}" class="btn btn-secondary">
                            Generate Report (Excel)</a>
                                    </div>`);
            });
        })
    })
</script>
