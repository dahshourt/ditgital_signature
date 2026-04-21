<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Roles controller for the groups module
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Groups\Controllers
 *
 */
class Groups extends MY_Controller
{

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = 'group';
		
		$this->load->database();
		$this->load->helper(array('url','language'));
		// Load the required classes
		$this->load->library('form_validation');

		$this->load->model('Group_model');
		$this->lang->load('auth/auth');
		$this->lang->load('permissions/permissions');
		$this->lang->load('buttons');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'groups:name',
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'description',
				'label' => 'groups:description',
				'rules' => 'trim|required|max_length[250]'
			)
		);
	}

	/**
	 * Create a new group role
	 */
	public function index()
	{

		$data['groups'] = $this->Group_model->get_all();
		$data['main_content'] = 'groups/index';
 		$data['title']        = 'Groups';
		$this->load->view('layouts/default',$data);
	}

	/**
	 * Create a new group role
	 */
	public function add()
	{
		$group = new stdClass();

		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			if ($this->form_validation->run())
			{
				if ($id = $this->Group_model->insert($this->input->post()))
				{
					// Fire an event. A new group has been created.
					Events::trigger('group_created', $id);

					$this->session->set_flashdata('success', sprintf('groups:add_success', $this->input->post('name')));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf('groups:add_error', $this->input->post('name')));
				}

				redirect('admin/groups');
			}
		}

		$group = new stdClass();

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$group->{$rule['field']} = set_value($rule['field']);
		}

		$this->template
			->title($this->module_details['name'], lang('groups:add_title'))
			->set('group', $group)
			->build('admin/form');
	}


	/**
	 * Edit a group role
	 *
	 * @param int $id The id of the group.
	 */
	public function edit($id = 0)
	{
		$group = $this->Group_model->get($id);

		// Make sure we found something
		$group or redirect('admin/groups');

		if ($_POST)
		{
			// Got validation?
			if ($group->name == 'admin' or $group->name == 'user')
			{
				//if they're changing description on admin or user save the old name
				$_POST['name'] = $group->name;
				$this->form_validation->set_rules('description', lang('groups:description'), 'trim|required|max_length[250]');
			}
			else
			{
				$this->form_validation->set_rules($this->validation_rules);
			}

			if ($this->form_validation->run())
			{
				if ($success = $this->Group_model->update($id, $this->input->post()))
				{
					// Fire an event. A group has been updated.
					Events::trigger('group_updated', $id);
					$this->session->set_flashdata('success', sprintf(lang('groups:edit_success'), $this->input->post('name')));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('groups:edit_error'), $this->input->post('name')));
				}

				redirect('admin/groups');
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('groups:edit_title'), $group->name))
			->set('group', $group)
			->build('admin/form');
	}

	/**
	 * Delete group role(s)
	 *
	 * @param int $id The id of the group.
	 */
	public function delete($id = 0)
	{
		if ($success = $this->Group_model->delete($id))
		{
			// Fire an event. A group has been deleted.
			Events::trigger('group_deleted', $id);

			$this->session->set_flashdata('success', lang('groups:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('groups:delete_error'));
		}

		redirect('admin/groups');
	}
}
