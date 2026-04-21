<?php if($message): ?>
<div class="alert alert-success"><?php echo $message;?></div>
<?php endif ?>
<p><?php echo lang('create_user_subheading');?></p>

<?php echo form_open("auth/create_user");?>
<div class="col-lg-4">
	<div class="form-group">
		<?php 
			echo form_label(lang('create_user_fname_label', 'first_name'));
			echo form_input($first_name);
		?>
	</div>
	<div class="form-group">
            <?php
            	echo form_label(lang('create_user_lname_label', 'last_name'));
            	echo form_input($last_name);
            ?>
	</div>
	<?php if ($identity_column!=='email'): ?>
 	<div class="form-group">
    	<?php 
    		echo form_label(lang('create_user_identity_label', 'identity'));
          	echo form_error('identity');
            echo form_input($identity);
		?>
	</div>
	<?php endif ?>
	
	<div class="form-group">
            <?php
            	echo form_label(lang('create_user_company_label', 'company'));
            	echo form_input($company);
            ?>
	</div>

    <div class="form-group">
            <?php 
            	echo form_label(lang('create_user_email_label', 'email'));
            	echo form_input($email);
            ?>
	</div>

    <div class="form-group">
            <?php
            	echo form_label(lang('create_user_phone_label', 'phone'));
            	echo form_input($phone);
            ?>
	</div>

	<div class="form-group">
            <?php 
            	echo form_label(lang('create_user_password_label', 'password'));
            	echo form_input($password);
            ?>
	</div>

   <div class="form-group">
            <?php 
            	echo form_label(lang('create_user_password_confirm_label', 'password_confirm'));
           		echo form_input($password_confirm);
           	?>
	</div>

	<?php echo form_submit($create_user_submit);?>
</div>
<?php echo form_close();?>