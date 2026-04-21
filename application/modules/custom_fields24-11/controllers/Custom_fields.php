<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Custom fields controller for the custom fields module
 *
 * @author		 OSS Dev Team
 * @package	 Modules\Custom_fields\Controllers
 */
class Custom_fields extends MY_Controller {
	
	/* 
	 * Constructor method 
	*/
	public function __construct()
	{
		parent::__construct();
		
		// Load the required classes
		$this->load->model('custom_field_model');
		$this->lang->load('custom_fields/custom_fields');
		$this->load->library('form_validation');
		$this->load->model('tickets/group_model');
	}

	/*
	 * Shows the custome fields for specific group and category that appear when create ticket.
	 * @access 	public
	 * @return 	void
	 */
	public function index() 
	{
		$form_type = 1;
		$this->input->post('group_id') ? $group_id = $this->input->post('group_id'): $group_id = '';

		if ($this->input->post('sub_category_id'))
		{
			$category_id = $this->input->post('sub_category_id');
		}
		else if ($this->input->post('category_id'))
		{
			$category_id = $this->input->post('category_id');
		}
		else
		{
			$category_id = '';
		}

		$this->form_validation->set_rules('group_id','Group','required');

		if ($this->input->is_ajax_request())
		{
			if ($this->input->post('group_id'))
			{
				$data['validation_types'] = $this->custom_field_model->get_validation_type();
				$data['edit_fields'] =  $this->custom_field_model->get_fields($form_type, $group_id, $category_id);
				$data['all_fields']  =  $this->custom_field_model->get_all();
				echo $this->load->view('custom_fields/partials/index',$data, true);
			}
			exit;
		}
		else if ($this->form_validation->run())
		{
			$custom_field_id 	= $this->input->post('custom_field_id');
			$validation_type_id = $this->input->post('validation_type_id');
			$sort 				= $this->input->post('sort');
			
			if($this->custom_field_model->save($form_type, $group_id, $custom_field_id, $category_id, $validation_type_id, $sort))
			{
				$this->session->set_flashdata('message', lang('custom_fields:message_group_saved_info'));
				$this->input->post('btnAction') === 'save_exit'
				? redirect('dashboard')
				: redirect('custom_fields');
			}
			else
			{
				$this->session->set_flashdata('info', lang('custom_fields:message_group_saved_error'));
				$this->input->post('btnAction') === 'save_exit'
				? redirect('dashboard')
				: redirect('custom_fields');
			}

		}
		else 
		{
			$data['group_id'] = array('type' => '', 'name' => 'group_id', 'id' => 'group_id','class' => 'form-control');
			$data['category_id'] = array('name' => 'category_id', 'id' => 'category_id', 'value' => '', 'class' => 'form-control');
			$data['sub_category_id'] = array('name' => 'sub_category_id', 'id' => 'sub_category_id', 'value' => '', 'class' => 'form-control');
			$data['groups'] = $this->group_model->get_all();
			$data['custom_fields']= $this->custom_field_model->get_all();
			$data['ajax_sub_category_url'] = site_url('tickets/categories/ajax_get_sub_categories');
			$data['ajax_category_url']     = site_url('tickets/categories/ajax_get_categories_by_group');
			$data['ajax_url']  	  =  site_url('custom_fields/index');
			$data['js'] 		  = array('custom_fields/js/index.js');
			$data['main_content'] = 'custom_fields/index';
	 		$data['title']        = 'List All custom fields - Trouble ticketing Systems';

	 		$this->load->view('layouts/default',$data);
		}
	}

	/*
	 * Shows the custome fields for specific group and category that appear when search tickets.
	 * @access 	public
	 * @return 	void
	 */
	public function groups_search() 
	{
		$form_type = 2;
		$this->input->post('group_id') ? $group_id = $this->input->post('group_id'): $group_id = '';
		$this->form_validation->set_rules('group_id','Group','required');

		if ($this->input->is_ajax_request())
		{
			if ($this->input->post('group_id'))
			{
				$data['validation_types'] = $this->custom_field_model->get_validation_type();
				$data['edit_fields'] =  $this->custom_field_model->get_fields($form_type, $group_id);
				$data['all_fields']  =  $this->custom_field_model->get_all();
				echo $this->load->view('custom_fields/partials/index',$data, true);
			}
			exit;
		}
		else if ($this->input->post('custom_field_id') && $this->form_validation->run())
		{
			$custom_field_id 	= $this->input->post('custom_field_id');
			$validation_type_id = $this->input->post('validation_type_id');
			$sort 				= $this->input->post('sort');
			
			if($this->custom_field_model->save($form_type, $group_id, $custom_field_id, $category_id, $validation_type_id, $sort))
			{
				$this->session->set_flashdata('message', lang('custom_fields:message_group_saved_success'));
				$this->input->post('btnAction') === 'save_exit' 
				? redirect('dashboard')
				: redirect('custom_fields/groups_search');
			}
		}
		else 
		{
			$data['group_id'] = array('type' => '', 'name' => 'group_id', 'id' => 'group_id','class' => 'form-control');
			$data['groups'] = $this->group_model->get_all();
			$data['custom_fields']= $this->custom_field_model->get_all();
			$data['ajax_url']  	  =  site_url('custom_fields/groups_search');
			$data['js'] 		  = array('custom_fields/js/groups_search.js');
			$data['main_content'] = 'custom_fields/groups_search';
	 		$data['title']        = 'List All custom fields - Trouble ticketing Systems';
	 		$this->load->view('layouts/default',$data);
		}
	}


	/**
	 * Shows the custome fields for specific group and category that appear when Edit tickets.
	 * @access 	public
	 * @param   array
	 * @return 	array
	 */
	public function get_access_fields($input_fun)
	{
		if (empty($input_fun))
		{
			return FALSE;
		}
		if(! isset($input_fun['type']))
		{
			if ( ! empty($input_fun['sub_category_id']))
			{
				$input['cfg.ticket_category_id'] = $input_fun['sub_category_id'];
			}
		}
		else if( ! empty($input_fun['category_id']))
		{
			$input['cfg.ticket_category_id'] = $input_fun['category_id'];
		}

		$input['cfg.groups_id'] = $input_fun['group_id'];
		$input['cfg.form_type'] = $input_fun['form_type'];

		$res = $this->custom_field_model->get_access_fields($input);

		return $res;
	}
}
