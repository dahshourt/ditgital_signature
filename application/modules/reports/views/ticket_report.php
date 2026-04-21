<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

$view_status  = array();
$view_status[''] = '';
	foreach ( $statuses as $status_name ) {
		$view_status [$status_name -> id] = $status_name -> name;
	}
if (validation_errors()) : ?>
<div class="alert alert-danger">
	<?php echo validation_errors();	 ?>
</div>
<?php endif; 
echo form_open();?>
<div class="col-lg-6">
	<?php
	echo form_label('Creation date (From)');
	echo form_input($created_from); 
	echo form_label('Area Code');
	echo form_input($area_code_id);
	?>
	<div class="form-group">
	<?php
	echo form_label('Status');
	echo form_dropdown($status, $view_status);
	?>
	</div>
</div>
<div class="col-lg-6">
	<?php
	echo form_label('Creation date (To)');		
	echo form_input($created_to);
	echo form_label('Home Phone');
	echo form_input($product_phone);
	
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
	                    	<th><?php echo lang('tickets:created_on');?></th>
	                    	<th><?php echo lang('tickets:created_group');?></th>
	                    	<th><?php echo lang('tickets:status');?></th>
	                    	<th><?php echo lang('tickets:complaint_details');?></th>
	                    	<th><?php echo lang('tickets:area_code');?></th>
	                    	<th><?php echo lang('tickets:product_phone');?></th>
	                    	<th><?php echo lang('tickets:comment_date');?></th>
	                    	<th><?php echo lang('tickets:comment');?></th>
	                    	<!--<th><?php //echo lang('tickets:commented_group');?></th>-->
	                    	<th><?php echo lang('tickets:commented_user');?></th>
	                    </tr>
	                </thead>
	            	<tbody>
	            		<?php foreach ($search_tickets as $search_ticket):?>
						<tr class="odd gradeX">
							<td><?php echo htmlspecialchars($search_ticket->id,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars(date($this->config->item('log_date_format'), $search_ticket->created_at),ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->created_group,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->status_name,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->complaint_details,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->area_code_id,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->product_phone,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars(date($this->config->item('log_date_format'), $search_ticket->comment_date),ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($search_ticket->comment,ENT_QUOTES,'UTF-8');?></td>
							<!--<td><?php //echo htmlspecialchars($search_ticket->commented_group,ENT_QUOTES,'UTF-8');?></td>-->
							<td><?php echo htmlspecialchars($search_ticket->commented_user,ENT_QUOTES,'UTF-8');?></td>
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