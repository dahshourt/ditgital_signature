<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends MY_Controller
{

	/**
	 * Constructor method.
	 *
	 * As well as everything in the Admin_Controller::__construct(),
	 * this additionally loads the models and language strings for
	 * permission and group.
	 */
	public function __construct()
	{
	    parent::__construct();		
		$this->load->model('groups/group_model');
	   	$this->load->model('permission_model');
		$this->load->config('auth/ion_auth', TRUE);
		$this->lang->load('permissions/permissions');
	    $this->lang->load('groups/group');
		$this->lang->load('auth/auth');
	}

	/**
	 * The main index page in the administration.
	 *
	 * Shows a list of the groups.
	 */
	public function index()
	{
		$data['groups'] = $this->group_model->get_all();
		$data['js'] = array('bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js');
		$data['css'] = array('bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css');
		$data['main_content'] = 'permissions/index';
 		$data['title']        = lang('index_heading');
		$data['admin_group']  =  $this->config->item('admin_group', 'ion_auth');
		$this->load->view('layouts/default',$data);
	}

	/**
	 * Shows the permissions for a specific user group.
	 *
	 * @param int $group_id The id of the group to show permissions for.
	 */
	public function group($group_id = '')
	{
		$this->load->library('form_validation');
		if ($this->input->is_ajax_request())
		{
			$group_access = $this->input->post('group_id');
			$group_id = $this->input->post('my_group');
		}
		else 
		{
			$group_access = $group_id;
		}

		// Get the group data
		$group = $this->group_model->get($group_id);
		
		// See if this is the admin group
		$group_is_admin = (bool) ($this->config->item('admin_group', 'ion_auth') == $group->name);

		// Get the groups permission rules (no need if this is the admin group)
		$edit_permissions = ($group_is_admin) ? array() : $this->permission_model->get_group($group_id, $group_access);
		$data['group_id'] = array('type'  => '', 'name'  => 'group_id', 'id'    => 'group_id','class' => 'form-control');
		$data['my_group'] = array('name'  => 'my_group', 'id'    => 'my_group', 'disabled' => 'disabled', 'class' => 'form-control');
		$data['group_selected_value'] = $group_id;
		
		//$this->load->model('tickets/Ticket_model');
		$data['groups']   	    	= $this->group_model->get_all();
		$data['js'] 				= array('permissions/js/group.js', 'permissions/js/ajax_group_permissions.js');
		
		if ($this->input->is_ajax_request())
		{
			if ($this->input->post('group_id'))
			{
				$data['edit_permissions']	=  $edit_permissions;
				$data['group_is_admin']  	=  $group_is_admin;
				$data['permission_modules'] =  $this->permission_model->list_roles();
				echo $this->load->view('permissions/partials/group',$data, true);
			}
			exit;
		}
		else
		{
			// If the group data could not be retrieved
			if ( ! $group) {
				// Set a message to notify the user.
				$this->session->set_flashdata('error', lang('permissions:message_no_group_id_provided'));
				// Send him to the main index to select a proper group.
				redirect('permissions');
			}
			if ($_POST)
			{
				//$modules = $this->input->post('modules');
				$roles = $this->input->post('module_roles');
				//$group_id = $this->input->post('my_group');
				$group_access = $this->input->post('group_id');
				// Save the permissions.
				if ($this->permission_model->save($group_id, $roles, $group_access)) {
					$this->session->set_flashdata('message', lang('permissions:message_group_saved_success'));
					$this->input->post('btnAction') === 'save_exit' 
					? redirect('permissions')
					: redirect('permissions/group/'.$group_id);
				}
				
			}
			$data['main_content']    	= 'permissions/group';
 			$data['title']        	 	= lang('index_heading');
			$data['edit_permissions']	=  $edit_permissions;
			$data['group_is_admin']  	=  $group_is_admin;
			$data['ajax_url']  			=  site_url('permissions/group');
			$data['group']        	 	=  $group;
			$data['permission_modules'] =  $this->permission_model->list_roles();
 			$this->load->view('layouts/default',$data);
		}
	}

}