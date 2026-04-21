<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Charts controller for the charts module
 *
 * @author		 OSS Dev Team
 * @package	 Modules\Charts\Controllers
 */
class Charts extends MY_Controller {
	
	/**
	 * Constructor method
	 */
	function __construct() 
	{
		parent::__construct();
		
		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model('charts_model');
	}

	/**
	 * Chart of tickets per status
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function tickets_status() {
		if ($this->input->is_ajax_request())
		{
			$tickets_each_status = $this->charts_model->get_tickets_each_status();
			echo json_encode($tickets_each_status);
			exit();
		}
		else 
		{
			$data['js'] = array('bower_components/flot/jquery.flot.js', 'bower_components/flot/jquery.flot.categories.js', 'charts/js/tickets_status.js');
			$data['css'] = array('charts/css/examples.css');
			$data['main_content'] = 'charts/tickets_status';
	 		$data['title']        = 'Tickets per status';
	
	 		$this->load->view('layouts/default',$data);
		}
	}
	
	/**
	 * Chart of tickets per category
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function tickets_category() {
		if ($this->input->is_ajax_request())
		{
			$tickets_each_category = $this->charts_model->get_tickets_each_category();
			echo json_encode($tickets_each_category);
			exit();
		}
		else 
		{
			$data['js'] = array('bower_components/flot/jquery.flot.js', 'bower_components/flot/jquery.flot.pie.js', 'charts/js/tickets_category.js');
			$data['css'] = array('charts/css/examples.css', 'charts/css/tickets_category.css');
			$data['main_content'] = 'charts/tickets_category';
	 		$data['title']        = 'Tickets per category';
	
	 		$this->load->view('layouts/default',$data);
 		}
	}

	/**
	 * Chart of tickets per group
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function tickets_group() {
		if ($this->input->is_ajax_request())
		{
			$tickets_each_group = $this->charts_model->get_tickets_each_group();
			echo json_encode($tickets_each_group);
			exit();
		}
		else 
		{
			$data['js'] = array('bower_components/flot/jquery.flot.js', 'bower_components/flot/jquery.flot.pie.js', 'charts/js/tickets_category.js');
			$data['css'] = $data['css'] = array('charts/css/examples.css', 'charts/css/tickets_category.css');
			$data['main_content'] = 'charts/tickets_category';
	 		$data['title']        = 'Tickets per group';
	
	 		$this->load->view('layouts/default',$data);
 		}
	}

	/**
	 * Chart of tickets per created group
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function tickets_created_by_group() {
		$tickets_each_group = $this->charts_model->get_tickets_each_created_by_group();
		if ($this->input->is_ajax_request())
		{
			$tickets_each_created_by_group = $this->charts_model->get_tickets_each_created_by_group();
			echo json_encode($tickets_each_created_by_group);
			exit();
		}
		else 
		{
			$data['js'] = array('bower_components/flot/jquery.flot.js', 'bower_components/flot/jquery.flot.pie.js', 'charts/js/tickets_category.js');
			$data['css'] = array('charts/css/examples.css', 'charts/css/tickets_category.css');
			$data['main_content'] = 'charts/tickets_category';
	 		$data['title']        = 'Tickets per created by group';
	
	 		$this->load->view('layouts/default',$data);
 		}
	}

}
