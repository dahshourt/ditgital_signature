<?php defined('BASEPATH') OR exit('No direct script access allowed');
$view_categories  = array();
$view_categories[''] = 'Please Select';
	foreach ($categories as $category) {
		$view_categories [$category -> id] = $category -> name;
	}
if (validation_errors()) : ?>
<div class="alert alert-danger">
	<?php echo validation_errors();	 ?>
</div>
<?php endif;
echo form_open_multipart(); ?>
<div class="col-lg-6">
	<?php
	echo form_label('Supported Group'); 
	echo form_dropdown($parent_id, $view_categories);
	?>
</div>
<div class="col-lg-6">
	<?php
	echo form_label('Sub Category');
	echo form_input($name);
	?>
</div>
<div class="col-lg-12">
<?php echo form_submit(array('id' => 'submit', 'value' => 'Add')); ?>
<?php echo form_close(); ?>
</div>