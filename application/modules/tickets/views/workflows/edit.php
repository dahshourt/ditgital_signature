<?php defined('BASEPATH') OR exit('No direct script access allowed');
	if (isset($error)): ?>
    <div class="alert alert-danger" style="margin-bottom:40px">
        <?php echo $error;	 ?>
    </div>
<?php endif;
	
	echo form_open_multipart('tickets/workflows/update');?>
	<input type="hidden" name="id" value="<?php echo $workflow['id']; ?>"/>
	<div class="col-lg-6">
		<label>Previous Group</label>
		<select type="" name="previous_group" id="previous_group" class="form-control">
			<option value="">...Please select...	</option>
			<?php foreach($groups as $group_val): ?>
			<option value="<?php echo $group_val->id; ?>"
			<?php if($group_val->id == $workflow['previous_group']){ echo "selected"; } ?> 
			> <?php echo $group_val->name; ?> </option>
			<?php endforeach; ?>
		</select>
	</div>
	
	<div class="col-lg-6">
		<label>Current Group</label>
		<select type="" name="current_group" id="current_group" class="form-control">
			<option value="">...Please select...	</option>
			<?php foreach($groups as $group_val): ?>
			<option value="<?php echo $group_val->id; ?>" 
			<?php if($group_val->id == $workflow['current_group']){ echo "selected"; } ?> 
			> <?php echo $group_val->name; ?> </option>
			<?php endforeach; ?>
		</select>
	</div>
	
	<div class="col-lg-6">
		<label>Transfer Group</label>
		<select type="" name="transfer_group" id="transfer_group" class="form-control">
			<option value="">...Please select...	</option>
			<?php foreach($groups as $group_val): ?>
			<option value="<?php echo $group_val->id; ?>" 
			<?php if($group_val->id == $workflow['transfer_group']){ echo "selected"; } ?> 
			> <?php echo $group_val->name; ?> </option>
			<?php endforeach; ?>
		</select>
	</div>
	
	
	<div class="col-lg-6">
		<label>Problem</label>
		<select type="" name="problem" id="problem" class="form-control">
			<option value="">...Please select...	</option>
			<?php foreach($problems as $problem_val): ?>
			<?php if($problem_val->parent_id): ?>
			<option value="<?php echo $problem_val->id; ?>"
			<?php if($problem_val->id == $workflow['problem']){ echo "selected"; } ?> 
			><?php echo $problem_val->name; ?> </option>
			<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</div>
	
	
	<div class="col-lg-12">
		<label>Transfer Status</label>
		<select class="form-control js-example-basic-multiple" name="transfer_status[]" multiple="multiple">
		  <option value="">...Please select...	</option>
			<?php foreach($statuses as $value): ?>
			<option value="<?php echo $value->id; ?>"> <?php echo $value->name; ?> </option>
			<?php endforeach; ?>
		</select>
	</div>
	
	
	
	<div class="col-lg-12">
	    </br>
	    <?=form_submit(array('id' => 'createTicket', 'name' => 'submit2' ,'value' => 'Save', 'class' => 'btn btn-default' , 'class' => 'btn btn-primary'))?>
	    <?=form_close()?><br/>
	</div>
