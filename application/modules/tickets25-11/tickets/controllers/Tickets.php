<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->lang->load('tickets/tickets');
		$this->lang->load('custom_fields/custom_fields');
		$this->load->model('ticket_model');
		$this->load->model('tickets/status_model');
		$this->load->model('tickets/category_model');
		$this->load->model('custom_fields/custom_field_model');
		$this->load->model('tickets/group_model');
        $this->load->model('tickets/location_model');
		$this->load->model('auth/ion_auth_model');
	}

	public function create()
    {
		
    	$my_group = $this->group_id['id'];
		$form_type = '1';
        $main_content = 'tickets/custom_fields';
        $title = 'Create New Ticket - Trouble ticketing Systems';
		
		if ($this->input->post('creator_group_id'))
		{
			
			$creator_group_id = $this->input->post('creator_group_id');
			$this->load->module('custom_fields/custom_fields');
			$input = array('form_type' => '1', 'category_id' => $this->input->post('category_id'),
						'sub_category_id' => $this->input->post('sub_category_id'), 'group_id' => $creator_group_id);
			
			$get_access_fields = $this->custom_fields->get_access_fields($input);
			// Remove Comment from Create ticket and stil exist in update ticket till make configuration.
			unset($get_access_fields['comment']);
            $cmp = function($a, $b){ return $a['sort'] - $b['sort'];};
            usort($get_access_fields, $cmp);
		}
		
    	if ($this->input->post('submit2'))
		{
			
            foreach ($get_access_fields as $values)
            {
                if (isset($values['validation_type_id']))
                {
                    $this->form_validation->set_rules($values['name'], $values['label'], $values['validation_type_name']);
                }
            }
            if($this->form_validation->run())
            {
                $ticket_id = $this->_add_ticket($get_access_fields);
                $this->session->set_flashdata('message', 'The ticket number('.$ticket_id.') has been created successfully, You can create a new one.');
				redirect('/tickets/create', 'refresh');
				exit();
            }
            else
            {
            	$custom_fields_data['get_access_fields'] =  $get_access_fields;
				$custom_fields_data['group_id'] = $creator_group_id;
				$custom_fields_data['category_id'] = $this->input->post('category_id');
				$custom_fields_data['sub_category_id'] = $this->input->post('sub_category_id');
				$custom_fields_data['transfer_group_input'] = array(
                    'current_group' => $creator_group_id,
                    'previous_group' => null,
                    'current_status' => null,
                );
				$data = $this->get_custom_fields($custom_fields_data);
                $data['previous_group'] = "";
                $data['current_status'] = "";
                unset($custom_fields_data['transfer_group_input']);
                $data['title'] = 'Create New Ticket - Trouble ticketing Systems';
                $data['main_content'] = 'tickets/custom_fields';
                $this->load->view('layouts/default', $data);
            }
		}
		else 
		{
			
			$this->form_validation->set_rules('creator_group_id', 'Group', 'required');
            $this->form_validation->set_rules('category_id', 'Category', 'required');
            if ($this->form_validation->run())
            {
				 
            	$custom_fields_data['get_access_fields'] =  $get_access_fields;
				$custom_fields_data['group_id'] = $creator_group_id;
				$custom_fields_data['category_id'] = $this->input->post('category_id');
				$custom_fields_data['sub_category_id'] = $this->input->post('sub_category_id');
                $custom_fields_data['transfer_group_input'] = array(
                    'current_group' => $creator_group_id,
                    'previous_group' => null,
                    'current_status' => null,
                );
				$data = $this->get_custom_fields($custom_fields_data);
                $data['previous_group'] = "";
                $data['current_status'] = "";
                unset($custom_fields_data['transfer_group_input']);
				$data['js'] = array('tickets/js/create.js','bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
			'bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js', 'reports/js/calender_from_to.js');
			$data['css'] = array('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
			'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css');
                $data['title'] = 'Create New Ticket - Trouble ticketing Systems';
                $data['main_content'] = 'tickets/custom_fields';
                $this->load->view('layouts/default', $data);
            } 
            else 
            {
				 
                $data['creator_group_id'] = array('type' => '', 'name' => 'creator_group_id', 'id' => 'creator_group_id', 'class' => 'form-control');
                $data['category_id'] = array('type' => '', 'name' => 'category_id', 'id' => 'category_id', 'value' => '', 'class' => 'form-control');
                $data['sub_category_id'] = array('type' => '', 'name' => 'sub_category_id', 'id' => 'sub_category_id', 'value' => $this->form_validation->set_value('sub_category_id'), 'class' => 'form-control');
                $data['groups'] = $this->group_model->get_access_by_group($my_group, array('create_ticket'));
				$data['ajax_sub_category_url'] = site_url('tickets/categories/ajax_get_sub_categories');
				$data['ajax_category_url']     = site_url('tickets/categories/ajax_get_categories_by_group');
                $data['js'] = array('tickets/js/create.js','bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
			'bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js', 'reports/js/calender_from_to.js');
			$data['css'] = array('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
			'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css');
				$data['title'] = 'Choose Group and Category to Create a Ticket - Trouble ticketing Systems';
                $data['main_content'] = 'tickets/create_ticket';
                $this->load->view('layouts/default', $data);
            }
		}
     }

	public function ticket_assigned_user()
	{
		$group_id = $this->group_id['id'];
		if($group_id != '1')
		{
			foreach ($this->session->group_permissions as $key => $value)
			{

				if ($value['group_access'] == $group_id && $value['rule_slug'] == 'view_ticket')
				{
					$data['view_ticket'] = TRUE;
				}
				else if ($value['group_access'] == $group_id && $value['rule_slug'] == 'edit_ticket')
				{
					$data['edit_ticket'] = TRUE;
				}
			}
		}
		else
		{
			$data['view_ticket'] = TRUE;
			$data['edit_ticket'] = TRUE;
		}
		$data['tickets_by_user'] = $this->ticket_model->get_tickets_by_user($this->user_id);
		$data['js'] = array('bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js');
		$data['css'] = array('bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css');
		$data['main_content'] = 'tickets/ticket_assigned_user';
 		$data['title']        = 'Tickets assigned To User';
		
 		$this->load->view('layouts/default',$data);
	}
	
	public function ticket_assigned_group()
	{
		$group_id = $this->group_id['id'];
		if($group_id != '1')
		{
			foreach ($this->session->group_permissions as $key => $value)
			{
				if ($value['group_access'] == $group_id && $value['rule_slug'] == 'view_ticket')
				{
					$data['view_ticket'] = TRUE;
				}
				else if ($value['group_access'] == $group_id && $value['rule_slug'] == 'edit_ticket')
				{
					$data['edit_ticket'] = TRUE;
				}
			}
		}
		else
		{
			$data['view_ticket'] = TRUE;
			$data['edit_ticket'] = TRUE;
		}
		$data['tickets_by_group'] = $this->ticket_model->get_tickets_by_group($group_id);
		$data['js'] = array('bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js');
		$data['css'] = array('bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css');
		$data['main_content'] = 'tickets/ticket_assigned_group';
 		$data['title']        = 'Tickets Assigned To Group';
		
 		$this->load->view('layouts/default',$data);
	}

	public function created_by_group() {

		$group_id = $this->group_id['id'];
		$data['created_by_group'] = $this->ticket_model->get_tickets_created_by_group($group_id);
		$data['js'] = array('bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js');
		$data['css'] = array('bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css');
		$data['main_content'] = 'tickets/created_by_group';
 		$data['title']        = 'Tickets created by group';
		
 		$this->load->view('layouts/default',$data);
	}
	
	public function upload_files($time, $ticket_id) {
		//upload file
			$config['upload_path']          = './uploads/tickets/';
		    $config['allowed_types']        = 'gif|jpg|png|txt|pdf|docx|xlsx|csv';
		    $config['max_size']             = 1024;
		    //$config['max_width']            = 1024;
		    //$config['max_height']           = 768;
				
			//load upload class library
		    $this->load->library('upload', $config);
			$files = $_FILES;
			$upload_count = count($_FILES['upload']['name']);
			for($i=0; $i<$upload_count ; $i++)
			{
				if(! empty($files['upload']['name'][$i]))
				{
					$_FILES['upload']['name']= $files['upload']['name'][$i];
					$_FILES['upload']['type']= $files['upload']['type'][$i];
					$_FILES['upload']['tmp_name']= $files['upload']['tmp_name'][$i];
					$_FILES['upload']['error']= $files['upload']['error'][$i];
					$_FILES['upload']['size']= $files['upload']['size'][$i]; 
					//$this->upload->do_upload('upload');
					if ( ! $this->upload->do_upload('upload'))
					{
						$error = array('error' => $this->upload->display_errors());
					} else {	
						$data_file =  $this->upload->data();
						
						$file_name = $data_file['file_name'];
						$file_path = 'uploads/tickets/'.$file_name;
						$file_data = array(
							'user_id' => $this->user_id,
							'file_name' => $file_name,
							'file_path' => $file_path,
							'ticket_id' => $ticket_id,
							'active' => '1',
							'created_at' => $time,
							'created_by' => $this->user_id,
							);
						$this->ticket_model->add_file($file_data);
					}

				}
			}
			
			//end upload file
	}

	public function delete_files($id, $ticket_id) {
		//delete source file and set it inactive in table tickets_files 
			
		// Select file path with id
		$file_path = $this->ticket_model->get_file_path($id);
		if(is_file($file_path))
		{
			unlink($file_path);
		}
		$data = array(
	        'active' => '0',
	        'updated_at'  => time(),
	        'updated_by'  => $this->user_id,
		);
		$this->ticket_model->delete_file($id, $data);
		$this->session->set_flashdata('message', 'The file has been deleted successfully');
		redirect('/tickets/edit/'.$ticket_id, 'refresh');
		exit();
	}

    public function ajax_get_sub_location_id()
    {
        $location_id = $this->input->post('location_id');
        $this->load->model('ticket_model');
        $sub_location_id  = array();
        $sub_location_id = $this->ticket_model->ajax_get_sub_location_id($location_id);
        if ($sub_location_id != 0)
        {
            echo json_encode($sub_location_id);
        }
        exit();
    }

    public function ajax_get_sub_users_id()
    {
        $group_id = $this->input->post('group_id');
        $creator_id = $this->input->post('creator_id');

        $this->load->model('ticket_model');
        $sub_user_id  = array();
        if($creator_id) {
            $input = array('id' => $group_id);
            $group_info = $this->ticket_model->get_group_info($input);
            $group_type_id  = $group_info[0]->type_id;

            $sub_user_id = $this->ticket_model->ajax_get_sub_users_id($group_id, $creator_id, $group_type_id);
        }else {
            $sub_user_id = $this->ticket_model->ajax_get_sub_users_id($group_id);
        }
        if ($sub_user_id != 0)
        {
            echo json_encode($sub_user_id);
        }
        exit();
    }

    public function ajax_transfer_status()
    {
        $transfer_group_id = $this->input->post('transfer_group_id');
        $current_group_id = $this->input->post('current_group_id');
        $previous_group_id = $this->input->post('previous_group_id');
        $current_status_id = $this->input->post('current_status_id');
		$current_sub_category_id = $this->input->post('sub_category_id');
        $this->load->model('ticket_model');
        $transfer_status  = array();
        $input = array(
            'current_group' => empty($current_group_id)? NULL : $current_group_id,
            'transfer_group' => empty($transfer_group_id)? NULL : $transfer_group_id,
            'previous_group' => empty($previous_group_id)? NULL : $previous_group_id,
			'problem' => empty($current_sub_category_id)? NULL : $current_sub_category_id,
            //'current_status' => empty($current_status_id)? NULL : $current_status_id
        );
        $transfer_status = $this->ticket_model->get_transfer_status($input);
        $transfer_status = json_decode($transfer_status,true);
        $transfer_status = $this->ticket_model->getStatusById($transfer_status);
        if ($transfer_status != 0)
        {
            echo json_encode($transfer_status);
        }
        exit();
    }

    public function ajax_get_customer_info()
    {
        if ($this->input->is_ajax_request()) {
            $customer_no = $this->input->post('account_no');
            $customer_info = $this->ticket_model->get_customer_info($customer_no);
            if ($customer_info != 0)
            {
                echo json_encode($customer_info);

                exit;
            }
        }
    }

    public function _add_ticket($custom_fields)
    {
        $created_at= time();
        $user_id = $this->user_id;
        $data_cst_info_customer = array('created_at' => $created_at, 'created_by' => $user_id);
        $data_cst_ticket= array('created_at' => $created_at, 'created_by' => $user_id);
        $upload_flag = FALSE;
        $ticket_id = "";
		$count = count($_FILES['upload']);
        foreach ($custom_fields as $values)
        {
            if ($this->input->post($values['name']) OR $count > 0)
            {
                if ($values['related_table'] == 2) //Customer Info
                {
                	$data_cst_info_customer[$values['name']] = $this->input->post($values['name']);
					if ($values['name'] == "account_no" OR $values['name'] == "product_phone" OR $values['name'] == "area_code_id")
					{
						$data_cst_ticket[$values['name']] = $this->input->post($values['name']);
					}
				}
                else if ($values['related_table'] == 1) //Ticket Info
                {
                	$data_cst_ticket[$values['name']] = $this->input->post($values['name']);
					if ($values['name'] == "account_no" OR $values['name'] == "product_phone" OR $values['name'] == "area_code_id")
					{
						$data_cst_info_customer[$values['name']] = $this->input->post($values['name']);
					}
                }
                else if ($values['related_table'] == 3)
                {
                	if ($values['name'] == "comment")
                    {
                    	$log_type = '9';
                    }
                    elseif ($values['name'] == "complaint_details")
                    {
                    	$log_type = '8';
                    }
                    if ( ! empty ($this->input->post($values['name']))) {
						$data_cst_textcomment = array('log_type_id' => $log_type, 'text' => $this->input->post($values['name']), 'created_at' => $created_at, 'created_by' => $user_id);
					}
                }
				else if ($values['related_table'] == 4)
                {
                	// upload files
                    if ( $count > 0)
                    {
                    	$upload_flag = TRUE;
                    }
                }

            }

        }
        $data_cst_info_customer['active'] = '1';
		$this->db->trans_start();
        $last_id_cst_info = $this->ticket_model->add_customer_info($data_cst_info_customer);

        $data_cst_ticket['customers_info_id'] =  $last_id_cst_info;
		if ($last_id_cst_info != FALSE)
		{
            $data_cst_ticket['previous_status'] = $data_cst_ticket['status_id'];
            $data_cst_ticket['previous_group_id'] = $data_cst_ticket['creator_group_id'];
			
	        $ticket_id = $this->ticket_model->add_items($data_cst_ticket);
	        if ($upload_flag === TRUE)
	        {
	            $this->upload_files($created_at, $ticket_id);
	        }
	        
			if ( ! empty($data_cst_textcomment))
			{
		        $data_cst_textcomment['ticket_id'] = $ticket_id;
		        $this->ticket_model->add_text($data_cst_textcomment);
	        }
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			// generate an error... or use the log_message() function to log your error
		    $this->session->set_flashdata('warning', 'The ticket not created, Please refer back to administration.');
			redirect('/tickets/create', 'refresh');
			exit();
		}

        return $ticket_id;
    }

    public function get_custom_fields($input_fun)
    {
		
        if (empty ($input_fun['get_access_fields']) OR empty ($input_fun['group_id']))
        {
            return FALSE;
        }
        //$groups_groups = $this->group_model->get_groups_groups($input_fun['group_id']);

		foreach ($input_fun['get_access_fields'] as $value_access_field)
		{
			if ($value_access_field['type'] == 'dropdown')
			{
				switch ($value_access_field['name']) {
                    case 'group_id':
                        if(isset($input_fun['transfer_group_input'])) {
							if($this->input->post('sub_category_id'))
							{
								$input_fun['transfer_group_input']['problem'] = $this->input->post('sub_category_id');	
							}
                            $transfer_groups = $this->ticket_model->get_ticket_transfer_groups($input_fun['transfer_group_input']);
                        }
                        $data[$value_access_field['name']] = $transfer_groups;
                        break;
					case 'creator_group_id':
						if ( empty($input_fun['creator_group_id']))
						{
							$input_fun['creator_group_id'] = $input_fun['group_id'];
						}
						$data[$value_access_field['name']] = $this->group_model->get_group_by_id($input_fun['creator_group_id']);
						break;
					case 'status_id':
						//$data[$value_access_field['name']] = $this->status_model->get_by_groups($input_fun['group_id']);
                        $transfer_status = "";
                        if(isset($input_fun['transfer_status_input']))
                        {
                            $transfer_status = $this->ticket_model->get_transfer_status($input_fun['transfer_status_input']);
                            $transfer_status = json_decode($transfer_status, true);

                            $transfer_status = $this->ticket_model->getStatusById($transfer_status);

                        }
						$data[$value_access_field['name']] = $transfer_status;
						break;
                    case 'manager_id':
                        $data[$value_access_field['name']] = $this->ticket_model->get_users_by_group($input_fun['group_id']);
                        break;
					case 'category_id':
						$data[$value_access_field['name']] = $this->category_model->get_by_groups($input_fun['creator_group_id']);
						break;
					case 'sub_category_id':
						$data[$value_access_field['name']] = $this->category_model->get_sub_by_category($input_fun['category_id']);
						break;
					case 'location_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all_parent('locations', $value_access_field['parent_id']);
						break;
                    case 'sub_location_id':
                        $data[$value_access_field['name']] = $this->ticket_model->get_all_parent('locations', $input_fun['location_id']);
                        break;
					case 'area_code_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('area_codes');
						break;
					case 'old_area_code_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('area_codes');
						break;
					case 'reseller_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('resellers');
						break;
					case 'complain_channel_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('complain_channels');
						break;
					case 'package_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('packages');
						break;
					case 'speed_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('speeds');
						break;
					case 'cpe_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('cpes');
						break;
					case 'cpe_request_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('cpe_requests');
						break;
					case 'exchange_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('exchanges');
						break;
					case 'option_pack_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('option_packs');
						break;
					case 'discount_reason_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('discount_reasons');
						break;
					case 'reply_id':
						$data[$value_access_field['name']] = $this->ticket_model->get_all('replies');
						break;
					case 'device_type':
                        $data[$value_access_field['name']] = $this->ticket_model->get_all('device_types');
                        break;
					case 'service_type':
                        $data[$value_access_field['name']] = $this->ticket_model->get_all('service_types');
                        break;
					case 'priority':
                        $data[$value_access_field['name']] = $this->ticket_model->get_all('priorities');
                        break;
					default:			
						break;
				}
			}
		}

		// Sort custum fields 'usort function'
		$data['get_access_fields'] = $input_fun['get_access_fields'];
        $data['ajax_location_id_url'] =  site_url('tickets/ajax_get_sub_location_id');
        $data['ajax_user_id_url'] = site_url('tickets/ajax_get_sub_users_id');
        $data['ajax_transfer_status_url'] = site_url('tickets/ajax_transfer_status');
        $data['js'] = array('tickets/js/create.js');

        return $data;
    }

	public function edit($ticket_id = '')
	{
    	if ($ticket_id == '' OR empty($this->ticket_model->check_ticket_access($ticket_id, 'edit_ticket')))
        {
        	redirect('/dashboard/', 'refresh');
			exit();
        }
		$count = count($_FILES['upload']);
		$this->load->helper('download');
        $tickets_data = $this->ticket_model->get_ticket_data($ticket_id);
		$input = array('form_type' => '1', 'category_id' => $tickets_data['category_id'],
						'sub_category_id' => $tickets_data['sub_category_id'], 'group_id' => $tickets_data['creator_group_id']);
		$this->load->module('custom_fields/custom_fields');
		$get_access_fields = $this->custom_fields->get_access_fields($input);
        $cmp = function($a, $b){ return $a['sort'] - $b['sort'];};
        (! empty($get_access_fields)) ? usort($get_access_fields, $cmp): '';

		// Edit Ticket if not closed
		if ( ! empty($tickets_data['status_id']) && $tickets_data['status_id'] != '1')
		{
            // Start insert
            if ($this->input->post('status_id') OR $this->input->post('comment') OR $this->input->post('group_id') OR $this->input->post('manager_id') )
            {
                $created_at = time();
                $created_by = $this->user_id;
                $status_id_post = $this->input->post('status_id');
                $group_id_post = $this->input->post('group_id');
                $manager_id_post = $this->input->post('manager_id');

                $status_name_post = $this->status_model->get_status_name($status_id_post);
                $group_name_post  = $this->group_model->get_group_name($group_id_post);
                $manager_name_post = $this->group_model->get_manager_name($manager_id_post);

                $comment_post = $this->input->post('comment');

                $tickets_logs_data = array();
                $tickets_logs_texts_data = array();
                $data_tickets = array();
                if ($status_id_post && ($status_id_post != $tickets_data['status_id']))
                {
                    $log_type_id = '1';
                    $tickets_logs_data[] = array(
                        'ticket_id' => $ticket_id,
                        'created_by' => $created_by,
                        'log_type_id' => $log_type_id,
                        'old_value' => (isset($tickets_data['status_name'])) ? $tickets_data['status_name'] : '',
                        'new_value' => $status_name_post,
                        'created_at' => $created_at,
                    );
                    $data_tickets['status_id'] = $status_id_post;
                }

                if ($group_id_post && ($group_id_post != $tickets_data['group_id']))
                {
                    $log_type_id = '2';
                    $tickets_logs_data[] = array(
                        'ticket_id' => $ticket_id,
                        'created_by' => $created_by,
                        'log_type_id' => $log_type_id,
                        'old_value' => (isset($tickets_data['group_name'])) ? $tickets_data['group_name'] : '',
                        'new_value' => $group_name_post,
                        'created_at' => $created_at,
                    );
					$data_tickets['previous_group_id'] = $tickets_data['group_id'];
                    $data_tickets['group_id'] = $group_id_post;
                }

                if ($manager_id_post && ($manager_id_post != $tickets_data['manager_id']))
                {

                    $log_type_id = '5';
                    $tickets_logs_data[] = array(
                        'ticket_id' => $ticket_id,
                        'created_by' => $created_by,
                        'log_type_id' => $log_type_id,
                        'old_value' => (isset($tickets_data['manager_name'])) ? $tickets_data['manager_name'] : '',
                        'new_value' => $manager_name_post,
                        'created_at' => $created_at,
                    );
                    $data_tickets['manager_id'] = $manager_id_post;
                }

                if ($comment_post)
                {
                	if(strlen($comment_post)  >= 500 )
					{
					 $this->session->set_flashdata('message', 'Comments character must be less than 500');
					 redirect('/tickets/edit/'.$ticket_id, 'refresh');
					 exit();
					}
                    $log_type_id = '9';
                    $tickets_logs_texts_data[] = array(
                        'ticket_id' => $ticket_id,
                        'created_by' => $created_by,
                        'log_type_id' => $log_type_id,
                        'text' => $comment_post,
                        'created_at' => $created_at,
                    );
                }

                // Insert in to table tickets
                if ( ! empty($data_tickets))
                {
                    $this->ticket_model->edit_ticket($ticket_id, $data_tickets);
                }
                // Insert in to table tickets_logs
                if ( ! empty($tickets_logs_data))
                {
                    $this->ticket_model->add_tickets_logs($tickets_logs_data);
                }
                // Insert in to table tickets_logs_texts
                if ( ! empty($tickets_logs_texts_data))
                {
                    $this->ticket_model->add_tickets_logs_texts($tickets_logs_texts_data);
                }
				// upload files
				
                if ($count > 0)
                {
	            	$this->upload_files($created_at, $ticket_id);
	       		}

                $this->session->set_flashdata('message', 'The ticket has been updated successfully');
				redirect('/tickets/edit/'.$ticket_id, 'refresh');
				exit();
            }
        }
		
        $supported_group_id = ( ! empty ($tickets_data['group_id'])) ? $tickets_data['group_id'] : '';
		$tickets_data['get_access_fields'] =  $get_access_fields;
		
        $tickets_data['transfer_group_input'] = '"problem"='.$tickets_data['sub_category_id'].' AND "current_group"='.$tickets_data['group_id'].' and "previous_group"='.$tickets_data['previous_group_id'].'
                                                and ("current_status" ='.$tickets_data['status_id'].' or "current_status" IS NULL)';

        $tickets_data['transfer_status_input'] =
            'current_group='.$tickets_data['group_id'].' and transfer_group='.$tickets_data['group_id'].' and previous_group='.$tickets_data['previous_group_id'].' and problem='.$tickets_data['sub_category_id'].' and current_status IS NULL';
			
		$data = $this->get_custom_fields($tickets_data);
        $data['previous_group'] = $tickets_data['previous_group_id'];
        $data['current_status'] = $tickets_data['status_id'];
		unset($tickets_data['get_access_fields']);
		unset($tickets_data['transfer_group_input']);
		unset($tickets_data['transfer_status_input']);
		$data['tickets_data'] = $tickets_data;

        $data['submit'] = array('id' => 'createEdit', 'name' => 'submit' ,'value' => 'Edit Ticket');
        if ( ! empty ($tickets_data['status_id']))
        {
            $tickets_data['status_id'] == '1' ? $data['submit']['hidden'] = 'true' : $data['submit']['class'] = 'btn btn-primary';
        }

        $data['files']                = $this->ticket_model->get_ticket_file_data($ticket_id);
        $data['ticket_id']            = $ticket_id;
        $data['ticket_logs']          = $this->ticket_model->get_ticket_logs($ticket_id);
		$data['js'] = array('tickets/js/create.js','bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
			'bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js', 'reports/js/calender_from_to.js');
			$data['css'] = array('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
			'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css');
        $data['main_content'] = 'tickets/edit';
        $data['title']        = 'Edit Ticket no.'.$ticket_id.' - Trouble ticketing System';
        $this->load->view('layouts/default',$data);
	}

/////////////////////view_ticket

  public function view($ticket_id = '')
    {
        if ($ticket_id == '' OR empty($this->ticket_model->check_ticket_access($ticket_id, 'view_ticket')))
        {
        	redirect('/dashboard/', 'refresh');
			exit();
        }
        $this->load->helper('download');
        $tickets_data = $this->ticket_model->get_ticket_data($ticket_id);

        $custom_fields_category_id = $tickets_data['sub_category_id'];
        $ticket_parent_category_id = $tickets_data['category_id'];
		$location_id = $tickets_data['location_id'];

        if ( empty ($tickets_data['category_id']))
        {
            $tickets_data['category_id'] = $tickets_data['sub_category_id'];
            unset($tickets_data['sub_category_id']);
        }
		
		if ( empty ($tickets_data['location_id']) && ! empty ($tickets_data['sub_location_id']))
        {
            $tickets_data['location_id'] = $tickets_data['sub_location_id'];
            unset($tickets_data['sub_location_id']);
        }
        $form_type = '1';
        $ticket_creator_group_id = ( ! empty ($tickets_data['creator_group_id'])) ? $tickets_data['creator_group_id'] : '';
        $supported_group_id = ( ! empty ($tickets_data['group_id'])) ? $tickets_data['group_id'] : '';

		$input = array('form_type' => '1', 'category_id' => $tickets_data['category_id'],
						'sub_category_id' => $tickets_data['sub_category_id'], 'group_id' => $tickets_data['creator_group_id']);
		$this->load->module('custom_fields/custom_fields');
		$get_access_fields = $this->custom_fields->get_access_fields($input);
		
        $cmp = function($a, $b){ return $a['sort'] - $b['sort'];};
        (! empty($get_access_fields)) ? usort($get_access_fields, $cmp): '';
		
		$tickets_data['get_access_fields'] =  $get_access_fields;
        $tickets_data['transfer_group_input'] = '"current_group"='.$tickets_data['group_id'].' and "previous_group"='.$tickets_data['previous_group_id'].'
                                                and ("current_status" ='.$tickets_data['status_id'].' or "current_status" IS NULL)';
        $tickets_data['transfer_status_input'] =
            'current_group='.$tickets_data['group_id'].' and transfer_group='.$tickets_data['group_id'].' and previous_group='.$tickets_data['group_id'].' and current_status IS NULL';

		$data = $this->get_custom_fields($tickets_data);
        $data['previous_group'] = $tickets_data['previous_group_id'];
        $data['current_status'] = $tickets_data['status_id'];
		unset($tickets_data['get_access_fields']);
		unset($tickets_data['transfer_group_input']);
		unset($tickets_data['transfer_status_input']);

	    $data['tickets_data'] = $tickets_data;
	    $data['files']                = $this->ticket_model->get_ticket_file_data($ticket_id);
	    $data['ticket_id']            = $ticket_id;
	    $data['ticket_logs']          = $this->ticket_model->get_ticket_logs($ticket_id);
	    $data['main_content'] = 'tickets/view';
	    $data['title']        = 'View Ticket no.'.$ticket_id.' - Trouble ticketing System';

	    $this->load->view('layouts/default',$data);

    }

}
