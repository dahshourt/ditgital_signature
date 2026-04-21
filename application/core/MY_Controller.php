<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Code here is run before ALL controllers
 */
class MY_Controller extends MX_Controller
{
	
	public $data;
	public $user_id;
	public $user_name;
	public $groups;
	public $group_id;
	public $group_permissions;
	public $menu_val;
	
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('global_lang');
		if ( ! $this->session->userdata('user_id') && ($this->router->method != 'login'))
		{
			redirect('/auth/login', 'refresh');
		}
		$this->user_id = $this->session->user_id;
		$this->user_name = $this->session->username;
		if ( ! $this->session->groups && $this->router->method != 'login')
		{
			$this->load->model('auth/Ion_auth_model');
			$this->load->model('permissions/permission_model');
			$group_data = $this->Ion_auth_model->get_users_groups()->result_array();
			foreach ($group_data as $key => $value) {
				$this->groups['id'] = $value['id'];
				$this->groups['name'] = $value['name'];
				$this->groups['description'] = $value['description'];
				$this->groups['type_id'] = $value['type_id'];
			}
			$res_permissions = $this->permission_model->get_group_permissions($this->groups['id']);
			$this->group_permissions = $res_permissions;
			foreach($res_permissions as $k => $v) 
			{
	    		foreach($res_permissions as $key => $value) 
	    		{
			        if($v['menu'] == '' || ($k != $key && $v['menu'] == $value['menu'] && $v['rule_slug'] == $value['rule_slug']))
			        {
			             unset($res_permissions[$k]);
			        }
	    		}
			}
			$this->session->set_userdata('groups', $this->groups);
			$this->session->set_userdata('group_id', $this->groups);
			$this->session->set_userdata('group_permissions', $this->group_permissions);
			$this->session->set_userdata('menu_val', $res_permissions);
		}
		else
		{
			$this->groups = $this->session->groups;
			$this->group_id = $this->session->groups;
			$this->group_permissions = $this->session->group_permissions;
			$this->menu_val = $this->session->menu_val;
		}
		
		switch (ENVIRONMENT)
		{
			case 'development':
				$this->output->enable_profiler(TRUE);
				$this->benchmark->mark('my_controller_start');
				$this->benchmark->mark('my_controller_end');
			break;
		
			case 'testing':
				$this->output->enable_profiler(TRUE);
				$this->benchmark->mark('my_controller_start');
				$this->benchmark->mark('my_controller_end');
			break;

			case 'production':
				// get specific users from DB in order to show benchmarks.
				$this->load->model('debug/debug_model');
				$bechmark_users = $this->debug_model->get_benchmark_users();
				foreach ($bechmark_users as $key => $bechmark_user) {
					if (in_array($_SESSION['user_id'], $bechmark_user))
					{
						$this->output->enable_profiler(TRUE);
						$this->benchmark->mark('my_controller_start');
						$this->benchmark->mark('my_controller_end');
					}
				}
			break;
		}
	}
	
	function ci()
	{
		return get_instance();
	}
}