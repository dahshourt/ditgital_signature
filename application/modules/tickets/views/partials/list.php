<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-lg-12">
<div class="panel-body">
	<p><?=lang('index_subheading');?></p>
	<div class="dataTable_wrapper">
		<table class="table table-striped table-bordered table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th><?=lang('global:id');?></th>
					<?php 
					if ( ! empty($th)): 
						foreach ($th as $th_val):
					?>
                	<th><?=lang($th_val)?></th>
                    <?php 
                    	endforeach; 
                    endif;
                    ?>
                    <th><?=lang('global:created_at');?></th>
					<th><?=lang('global:edit');?></th>
	                <th><?=lang('global:delete');?></th>
                </tr>
            </thead>
	        <tbody>
			<?php
	        if ( ! empty($results)):
		    	foreach ($results as $res):?>
					<tr class="odd gradeX">
						<td><?=htmlspecialchars($res->id,ENT_QUOTES,'UTF-8')?></td>
						<td><?=htmlspecialchars($res->name,ENT_QUOTES,'UTF-8')?></td>
						<td><?=htmlspecialchars($res->linked_name,ENT_QUOTES,'UTF-8')?></td>
						<td><?=htmlspecialchars(date($this->config->item('log_date_format'), $res->created_at),ENT_QUOTES,'UTF-8');?></td>
						<td><?=(! empty($edit_url) ? anchor($edit_url.$res->id, lang('global:edit')) : '')?></td>
						<td><?=(! empty($delete_url) ? anchor($delete_url.$res->id, lang('global:delete')) : '')?></td>
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