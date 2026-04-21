<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statuses extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('status_model');
		$this->load->model('group_model');
	}
	public function add()
	{
		$user_id = $this->user_id;
		$created_at = time();
		$this->form_validation->set_rules('name','Status','required');
		if($this->form_validation->run())
		{
			$data = array('name' => $this->input->post('name'),	'active' => '1', 'created_at' => $created_at, 'created_by' => $user_id,);
			$this->status_model->add($data);
		}
		$data['status'] = array('name'  => 'status_id',	'id'    => 'status_id',	'class' => 'form-control');
		$data['name'] = array('name'  => 'name',	'id'    => 'name',	'class' => 'form-control');
		$data['statuses']     		  = $this->status_model->get_all();
		$data['main_content'] = 'tickets/statuses/add_new';
 		$data['title']        = 'Add New Status';
 		$this->load->view('layouts/default',$data);
	}
	
	public function status_to_group()
	{
		$user_id = $this->user_id;
		$created = time();
		$this->form_validation->set_rules('supported_group','Supported Group','required');
		$this->form_validation->set_rules('status_id','Status','required');
		if($this->form_validation->run())
		{
			$data = array('group_id' => $this->input->post('supported_group'), 'status_id' => $this->input->post('status_id'), 'active' => '1',	'created_at' => $created, 'created_by' => $user_id,);
			$this->status_model->assign_to_groups($data);
		}
		$data['supported_group'] = array('name'  => 'supported_group', 'id'    => 'supported_group',	'class' => 'form-control');
		$data['status'] = array('name'  => 'status_id',	'id'    => 'status_id',	'class' => 'form-control');
		$data['groups']   		      = $this->group_model->get_all();
		$data['statuses']     		  = $this->status_model->get_all();
		$data['main_content'] = 'tickets/statuses/add_to_group';
 		$data['title']        = 'Assign Status To Group';
 		$this->load->view('layouts/default',$data);
	}

}