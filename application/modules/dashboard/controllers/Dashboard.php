<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard controller for the historical data
 *
 * @author	TEData OSS Dev Team
 * @package	application\Modules\Dashboard\Controllers
 *
 */
class Dashboard extends MY_Controller
{

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Load the required classes
		$this->load->model('Dashboard_model');
	}

	/**
	 * Show the following Dashboard: 
	 * 		Count assigned tickets for the logged in user
	 * 		Count assigned tickets for the logged in group
	 * 
	 * @param no
	 * @return void
	 */
	public function index()
	{
		$group_id = $this->group_id['id'];
		$data['count_support_tickets'] = $this->Dashboard_model->count_user_tickets($this->user_id);
		$data['count_group_tickets'] = $this->Dashboard_model->count_group_tickets($group_id);
		$data['main_content'] = 'dashboard/index';
 		$data['title']        = 'Dashboard';
		
		$this->load->view('layouts/default',$data);
	}

}
