$(function(e) {
			
			$('#basic-datatable').DataTable({
				language: {
					searchPlaceholder: 'Search...',
					sSearch: '',
				},
				searching: false
			});
			
			$('.select2-no-search').select2({
				minimumResultsForSearch: Infinity,
				placeholder: 'Choose one'
			});
			
		});