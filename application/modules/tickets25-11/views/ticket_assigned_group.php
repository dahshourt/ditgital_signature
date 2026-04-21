<div class="panel-body">
	<p><?=lang('index_subheading');?></p>
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
            	if ( ! empty($tickets_by_group)):
	            	foreach ($tickets_by_group as $ticket_by_group):?>
						<tr class="odd gradeX">
							<td><?=htmlspecialchars($ticket_by_group->id,ENT_QUOTES,'UTF-8');?></td>
							<td><?=htmlspecialchars($ticket_by_group->name,ENT_QUOTES,'UTF-8');?></td>
							<td><?=htmlspecialchars(date($this->config->item('log_date_format'), $ticket_by_group->created_at),ENT_QUOTES,'UTF-8');?></td>
							<td><?=htmlspecialchars($ticket_by_group->product_phone,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo (! empty($edit_ticket) ? anchor("tickets/edit/".$ticket_by_group->id, 'Edit') : '') ;?></td>
							<td><?php echo (! empty($view_ticket) ? anchor("tickets/view/".$ticket_by_group->id, 'View') : '');?></td>
						</tr>
				<?php 
					endforeach;
				endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.panel-body -->