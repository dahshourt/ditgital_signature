<div class="panel-body">
	<p><?=lang('index_subheading');?></p>
	<div id="infoMessage"><?=validation_errors(); ?></div>
		<div class="dataTable_wrapper">
			<table class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr>
                    	<th>#</th>
						<th>Problem</th>
						<th>Previous group</th>
						<th>Current group</th>
						<th>Transfer group</th>
						<th><?=lang('tickets:edit');?></th>
                    </tr>
                </thead>
            	<tbody>
            	<?php
            	if ( ! empty($workflows)): 
            		foreach ($workflows as $workflow):?>
					<tr class="odd gradeX">
						<td><?=htmlspecialchars($workflow->id,ENT_QUOTES,'UTF-8');?></td>
						<td><?=htmlspecialchars($workflow->category_name,ENT_QUOTES,'UTF-8');?></td>
						<td><?=htmlspecialchars($workflow->p_name,ENT_QUOTES,'UTF-8');?></td>
						<td><?=htmlspecialchars($workflow->c_name,ENT_QUOTES,'UTF-8');?></td>
						<td><?=htmlspecialchars($workflow->t_name,ENT_QUOTES,'UTF-8');?></td>
						
						<td><?php echo anchor("tickets/workflows/edit/".$workflow->id, 'Edit') ;?></td>
					</tr>
				<?php endforeach;
				endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.panel-body -->