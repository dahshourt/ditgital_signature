<div class="panel-body">
	<p><?=lang('index_subheading');?></p>
	<?php if (isset($error)): ?>
    <div class="alert alert-danger" style="margin-bottom:40px">
        <?php echo $error;	 ?>
    </div>
<?php endif; ?>


<?php if (isset($message)): ?>
    <div class="alert alert-success" style="margin-bottom:40px">
        <?php echo $message;	 ?>
    </div>
<?php endif; ?>
		<form class="mb-15" method="POST" action="<?php echo site_url('tickets/ticket_assigned_group');?>" enctype="multipart/form-data">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

				<div class="col-lg-3" style="margin-bottom: 10px;margin-top: -30px;">
					<label>Select User</label>
						<select name="manager_id" id="manager_id" class="form-control">
							<option value="">...Please select...	</option>
							<?php foreach ($users as $item):?>
								<option value="<?php echo $item->id; ?>"> <?php echo $item->username; ?> </option>
							<?php endforeach;?>
						</select>
				</div>
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
							<td>
							<label class="checkbox">
								<input type="checkbox" class="ticket_ids" name="ids[]" id="checkItem" value="<?=htmlspecialchars($ticket_by_group->id,ENT_QUOTES,'UTF-8');?>" />	
								<span></span>
							</label>	
							<?=htmlspecialchars($ticket_by_group->id,ENT_QUOTES,'UTF-8');?></td>
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
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Bulk Update</button>
				</div>
			</form>
        </div>
    </div>
</div>
<!-- /.panel-body -->