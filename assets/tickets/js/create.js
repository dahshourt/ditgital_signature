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
    var creator_id = $("#creator_id").val();
    $("#manager_id").empty();
    $("#manager_id").append('<option value></option>');
    $.ajax({
       type: "POST" ,
       url: ajax_group_url,
       data: {group_id: user_id_val, creator_id: creator_id},
       dataType:"json",//return type expected as json
       success: function(data){
            $.each(data.sub_user_id,function(key,val){
                var opt = $('<option />');
                opt.val(key);
                opt.text(val);
                if(data.group_type_id == '3') {
                    $('#manager_id').html(opt);
                }else{
                    $('#manager_id').append(opt);
                }

            });
        }
    });
    //set status of transfer group
    $("#status_id").empty();
    //$("#status_id").append('<option value></option>');
    var current_group_id = $("#current_group_id").val();
    var previous_group_id = $("#previous_group_id").val();
    var current_status_id = $("#current_status_id").val();
    var ajax_transfer_status_url = $("#ajax_transfer_status_url").val();
    $.ajax({
       type: "POST" ,
       url: ajax_transfer_status_url,
       data: {transfer_group_id: user_id_val, current_group_id: current_group_id, previous_group_id: previous_group_id, current_status_id: current_status_id},
       dataType:"json",
       success: function(data){
            $.each(data,function(key,val){
                var opt = $('<option />');
                opt.val(val.id);
                opt.text(val.name);
                $('#status_id').append(opt);
            });
        }
    });
});



