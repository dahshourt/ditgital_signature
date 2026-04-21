<?php defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! empty($get_access_fields)):
	if (validation_errors()): ?>
	    <div class="alert alert-danger">
	        <?=validation_errors()?>
	    </div>
	<?php endif;
	
	echo form_open_multipart('tickets/create');?>
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
	
	$x = intval((count($get_access_fields)) / 2) + 1;
	$i = 1;
	foreach ($get_access_fields as $value_access_field):
		$data_form = array(
				'name' => $value_access_field['name'],
				'id' => $value_access_field['name'], 
				'value' => $this->form_validation->set_value($value_access_field['name']),
				'class' => 'form-control'
		);
		$form_type = 'form_'.$value_access_field['type'];
		if ($i % $x == 0):
		?>
	</div>
	<div class="col-lg-6">
	<?php
		endif;
		echo form_label($value_access_field['label']);
		if ($value_access_field['type'] == 'dropdown'):
			$view_values = array();
			$view_values[''] = '';
                if ( ! empty(${$value_access_field['name']})):
                    foreach (${$value_access_field['name']} as $val):
                        $view_values [$val -> id] = $val -> name;
                    endforeach;
                endif;
				switch ($value_access_field['name']):
	                case 'group_id':
	                    echo $form_type($data_form, $view_values);
	                    break;
	                case 'creator_group_id':
	                    $data_form['value'] = $this->input->post('creator_group_id');
	                    $group_hidden_id = $data_form;
						$group_hidden_id['type'] = 'hidden';
						echo form_input($group_hidden_id);
	                    $data_form['disabled'] = 'disabled';
	                    echo $form_type($data_form, $view_values);
	                    break;
					case 'category_id':
	                    $data_form['value'] = $this->input->post('category_id');
	                    $category_hidden_id = $data_form;
						$category_hidden_id['type'] = 'hidden';
						$data_form['disabled'] = 'disabled';
						echo $form_type($data_form, $view_values);
						echo form_input($category_hidden_id);
						break;
					case 'sub_category_id':
	                    $data_form['value'] = $this->input->post('sub_category_id');
	                    $sub_category_hidden_id = $data_form;
						$sub_category_hidden_id['type'] = 'hidden';
						$data_form['disabled'] = 'disabled';
						echo $form_type($data_form, $view_values);
						echo form_input($sub_category_hidden_id);
						break;
                    case 'status_id':
                        $view_values= array(
                            '2' => "Open"
                        );
                        echo $form_type($data_form, $view_values);
                        break;
					default:
						echo $form_type($data_form, $view_values);
						break;
				endswitch;
		else:
			echo $form_type($data_form);
		endif;
		$i++;
	endforeach;
	?>
	</div>
	
	<div class="col-lg-12">
	    </br>
	    <?=form_submit(array('id' => 'createTicket', 'name' => 'submit2' ,'value' => 'Create Ticket', 'class' => 'btn btn-default' , 'class' => 'btn btn-primary'))?>
	    <?=form_close()?><br/>
	</div>
<?php else: ?>
	<div class="panel-body">
		<div class="alert alert-warning">
	    	<?=lang('custom_fields:message_group_saved_info')?>
	    </div>
    </div>
<?php endif; ?>