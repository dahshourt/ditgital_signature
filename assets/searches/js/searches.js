// Load category by group id
$('#creator_group_id').change(function(){
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
        }
    });
});

// Load sub category by category id
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
        }
    });
});


// Load sub location id by location id
$('#location_id').change(function(){
    var location_id_val = $(this).val();
    var ajax_location_id_url = $("#ajax_location_id_url").val();
    $("#sub_location_id").empty();
    $('#sub_location_id').append('<option value></option>');
    $.ajax({
        type: "POST",
        url: ajax_location_id_url,
        data: {location_id : location_id_val},
        dataType:"json",//return type expected as json
        success: function(data){
            $.each(data,function(key,val){
                var opt = $('<option />');
                opt.val(key);
                opt.text(val);
                $('#sub_location_id').append(opt);
            });
        }
    });
});

//Load sub users id by group id

$('#group_id').change(function(){

    var user_id_val = $(this).val();
    var ajax_group_url = $("#ajax_user_id_url").val();
    $("#manager_id").empty();
    $("#manager_id").append('<option value></option>');
    $.ajax({
       type: "POST" ,
       url: ajax_group_url,
       data: {group_id: user_id_val},
       dataType:"json",//return type expected as json
       success: function(data){
            $.each(data,function(key,val){
                var opt = $('<option />');
                opt.val(key);
                opt.text(val);
                $('#manager_id').append(opt);
            });
        }
    });
});



