<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><?php echo lang('tickets:show_log');?></button>
<?php
$this->load->view('partials/logs');
if ( ! empty($get_access_fields)):
    if (validation_errors()):?>
        <div class="alert alert-danger">
            <?=validation_errors()?>
        </div>
    <?php endif;
    echo form_open_multipart('');?>
    <div class="col-lg-6">
    <?php
    // This URL using in create.js
    $ajax_location_id_url = array(
        'type'  => 'hidden',
        'name'  => 'ajax_location_id_url',
        'id'    => 'ajax_location_id_url',
        'value' => $ajax_location_id_url,
    );
    echo form_input($ajax_location_id_url);
    $ajax_user_id_url = array(
        'type'  => 'hidden',
        'name'  => 'ajax_user_id_url',
        'id'    => 'ajax_user_id_url',
        'value' => $ajax_user_id_url,
    );
    echo form_input($ajax_user_id_url);

    $ajax_transfer_status_url = array(
        'type'  => 'hidden',
        'name'  => 'ajax_transfer_status_url',
        'id'    => 'ajax_transfer_status_url',
        'value' => $ajax_transfer_status_url,
    );
    echo form_input($ajax_transfer_status_url);

    $creator_id = array(
        'type'  => 'hidden',
        'name'  => 'creator_id',
        'id'    => 'creator_id',
        'value' => $tickets_data['created_by'],
    );
    echo form_input($creator_id);

    $current_group_id = array(
        'type'  => 'hidden',
        'name'  => 'current_group_id',
        'id'    => 'current_group_id',
        'value' => $tickets_data['group_id'],
    );
    echo form_input($current_group_id);

    $previous_group_id = array(
        'type'  => 'hidden',
        'name'  => 'previous_group_id',
        'id'    => 'previous_group_id',
        'value' => $previous_group,
    );
    echo form_input($previous_group_id);

    $current_status_id = array(
        'type'  => 'hidden',
        'name'  => 'current_status_id',
        'id'    => 'current_status_id',
        'value' => $current_status,
    );
    echo form_input($current_status_id);

    $x = intval((count($get_access_fields)) / 2) + 1;
    $i = 1;
    foreach ($get_access_fields as $value_access_field):
		if (strpos($value_access_field['validation_type_name'], 'required') !== false):
			echo "<span style='color:#ff0000'>* </span>";
		endif;
		if($value_access_field['type'] == 'upload'):
		$data_form = array(
				'name' 	=> $value_access_field['name']."[]",
				'id' 	=> 	$value_access_field['name'], 
				'value' => $this->form_validation->set_value($value_access_field['name']),
				'class' => $value_access_field['class']
		);
		else:
		$data_form = array(
            'name' => $value_access_field['name'],
            'id' => $value_access_field['name'],
            'value' => (isset($tickets_data[$value_access_field['name']])) ? $tickets_data[$value_access_field['name']] : '',
            'class' => 'form-control',
        );
		endif;
        

        ($value_access_field['name'] == 'status_id' || $value_access_field['name'] == 'comment' || $value_access_field['type'] == 'upload' || $value_access_field['name'] == 'group_id' || $value_access_field['name'] == 'manager_id' )  ? '' : $data_form['disabled'] = 'disabled';
        $form_type = 'form_'.$value_access_field['type'];
        if ($i % $x == 0):
            ?>
            </div>
            <div class="col-lg-6">
        <?php
        endif;
        echo form_label($value_access_field['label']);
        if ($value_access_field['type'] == 'dropdown'):
            $selected_val = isset($tickets_data[$value_access_field['name']]) ? $tickets_data[$value_access_field['name']] : '';
            $view_values = array();
            $view_values[''] = '';
            if ( ! empty(${$value_access_field['name']})):
                foreach (${$value_access_field['name']} as $val):
                    $view_values [trim($val -> id)] = trim($val -> name);
                endforeach;
				if ($this->session->groups['type_id'] == '3'):
					switch ($value_access_field['name']):
		                case 'manager_id':
		                	$view_values = array(trim($selected_val) => $this->session->username);
							break;
							
							 
                       
                        
						
					endswitch;
				endif;
				if(trim($value_access_field['name']) == 'closed_by_user'){
					$view_values = array(
                            $this->session->userdata('user_id') => $_SESSION['username']
                        );
                       
				}
                if(trim($value_access_field['name']) == 'status_id'):
                    if(! in_array($tickets_data['status_id'],$view_values)):
                        $view_values[$tickets_data['status_id']] = $tickets_data['status_name'];
                        $selected_val = $tickets_data['status_id'];
                    endif;
                endif;
            endif;

            echo $form_type($data_form, $view_values, trim($selected_val));
        elseif($value_access_field['type'] == 'upload'):
			for($s=0;$s<5;$s++):
				echo $form_type($data_form);
			endfor;	
		else:
			echo $form_type($data_form);
		endif;
        $i++;
    endforeach;
    ?>
    </div>
    <div class="col-lg-12">
        </br>
        <?=form_submit($submit)?>
        <?=form_close()?><br/>
    </div>
<?php else: ?>
    <div class="panel-body">
        <div class="alert alert-warning">
            <?=lang('custom_fields:message_group_saved_info')?>
        </div>
    </div>
<?php endif; ?>
<?php if ( ! empty($files)):?>
<div class="col-lg-12">
	<div class="panel-body">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
	                    	<th><?php echo lang('tickets:document_name');?></th>
							<th><?php echo lang('tickets:uploaded_user');?></th>
							<th><?php echo lang('tickets:created_on');?></th>
							<th><?php echo lang('tickets:manage');?></th>
<!--remove delete attach CR#25232-->
<!--							<th>--><?php //echo lang('tickets:manage');?><!--</th>-->
	                    </tr>
	                </thead>
	            	<tbody>
	            	<?php foreach ($files as $file):?>
						<tr class="odd gradeX">
							<td><?php echo htmlspecialchars($file->file_name,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($file->username,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars(date($this->config->item('log_date_format'), $file->created_at),ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo anchor(base_url().'uploads/tickets/'.$file->file_name, 'Download', 'download') ;?></td>
                            <!--remove delete attach CR#25232-->
<!--							<td>--><?php //echo anchor('tickets/delete_files/'.$file->id.'/'.$ticket_id.'', 'Delete') ;?><!--</td>-->
						</tr>
					<?php endforeach;?>
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
	<!-- /.panel-body -->
</div>
<?php endif; ?>