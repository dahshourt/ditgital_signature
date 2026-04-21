<div class="panel-body">
	<?php if(isset($message)): ?>
		<div class="alert alert-success"><?php echo $message;?></div>
	<?php endif ?>
	<h5><?php echo lang('permissions:introduction');?></h4>
		<div class="dataTable_wrapper">
			<table class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr>
                    	<th><?php echo lang('list_group_id_label');?></th>
						<th><?php echo lang('list_group_name_label');?></th>
						<th><?php echo lang('list_group_desc_label');?></th>
						<th><?php echo lang('permissions:edit');?></th>
                    </tr>
                </thead>
            	<tbody>
            	<?php foreach ($groups as $group):?>
				<tr class="odd gradeX">
		            <td><?php echo htmlspecialchars($group->id,ENT_QUOTES,'UTF-8');?></td>
		            <td><?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8');?></td>
		            <td><?php echo htmlspecialchars($group->description,ENT_QUOTES,'UTF-8');?></td>
					<td><?php if ($admin_group != $group->name):?>
						<?php echo anchor('permissions/group/' . $group->id, lang('permissions:edit'), array('class'=>'button')) ?>
						<?php else: ?>
						<?php echo lang('permissions:admin_has_all_permissions') ?>
						<?php endif ?>
					</td>
				</tr>
				<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.panel-body -->