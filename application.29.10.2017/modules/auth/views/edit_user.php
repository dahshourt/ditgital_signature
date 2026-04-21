<?php if($message): ?>
<div class="alert alert-success"><?php echo $message;?></div>
<?php endif ?>
<h4><?php echo lang('edit_user_subheading');?></h4>

<?php echo form_open(uri_string());?>
<div class="col-lg-4">
	<div class="form-group">
		<?php echo form_label(lang('edit_user_fname_label', 'first_name')); ?>
		<?php echo form_input($first_name);?>
	</div>

    <div class="form-group">
            <?php echo form_label(lang('edit_user_lname_label', 'last_name'));?> <br />
            <?php echo form_input($last_name);?>
	</div>

	<div class="form-group">
            <?php echo form_label(lang('edit_user_company_label', 'company'));?> <br />
            <?php echo form_input($company);?>
	</div>

	<div class="form-group">
            <?php echo form_label(lang('edit_user_phone_label', 'phone'));?> <br />
            <?php echo form_input($phone);?>
	</div>

	<div class="form-group">
            <?php echo form_label(lang('edit_user_password_label', 'password'));?> <br />
            <?php echo form_input($password);?>
	</div>

	<div class="form-group">
            <?php echo form_label(lang('edit_user_password_confirm_label', 'password_confirm'));?><br />
            <?php echo form_input($password_confirm);?>
	</div>
	<?php if ($this->ion_auth->is_admin()): ?>
		<h3><?php echo form_label(lang('edit_user_groups_heading'));?></h3>
        <?php foreach ($groups as $group):?>
			<div class="checkbox">
			<label>
            <?php
            	$gID=$group['id'];
                $checked = null;
                $item = null;
                foreach($currentGroups as $grp) {
         	       if ($gID == $grp->id) {
                   	$checked= ' checked="checked"';
                    break;
                   }
                }
			?>
            <input type="radio" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
            <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
            </label>
            </div>
        <?php endforeach?>
	<?php endif ?>

	<?php echo form_hidden('id', $user->id);?>
	<?php echo form_hidden($csrf); ?>
    <p><?php echo form_submit($user_submit);?></p>

<?php echo form_close();?>
