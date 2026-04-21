<?php
$view_groups  = array();
$view_groups[''] = '';
foreach ($groups as $group):
	$view_groups [$group -> id] = $group -> name;
endforeach;

// This URL using in ajax file 
$ajax_url_data = array(
        'type'  => 'hidden',
        'name'  => 'ajax_url',
        'id'    => 'ajax_url',
        'value' => $ajax_url,
);
echo form_input($ajax_url_data);

echo form_open(uri_string(), array('class'=> '', 'id'=>''));?>
<div class="well col-lg-12">
	<?=lang('custom_fields:introduction_search')?>
</div>
<?php if (validation_errors()): ?>
<div class="alert alert-danger">
	<?=validation_errors()?>
</div>
<?php endif; ?>
<div class="well col-lg-12">
	<div class="col-lg-3">
	<?php 
		echo form_label('Groups');
		echo form_dropdown($group_id, $view_groups);
	?>
	</div>
</div>
<div class="well col-lg-12">
<div id="ajax_load"></div>
<?=form_close()?>