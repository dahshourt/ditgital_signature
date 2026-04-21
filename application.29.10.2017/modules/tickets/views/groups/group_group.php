<?php defined('BASEPATH') OR exit('No direct script access allowed');
$view_groups  = array();
$view_groups[''] = 'Please Select';
	foreach ($groups as $group) {
		$view_groups [$group -> id] = $group -> name;
	}

if (validation_errors()) : ?>
<div class="alert alert-danger">
	<?php echo validation_errors();	 ?>
</div>
<?php endif;
echo form_open_multipart(); ?>
<div class="col-lg-6">
	<div class="form-group">
	<?php
	echo form_label('Supported Group'); 
	echo form_dropdown($group_id, $view_groups);
	?>
	</div>
</div>
<div class="col-lg-6">
	<div class="form-group">
	<?php
	echo form_label('Transferred Group');
	echo form_dropdown($to_group_id, $view_groups);
	?>
	</div>
</div>
<div class="col-lg-12">
<?php echo form_submit(array('id' => 'submit', 'value' => 'Save', 'class' => 'btn btn-primary')); ?>
<?php echo form_close(); ?>
</div>

<?php $this->load->view('partials/list')?>