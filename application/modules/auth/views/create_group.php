<?php if($message): ?>
<div class="alert alert-success"><?php echo $message;?></div>
<?php endif ?>
<h4><?php echo lang('create_group_subheading');?></h4>

<div class="alert alert-success"><?php echo $message;?></div>

<?php echo form_open("auth/create_group");?>
<div class="col-lg-3">
	<div class="form-group">
		<?php echo form_label(lang('create_group_name_label', 'group_name')); ?>
        <?php echo form_input($group_name);?>
	</div>

    <div class="form-group">
            <?php echo lang('create_group_desc_label', 'description');?>
            <?php echo form_input($description);?>
	</div>

	<?php echo form_submit($create_group_submit);?>
</div>
<?php echo form_close();?>