<div class="panel-body">
	<?php if ($message): ?>
		<div class="alert alert-success"><?php echo $message;?></div>
	<?php endif ?>
	<p><?php echo lang('index_subheading');?></p>
		<div class="dataTable_wrapper">
			<table class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr>
                    	<th><?php echo lang('list_group_id_label');?></th>
						<th><?php echo lang('list_group_name_label');?></th>
						<th><?php echo lang('list_group_desc_label');?></th>
						<th><?php echo lang('list_group_edit_label');?></th>
                    </tr>
                </thead>
            	<tbody>
            	<?php foreach ($groups as $group):?>
				<tr class="odd gradeX">
		            <td><?php echo htmlspecialchars($group->id,ENT_QUOTES,'UTF-8');?></td>
		            <td><?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8');?></td>
		            <td><?php echo htmlspecialchars($group->description,ENT_QUOTES,'UTF-8');?></td>
					<td><?php echo anchor("auth/edit_group/".$group->id, 'Edit') ;?></td>
				</tr>
				<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.panel-body -->
<p><?php echo anchor('auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('auth/create_group', lang('index_create_group_link'))?></p>