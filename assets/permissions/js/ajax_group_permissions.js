$(function() {
	$('#group_id').change(function() {
		var group_id_val = $(this).val();
		var my_group_val = $("#my_group").val();
		var ajax_url = $("#ajax_url").val();
			$.ajax({
				type : 'POST',
				url : ajax_url,
				data: {group_id : group_id_val, my_group : my_group_val},
				success : function (data) {
					$("#ajax_load").html(data);
				}
			});
 	});
});