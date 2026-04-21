<?php
$view_groups  = array();
$view_groups[''] = '';
foreach ($groups as $group) 
{
	$view_groups [$group -> id] = $group -> name;
}

// This URL using in ajax_sub_category.js 
$ajax_url_data = array(
        'type'  => 'hidden',
        'name'  => 'ajax_url',
        'id'    => 'ajax_url',
        'value' => $ajax_url,
);
echo form_input($ajax_url_data);
echo form_open(uri_string(), array('class'=> '', 'id'=>'edit-permissions'));
?>
<div class="well col-lg-12">
	<div class="col-lg-4">
		<?php echo form_label(lang('permissions:my_group'));
		
		echo form_dropdown($my_group, $view_groups, $group_selected_value);
		?>
	</div>

	<div class="col-lg-4">
	<?php 
		echo form_label('Group Permissions');
		echo form_dropdown($group_id, $view_groups, $group_selected_value);
	?>
	</div>
</div>
<div class="well col-lg-12">
<div id="ajax_load">

	<?php $this->load->view('partials/group'); ?>
</div>
<div class="col-lg-12">
	<?php
	echo form_button(array('type' => 'submit', 'content' => 'Save', 'name' => 'btnAction', 'class' => 'btn btn-default'));
	echo form_button(array('type' => 'submit', 'content' => 'Save & Exit', 'name' => 'btnAction', 'class' => 'btn btn-default', 'value' => 'save_exit'));
	?>
</div>
<?php echo form_close(); ?>