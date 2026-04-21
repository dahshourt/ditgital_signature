<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$view_category  = array();
$view_category[''] = '';
foreach ($categories as $category)
{
	$view_category [$category -> id] = $category -> name;
}

$view_area_code = array();
$view_area_code[''] = '';
foreach ($areacodes as $area_code)
{
	$view_area_code[$area_code -> area_code_id] = $area_code -> area_code_name;
}
	
$view_group = array();
$view_group[''] = '';
foreach ($groups as $group)
{
	$view_group [$group -> id] = $group -> name;
}

$view_status  = array();
$view_status[''] = '';
	foreach ($statuses as $status_name) {
		$view_status [$status_name -> id] = $status_name -> name;
	}
if (validation_errors()) : ?>
<div class="alert alert-danger">
	<?php echo validation_errors();	 ?>
</div>
<?php endif; 
echo form_open();?>
<div class="col-lg-3">
	<?php
	echo form_label('Creation date (From)');
	echo form_input($created_from);
	echo form_label('Area Code');
	echo form_dropdown($area_code_id, $view_area_code);
	?>
	<div class="form-group">
	<?php
	echo form_label('Ticket Category'); 
	echo form_dropdown($category_id, $view_category);
	?>
	</div>
</div>
<div class="col-lg-3">
	<?php
	echo form_label('Creation date (To)');		
	echo form_input($created_to);
	echo form_label('DSL Number');
	echo form_input($product_phone);
	echo form_label('Status');
	echo form_dropdown($status_id, $view_status);
	?>
</div>
<div class="col-lg-3">
	<?php
	echo form_label('Ticket No');
	echo form_input($ticket_id);
	echo form_label('Mobile');
	echo form_input($mobile);
	echo form_label('Ticket Group');
	echo form_dropdown($group_id, $view_group);
	?>
</div>
<div class="col-lg-3">
	<?php
	echo form_label('Customer No');
	echo form_input($account_no);
	echo form_label('Home Phone');
	echo form_input($phone_no);
	?>
</div>

<div class="col-lg-12">
	<?php echo form_submit(array('id' => 'submit', 'value' => 'Search', 'class' => 'btn btn-default')); ?>
</div>

<?php echo form_close(); ?>

<?php if(isset($search_tickets)) : ?>
<div class="col-lg-12">
	<div class="panel-body">
		<h1 class="page-header">Results</h1>
			<?php if ( ! empty($search_tickets)): ?>
			<div class="form-group">
			<?php echo anchor('reports/export_csv', 'Export Data', 'title="Export Data" class="btn btn-outline btn-success"');?>
			</div>
			<?php endif; ?>
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
						<tr>
	                    	<th><?php echo lang('tickets:id');?></th>
	                    	<th><?php echo lang('tickets:creator');?></th>
	                    	<th><?php echo lang('tickets:created_group');?></th>
	                    	<th><?php echo lang('tickets:created_on');?></th>
	                    	<th><?php echo lang('tickets:category');?></th>
	                    	<th><?php echo lang('tickets:status');?></th>
	                    	<th><?php echo lang('tickets:area_code');?></th>
	                    	<th><?php echo lang('tickets:product_phone');?></th>
	                    	<th><?php echo lang('tickets:edit');?></th>
	                    </tr>
	                </thead>
	            	<tbody>
	            		<?php foreach ($search_tickets as $search_ticket):?>
						<tr class="odd gradeX">
							<td><?php echo htmlspecialchars($search_ticket->id,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->created_user,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->created_group,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars(date($this->config->item('log_date_format'), $search_ticket->created_at),ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->categrory,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->status_name,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->area_code_name,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->phone_no,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo anchor("tickets/edit_ticket/".$search_ticket->id, 'Edit') ;?></td>
						</tr>
					<?php endforeach; ?> 
	                </tbody>
	            </table>
	        </div>
	        <?php if ( ! empty($search_tickets)): ?>
	        <div class="form-group">
			<?php echo anchor('reports/export_csv', 'Export Data', 'title="Export Data" class="btn btn-outline btn-success"');?>
			</div>
			<?php endif; ?>
	    </div>
	</div>
	<!-- /.panel-body -->
</div>
<?php endif; ?>