	<table border="0" class="table table-striped" cellspacing="0">
		<thead>
			<tr>
				<th><?php echo form_checkbox(array('id'=>'check-all', 'name' => 'action_to_all', 'class' => 'check-all', 'title' => lang('permissions:checkbox_tooltip_action_to_all'))) ?></th>
				<th><?php echo lang('permissions:module') ?></th>
				<th><?php echo lang('permissions:roles') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($permission_modules as $module): ?>
			<tr>
				<td style="width: 30px">
					<?php echo form_checkbox(array(
						'id'=> $module['module_rule_id'],
						'class' => 'select-row',
						'value' => true,
						'name'=>'modules['.$module['slug'].']',
						'checked'=> array_key_exists($module['slug'], $edit_permissions),
						'title' => sprintf(lang('permissions:checkbox_tooltip_give_access_to_module'), $module['name']),
					)) ?>
				</td>
				<td>
					<label class="inline" for="<?php echo $module['module_rule_id'] ?>">
						<?php echo $module['name'] ?>
					</label>
				</td>
				<td>
				<?php if ( ! empty($module['roles'])): ?>
					<?php foreach ($module['roles'] as $id => $role): ?>
					<label class="inline">
						<?php echo form_checkbox(array(
							'class' => 'select-rule',
							'name' => 'module_roles['.$id.']',
							'value' => true,
							'checked' => isset($edit_permissions[$module['slug']]) AND array_key_exists($id, (array) $edit_permissions[$module['slug']])
						)) ?>
						<?php echo $role ?>
					</label>
					<?php endforeach ?>
				<?php endif ?>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
