<p><?php echo lang('edit_group_subheading');?></p>
<?php echo form_open(current_url());?>
<div class="col-lg-3">
	<div class="form-group">
    	<?php echo form_label(lang('edit_group_name_label', 'group_name')); ?>  	
        <?php echo form_input($group_name);?>
	</div>

	<div class="form-group">
            <?php echo lang('edit_group_desc_label', 'description');?> <br />
            <?php echo form_input($group_description);?>
	</div>

      <p><?php echo form_submit($group_submit);?></p>
</div>
<?php echo form_close();?>