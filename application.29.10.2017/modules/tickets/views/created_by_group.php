<div class="panel-body">
	<p><?php echo lang('index_subheading');?></p>
		<div class="dataTable_wrapper">
			<table class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr>
                    	<th><?php echo lang('tickets:id');?></th>
						<th><?php echo lang('tickets:status');?></th>
						<th><?php echo lang('tickets:created_on');?></th>
						<th><?php echo lang('tickets:edit');?></th>
                    </tr>
                </thead>
            	<tbody>
            	<?php foreach ($created_by_group as $val):?>
					<tr class="odd gradeX">
						<td><?php echo htmlspecialchars($val->id,ENT_QUOTES,'UTF-8');?></td>
						<td><?php echo htmlspecialchars($val->name,ENT_QUOTES,'UTF-8');?></td>
						<td><?php echo htmlspecialchars(date($this->config->item('log_date_format'), $val->created_at),ENT_QUOTES,'UTF-8');?></td>
						<td><?php echo anchor("tickets/edit_ticket/".$val->id, 'Edit') ;?></td>
					</tr>
				<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.panel-body -->