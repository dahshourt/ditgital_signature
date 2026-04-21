<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class groups extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('group_model');
		$this->lang->load('groups/group');
	}
	public function group()
	{
		$user_id = $this->user_id;
		$created_at = time();
		$this->form_validation->set_rules('group_id','Group','required');
		$this->form_validation->set_rules('to_group_id','Transferred Group','required');
		if($this->form_validation->run())
		{
			$data = array('group_id' => $this->input->post('group_id'),'to_group_id' => $this->input->post('to_group_id'),'created_at' => $created_at,'created_by' => $user_id,);
			$this->group_model->add_transferred_group($data);
			$this->session->set_flashdata('message', 'The action has been created successfully.');
            redirect("tickets/groups/group");
		}

		$data['group_id']    = array('name' => 'group_id','id' => 'group_id','class' => 'form-control');
		$data['to_group_id'] = array('name' => 'to_group_id','id' => 'to_group_id','class' => 'form-control');
		$data['groups']   	 = $this->group_model->get_all();
		$data['results']     = $this->group_model->get_all_groups_groups();
		$data['edit_url']    = 'tickets/groups/edit_group/';
		$data['delete_url']  = 'tickets/groups/delete_groups_groups/';
		$data['th'] 		 = array('groups:group', 'groups:transferred_group');
		$data['js'] 	     = array('bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js');
		$data['main_content']= 'tickets/groups/group_group';
 		$data['title']       = 'Group Transfer To Groups';
 		$this->load->view('layouts/default',$data);
	}

	 /**
	 * Delete group transfer to group.
	 *
	 * @param int $id.
	 * @return void
	 */
	public function delete_groups_groups($id)
	{
		if ( ! empty($id))
		{
			$this->group_model->delete_groups_groups($id);
			$this->session->set_flashdata('message', 'Deleted successfully.');
		}
	        redirect("tickets/groups/group");
	}
	
}