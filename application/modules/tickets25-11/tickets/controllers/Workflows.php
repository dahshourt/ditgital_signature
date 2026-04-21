<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Workflows extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('tickets/Workflow_model');
		$this->load->model('tickets/category_model');
		$this->load->model('tickets/group_model');
		$this->load->model('tickets/status_model');

	}
	
	public function index()
    {
		$workflows = $this->Workflow_model->index();
		$data['name'] = array('name'  => 'name',	'id'    => 'name',	'class' => 'form-control');
		$data['main_content'] = 'tickets/workflows/index';
 		$data['title']        = 'List WorkFlows';
		$data['js'] = array('tickets/js/create.js','bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
			'bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js', 'reports/js/calender_from_to.js');
		$data['css'] = array('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
			'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css');
		$data['workflows']		      = $workflows;
 		$this->load->view('layouts/default',$data);
	}
	
	public function create()
    {
		$data['name'] = array('name'  => 'name',	'id'    => 'name',	'class' => 'form-control');
		$data['main_content'] = 'tickets/workflows/create';
 		$data['title']        = 'Add Workflow';
		$data['groups'] = $this->group_model->get_all();
		$data['problems'] = $this->category_model->get_all_sub_cats();
		$data['statuses'] = $this->status_model->get_all();
		$data['js'] = array('tickets/js/create.js','select2/select2.min.js','bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
			'bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js', 'reports/js/calender_from_to.js');
		$data['css'] = array('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
			'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css','select2/select2.min.css');
		if (!empty($this->session->flashdata('message'))) {

			$data['message'] = $this->session->flashdata('message');
		} elseif (!empty($this->session->flashdata('error'))) {

			$data['error'] = $this->session->flashdata('error');
		}	
 		$this->load->view('layouts/default',$data);
	}
	
	public function store()
	{
			$this->form_validation->set_rules('current_group', 'Current Group', 'required');
			//$this->form_validation->set_rules('transfer_group', 'Transfer Group', 'required');
			$this->form_validation->set_rules('problem', 'problem', 'required');
			$this->form_validation->set_rules('transfer_status[]', 'transfer status', 'required');
			if($this->form_validation->run() == FALSE)
			{
				
				$this->session->set_flashdata('error', validation_errors());
				return redirect(site_url('/tickets/workflows/create'), 'refresh');
			}
			 $data = array(
				"current_group"=> $this->input->post('current_group'),
				"transfer_group"=> $this->input->post('transfer_group'),
				"problem"=> $this->input->post('problem'),
			);
			if($this->input->post('previous_group'))
			{
				$data['previous_group'] = $this->input->post('previous_group');
			}
			if($this->input->post('transfer_status'))
			{
				$data['transfer_status'] =json_encode($this->input->post('transfer_status'));
			}
			$this->Workflow_model->add($data);
			return redirect(site_url('/tickets/workflows/index'), 'refresh');
			
	}
	
	public function edit($id)
    {
		$workflow = $this->Workflow_model->workflow_data($id);
		
		$data['name'] = array('name'  => 'name',	'id'    => 'name',	'class' => 'form-control');
		$data['main_content'] = 'tickets/workflows/edit';
 		$data['title']        = 'Edit Workflow';
		$data['groups'] = $this->group_model->get_all();
		$data['problems'] = $this->category_model->get_all_sub_cats();
		$data['statuses'] = $this->status_model->get_all();
		$data['js'] = array('tickets/js/create.js','select2/select2.min.js','bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
			'bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js', 'reports/js/calender_from_to.js');
		$data['css'] = array('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
			'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css','select2/select2.min.css');
		$data['workflow']		      = $workflow;
		if (!empty($this->session->flashdata('message'))) {

			$data['message'] = $this->session->flashdata('message');
		} elseif (!empty($this->session->flashdata('error'))) {

			$data['error'] = $this->session->flashdata('error');
		}	
 		$this->load->view('layouts/default',$data);
	}
	
	public function update()
	{
			$id = $this->input->post('id');
			$this->form_validation->set_rules('current_group', 'Current Group', 'required');
			//$this->form_validation->set_rules('transfer_group', 'Transfer Group', 'required');
			$this->form_validation->set_rules('problem', 'problem', 'required');
			$this->form_validation->set_rules('transfer_status[]', 'transfer status', 'required');
			if($this->form_validation->run() == FALSE)
			{
				
				$this->session->set_flashdata('error', validation_errors());
				return redirect(site_url('/tickets/workflows/edit/'.$id.''), 'refresh');
			}
			 $data = array(
				"current_group"=> $this->input->post('current_group'),
				"transfer_group"=> $this->input->post('transfer_group'),
				"problem"=> $this->input->post('problem'),
			);
			if($this->input->post('previous_group'))
			{
				$data['previous_group'] = $this->input->post('previous_group');
			}
			if($this->input->post('transfer_status'))
			{
				$data['transfer_status'] =json_encode($this->input->post('transfer_status'));
			}
			$this->Workflow_model->edit($id,$data);
			return redirect(site_url('/tickets/workflows/index'), 'refresh');
			
	}
	
	public function view()
    {
		$workflows = $this->Workflow_model->index();
		$data['name'] = array('name'  => 'name',	'id'    => 'name',	'class' => 'form-control');
		$data['main_content'] = 'tickets/workflows/index';
 		$data['title']        = 'List WorkFlows';
		$data['js'] = array('tickets/js/create.js','bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
			'bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js', 'reports/js/calender_from_to.js');
		$data['css'] = array('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
			'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css');
		$data['workflows']		      = $workflows;
 		$this->load->view('layouts/default',$data);
	}
}