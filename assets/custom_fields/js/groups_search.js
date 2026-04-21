// Load custom fields by "group id" - related with search criteria
$('#group_id').change(function(){
	var group_id_val = $(this).val();
    // Load custom fields by group id only
	var ajax_url = $("#ajax_url").val();
	$.ajax({
		type : 'POST',
		url : ajax_url,
		data: {group_id : group_id_val},
		success : function (data) {
			$("#ajax_load").html(data);
		}
	});
});