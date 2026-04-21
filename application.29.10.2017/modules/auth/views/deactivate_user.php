<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

<?php echo form_open("auth/deactivate/".$user->id);?>
<div class="form-group">
  	<label class="radio-inline">
    	<input type="radio" name="confirm" value="yes" checked="checked" />
    	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
    </label>
    <label class="radio-inline">
    	<input type="radio" name="confirm" value="no" />
    	<?php echo lang('deactivate_confirm_n_label', 'confirm');?>
    </label>
</div>
<?php echo form_hidden($csrf); ?>
<?php echo form_hidden(array('id'=>$user->id)); ?>

<?php echo form_submit('submit', lang('deactivate_submit_btn'), 'class = btn btn-default');?></p>

<?php echo form_close();?>