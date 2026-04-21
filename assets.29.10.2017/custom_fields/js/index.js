// Load category by group id and load custom fields by "group id" only related with create ticket
$('#group_id').change(function(){
	var group_id_val = $(this).val();
	var ajax_category_url = $("#ajax_category_url").val();
	$("#category_id").empty();
	$("#sub_category_id").empty();
	$('#category_id').append('<option value></option>');
    $.ajax({
        type: "POST",
        url: ajax_category_url,
        data: {group_id : group_id_val},
        dataType:"json",//return type expected as json
        success: function(categories){
        	$.each(categories,function(key,val){
            	var opt = $('<option />'); 
                opt.val(key);
                opt.text(val);
                $('#category_id').append(opt);
           });
        },
    });
    
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

// Load sub category by category id and load custom fields by "group id & category id"
$('#category_id').change(function(){
	var category_id_val = $(this).val();
	var ajax_sub_category_url = $("#ajax_sub_category_url").val();
	$("#sub_category_id").empty();
	$('#sub_category_id').append('<option value></option>');
    $.ajax({
        type: "POST",
        url: ajax_sub_category_url, 
        data: {category_id : category_id_val},
        dataType:"json",//return type expected as json
        success: function(sub_categories){
        	$.each(sub_categories,function(key,val){
            	var opt = $('<option />'); 
                opt.val(key);
                opt.text(val);
                $('#sub_category_id').append(opt);
           });
        },
    });
    // Load custom fields by group id and category id
	var ajax_url = $("#ajax_url").val();
	var group_id_val = $("#group_id").val();
	$.ajax({
		type : 'POST',
		url : ajax_url,
		data: {group_id : group_id_val, category_id : category_id_val},
		success : function (data) {
			$("#ajax_load").html(data);
		}
	});
});

// Load custom fields by "group id & sub category id"
$('#sub_category_id').change(function(){
	var category_id_val = $(this).val();
    // Load custom fields by group id only
	var ajax_url = $("#ajax_url").val();
	var group_id_val = $("#group_id").val();
	$.ajax({
		type : 'POST',
		url : ajax_url,
		data: {group_id : group_id_val, category_id : category_id_val},
		success : function (data) {
			$("#ajax_load").html(data);
		}
	});
});