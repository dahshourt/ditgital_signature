<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		TEData OSS Dev Team
 * @package		Modules\Tickets\Models
 */
class Workflow_model extends MY_Model
{
	
	public function __construct() 
	{
		parent::__construct(); 
	}
	
	public function index()
	{
		
		$result = $this->db
					->select('tw.id,tw.active,tc.name as category_name,p_group.name as p_name,c_group.name as c_name,t_group.name as t_name')
					->from('ticket_workflows tw')
					->join('groups p_group', 'p_group.id = tw.previous_group', 'left')
					->join('groups c_group', 'c_group.id = tw.current_group', 'left')
					->join('groups t_group', 'c_group.id = tw.transfer_group', 'left')
					->join('tickets_categories tc', 'tc.id = tw.problem', 'left')
					->get()
					->result();
					
		return $result;
	}
	
	public function workflow_data($id)
	{
		
		$result = $this->db
					->select('*')
					->from('ticket_workflows')
					->where('id', $id)
					->get()
					->row_array();
					
		return $result;
	}
	
	public function add($data)
	{
		$this->db->insert('ticket_workflows', $data);
	}
	
	public function edit($id, $data)
	{
		$this->db->where('id', $id)->update('ticket_workflows', $data);
	}
	

}