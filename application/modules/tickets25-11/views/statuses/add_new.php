<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*$view_status  = array();
$view_status[''] = 'Please Select';
	foreach ( $statuses as $status_name ) {
		$view_status [$status_name -> id] = $status_name -> name;
	}*/
if (validation_errors()) : ?>
<div class="alert alert-danger">
	<?php echo validation_errors();	 ?>
</div>
<?php endif; 
echo form_open();?>
<div class="col-lg-6">
	<?php
echo form_label('Status');
echo form_input($name);
?>
</div>
<div class="col-lg-12">
<?php echo form_submit(array('id' => 'submit', 'value' => 'Save')); ?>
<?php echo form_close(); ?>
</div>