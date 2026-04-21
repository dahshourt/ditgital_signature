<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reports Controller
 *
 * All date/time operations use DateTimeZone('Africa/Cairo') explicitly
 * to ensure correct DST (Daylight Saving Time) handling for Egypt.
 * Egypt observes DST (UTC+3 in summer, UTC+2 in winter).
 * Never use raw fixed offsets — always use the named timezone.
 */
class Reports extends MY_Controller {
	
	public $file_path;
	
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Reports_model');
		$this->load->model('tickets/Ticket_model');
		$this->lang->load('tickets/tickets');
	}
	
	// Number Of Transfered Tickets
	public function index() {
		$data['main_content'] = 'welcome/welcome_message';
 		$data['title']        = 'Number of transferred report';
 		$this->load->view('layouts/default',$data);
	}

	// Tickets per statuses
	public function tickets_report() {
		$user_group_id = $this->group_id['id'];
		$this->form_validation->set_rules('created_from','Creation date (From)','required');
		$this->form_validation->set_rules('created_to','Creation date (To)','required');
		if($this->form_validation->run())
		{
			// Use DateTimeZone('Africa/Cairo') to correctly handle DST.
			// strtotime() alone uses the server TZ which may be a fixed offset
			// and would NOT automatically adjust for DST transitions.
			$tz = new DateTimeZone('Africa/Cairo');

			$dt_from = new DateTime($this->input->post('created_from'), $tz);
			$created_from = $dt_from->getTimestamp();

			$dt_to = new DateTime($this->input->post('created_to'), $tz);
			$created_to = $dt_to->getTimestamp();

			$data_search = array('created_from' => $created_from, 'created_to' => $created_to);
			
			if ($this->input->post('area_code_id'))
			{
				$data_search['area_code_id'] = $this->input->post('area_code_id');
			}
			if ($this->input->post('product_phone'))
			{
				$data_search['product_phone'] = $this->input->post('product_phone');
			}
			if ($this->input->post('status_id'))
			{
				$data_search['status_id'] = $this->input->post('status_id');
			}
			
			$ticket_by_search_res = $this->Ticket_model->get_ticket_by_search($data_search);
			
			$data['search_tickets'] = $ticket_by_search_res->result();
			$this->session->set_userdata('search_tickets_export', $this->db->last_query());
			$data['search_tickets_export'] = $ticket_by_search_res;
		}
		
		$data['created_from'] = array(
					'type'  => '',
					'name'  => 'created_from',
					'id'    => 'created_from',
					'value' => $this->form_validation->set_value('created_from'),
					'class' => 'form-control'
		);
		$data['created_to'] = array(
					'type'  => '',
					'name'  => 'created_to',
					'id'    => 'created_to',
					'value' => $this->form_validation->set_value('created_to'),
					'class' => 'form-control'
		);
		$data['area_code_id'] = array(
					'type'  => '',
					'name'  => 'area_code_id',
					'id'    => 'area_code_id',
					'value' => $this->form_validation->set_value('area_code_id'),
					'class' => 'form-control'
		);
		$data['product_phone'] = array(
					'type'  => '',
					'name'  => 'product_phone',
					'id'    => 'product_phone',
					'value' => $this->form_validation->set_value('product_phone'),
					'class' => 'form-control'
		);
		$data['status'] = array(
					'type'  => '',
					'name'  => 'status_id',
					'id'    => 'status_id',
					'value' => $this->form_validation->set_value('status_id'),
					'class' => 'form-control'
		);
		$this->load->model('tickets/Ticket_model');
		$data['statuses']     		  = $this->Ticket_model->get_status($user_group_id);
		$data['js'] = array('bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
		'bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js', 'reports/js/calender_from_to.js');
		$data['css'] = array('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
		'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css', 'bower_components/datatables-responsive/css/dataTables.responsive.css');
		$data['main_content'] = 'reports/ticket_report';
 		$data['title']        = 'Tickets Reports - Trouble ticketing System';
 		
 		$this->load->view('layouts/default',$data);
	}

	public function export_csv()
	{
		$query = $this->db->query($this->session->search_tickets_export);
		$this->load->helper('file');
		$this->file_path = realpath(APPPATH . '../uploads/csv');	
		$this->load->dbutil();
		$delimiter = ",";
		$newline = "\r\n";
		$new_report = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		
		// write file
		write_file($this->file_path . '/csv_file.csv', $new_report);
		
		//force download from server
		$this->load->helper('download');
		$data = file_get_contents($this->file_path . '/csv_file.csv');

		// Use DateTime with Africa/Cairo timezone to get DST-correct date for filename.
		$now = new DateTime('now', new DateTimeZone('Africa/Cairo'));
		$name = 'Tickets-' . $now->format('d-m-Y') . '.csv';
		force_download($name, $data);
	} 
}
