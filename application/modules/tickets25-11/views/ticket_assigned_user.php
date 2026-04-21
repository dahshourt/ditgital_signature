<div class="panel-body">
	<p><?=lang('index_subheading');?></p>
	<div id="infoMessage"><?=validation_errors(); ?></div>
		<div class="dataTable_wrapper">
			<table class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr>
                    	<th><?=lang('tickets:id');?></th>
						<th><?=lang('tickets:status');?></th>
						<th><?=lang('tickets:created_on');?></th>
						<th><?=lang('tickets:product_phone');?></th>
						<th><?=lang('tickets:edit');?></th>
	                    <th><?=lang('tickets:view');?></th>
                    </tr>
                </thead>
            	<tbody>
            	<?php
            	if ( ! empty($tickets_by_user)): 
            		foreach ($tickets_by_user as $ticket_by_user):?>
					<tr class="odd gradeX">
						<td><?=htmlspecialchars($ticket_by_user->id,ENT_QUOTES,'UTF-8');?></td>
						<td><?=htmlspecialchars($ticket_by_user->name,ENT_QUOTES,'UTF-8');?></td>
						<td><?=htmlspecialchars(date($this->config->item('log_date_format'), $ticket_by_user->created_at),ENT_QUOTES,'UTF-8');?></td>
						<td><?=htmlspecialchars($ticket_by_user->product_phone,ENT_QUOTES,'UTF-8');?></td>
						<td><?php echo (! empty($edit_ticket) ? anchor("tickets/edit/".$ticket_by_user->id, 'Edit') : '') ;?></td>
						<td><?php echo (! empty($view_ticket) ? anchor("tickets/view/".$ticket_by_user->id, 'View') : '');?></td>
					</tr>
				<?php endforeach;
				endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.panel-body -->