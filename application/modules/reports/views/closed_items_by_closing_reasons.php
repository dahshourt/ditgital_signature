<script type="text/javascript">
	function load_data_ajax(id){
		var controller = 'reports';
	    var base_url = '<?php echo site_url(); ?>'
		var value = $('#'+id).val();
		$.ajax({
			'url' : base_url + '/' + controller + '/closed_items_by_closing_reasons_report',
	        'type' : 'POST', //the way you want to send data to your URL
	        'data' : {'ajax_type_id' : id, 'ajax_value' : value},
	        'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
	            if(data){
	            	alert(data);
					//	success
	            }
			}
		});
	}
</script>
<!---->

	<?php
	$attributes = array('class' => '', 'id' => 'myform');
	echo form_open($main_content, $attributes);
	
	// Fetch all groups
	$view_groups = array();
	foreach ($all_groups as $group) {
		$view_groups[$group -> group_id] = $group -> group_name;
	}
	
	// Fetch all platforms
	$view_platforms = array();
	//$js_platform = 'id="platform_id" onChange=load_data_ajax("platform_id")';
	$js_platform = '';
	foreach ($all_platforms as $platform) {
		$view_platforms[$platform -> menu_value] = $platform -> menu_value;
	}

	// Fetch problem types by platform
	if (isset($problems_types)) {
		$view_problems_types = array();
		$view_problems_types[''] = 'All';
		//$js_problem_type = 'id="problem_type_id" onChange=load_data_ajax("problem_type_id")';
		$js_problem_type = '';
		foreach ($problems_types as $problem_type) {
			$view_problems_types[$problem_type] = $problem_type;
		}
	}
	
	// Fetch closing reasons by problem type
	$view_closing_reasons = array();
	$view_closing_reasons[''] = 'All';
	foreach ($closing_reasons as $closing_reason) {
		$view_closing_reasons[$closing_reason -> closingReason] = $closing_reason -> closingReason;
	}
	?>
<div style="clear: both"><?php echo validation_errors(); ?></div>
<div style="float: left; width: 400px; height: 50px">
	<div style="float: left; width: 100px; height: 50px">Group :</div><?php echo form_dropdown('group_id', $view_groups);?></div>
<div style="float: left; width: 400px; height: 50px">
	<div style="float: left; width: 100px; height: 50px">Product :</div><?php echo form_dropdown('platform_id', $view_platforms,'', $js_platform);?></div>
<div style="float: left; width: 400px; height: 50px">
	<div style="float: left; width:100px; height: 50px">problem :</div><?php echo (isset($problems_types)) ? form_dropdown('problem_type_id', $view_problems_types, '', $js_problem_type) : '';?></div>

<div style="clear: both"></div>
<div style="float: left; width: 400px; height: 50px">
	<div style="float: left; width: 100px; height: 50px">Closing reason :</div><?php echo form_dropdown('closing_reason_id', $view_closing_reasons);?></div>
<div style="float: left; width: 400px; height: 50px"><div style="float: left; width: 100px; height: 50px">Start Date</div><input type="text" name="start_date" class="some_class" value="" id="start_date" readonly="readonly" /></div>
<div style="float: left; width: 400px; height: 50px"><div style="float: left; width: 100px; height: 50px">End Date</div><input type="text" name="end_date" class="some_class" value="" id="end_date" readonly="readonly" /></div>
<div style="clear: both"><input type="submit" value="Search" /></div>

<p id="container"></p>
<code>
	<?php
	if (! empty($records)) {
	?>
	<div style="float: left; width: 150px">Product</div>
	<div style="float: left; width: 250px">Problem</div>
	<div style="float: left; width: 250px">Closing Reason</div>
	<div style="float: left; width: 250px">Counter</div>
	<div style= "clear: both"></div>
	<?php
		foreach ($records as $row) {
			echo '<div style="float: left; width: 150px">' . $row -> product . '</div>
			<div style="float: left; width: 250px">'.$row -> problem.'</div>
			<div style="float: left; width: 250px">'.$row -> closing_reason.'</div>
			<div style="float: left; width: 250px">'.$row -> counter.'</div>
			<div style= "clear: both"></div>';
		}
	}
	?>
</code>
</div>