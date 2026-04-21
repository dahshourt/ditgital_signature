<?php defined('BASEPATH') OR exit('No direct script access allowed');
if (validation_errors()) : ?>
<div class="alert alert-danger">
	<?php echo validation_errors();	 ?>
</div>
<?php endif; 
echo form_open();?>
<div class="col-lg-6">
	<?php
echo form_label('Category');
echo form_input($name);
?>
</div>
<div class="col-lg-12">
<?php echo form_submit(array('id' => 'submit', 'value' => 'Add')); ?>
<?php echo form_close(); ?>
</div>