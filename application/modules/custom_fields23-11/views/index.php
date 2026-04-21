<?php
$view_groups  = array();
$view_groups[''] = '';
foreach ($groups as $group): 
	$view_groups [$group -> id] = $group -> name;
endforeach;

$view_category = array();
$view_sub_category = array();
// This URL using in ajax file 
$ajax_url_data = array(
        'type'  => 'hidden',
        'name'  => 'ajax_url',
        'id'    => 'ajax_url',
        'value' => $ajax_url,
);
echo form_input($ajax_url_data);

// This URL using in ajax_sub_category.js 
$ajax_category_url = array(
        'type'  => 'hidden',
        'name'  => 'ajax_category_url',
        'id'    => 'ajax_category_url',
        'value' => $ajax_category_url,
);
echo form_input($ajax_category_url);

// This URL using in ajax_sub_category.js 
$ajax_sub_category_url = array(
        'type'  => 'hidden',
        'name'  => 'ajax_sub_category_url',
        'id'    => 'ajax_sub_category_url',
        'value' => $ajax_sub_category_url,
);
echo form_input($ajax_sub_category_url);

echo form_open(uri_string(), array('class'=> '', 'id'=>''));?>
<div class="well col-lg-12">
	<?=lang('custom_fields:introduction_create')?>
</div>
<?php if (validation_errors()): ?>
<div class="alert alert-danger">
	<?=validation_errors()?>
</div>
<?php endif;?>
<div class="well col-lg-12">
	<div class="col-lg-3">
	<?php 
		echo form_label('Groups');
		echo form_dropdown($group_id, $view_groups);
	?>
	</div>
	<div class="col-lg-4">
	<?php 
		echo form_label('Categories');
		echo form_dropdown($category_id, $view_category);
	?>
	</div>
	<div class="col-lg-5">
	<?php 
		echo form_label('Sub categories');
		echo form_dropdown($sub_category_id, $view_sub_category);
	?>
	</div>
</div>
<div class="well col-lg-12">
<div id="ajax_load"></div>

<?=form_close()?>