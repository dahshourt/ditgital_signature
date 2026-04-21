<?php 
$view_validation_type  = array();
$view_validation_type[''] = '';
foreach ($validation_types as $validation_type)
{
	$view_validation_type[$validation_type -> id] = $validation_type -> name;
}
$view_sort  = array();
$view_sort[''] = '';
for($i = 1; $i <= 100; $i++)
{
	$view_sort[$i] = $i;
}
?>
	
	<table border="0" class="table table-striped" cellspacing="0">
		<thead>
			<tr>
				<th><?php echo form_checkbox(array('id'=>'check-all', 'name' => 'action_to_all', 'class' => 'check-all', 'title' => lang('permissions:checkbox_tooltip_action_to_all'))) ?></th>
				<th><?php echo form_label('Fields'); ?></th>
				<th><?php echo form_label('Validation type'); ?></th>
				<th><?php echo form_label('Sort'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($all_fields as $field): ?>
			<tr>
				<td style="width: 20px">
					<?php echo form_checkbox(array(
						'id'=> $field['id'],
						'class' => 'select-row',
						'value' => true,
						'name'=>'custom_field_id['.$field['id'].']',
						'checked'=> array_key_exists($field['id'], $edit_fields),
						'title' => sprintf(lang('permissions:checkbox_tooltip_give_access_to_module'), $field['name']),
					)) ?>
				</td>
				<td style="width: 80px">
					<label class="inline" for="<?php echo $field['id'] ?>">
						<?php echo $field['label'] ?>
					</label>
				</td>
				<td style="width: 80px">
				<?php 
				if ( ! empty($field['name'])): 
					echo form_dropdown(array(
						'name' => 'validation_type_id['.$field['id'].']',
						'id' => 'validation_type_id',
						'class' => 'form-control'), $view_validation_type, isset($edit_fields[$field['id']]['validation_type_id']) ? $edit_fields[$field['id']]['validation_type_id'] : '');				
				endif ?>
				</td>
				<td style="width: 20px">
				<?php 
				if ( ! empty($field['name'])): 
					echo form_dropdown(array(
						'name' => 'sort['.$field['id'].']',
						'id' => 'sort',
						'class' => 'form-control'), $view_sort, isset($edit_fields[$field['id']]['sort']) ? $edit_fields[$field['id']]['sort'] : '');	
				endif ?>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
<div class="col-lg-12">
	<?php
	echo form_button(array('type' => 'submit', 'content' => 'Save', 'name' => 'btnAction', 'class' => 'btn btn-default'));
	echo form_button(array('type' => 'submit', 'content' => 'Save & Exit', 'name' => 'btnAction', 'class' => 'btn btn-default', 'value' => 'save_exit'));
	?>
</div>