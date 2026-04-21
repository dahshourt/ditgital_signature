<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Charts model
 * 
 * @author		TE Data OSS Dev Team
 * @package		Modules\Charts\Models
 */
class Charts_model extends CI_Model {
	
	/**
     * Get a tickets for each category
	 * 
	 * @param no
	 * @return array
     */
	public function get_tickets_each_category()
	{
		$result = $this->db
					->select(' tc.name  name, COUNT(t.id)  total_tickets')
                	->where('status_id != ', '1')
					->join('tickets_categories  tc', 't.category_id = tc.id')
					->group_by('t.category_id')
                	->get('tickets  t')
					->result_array();
		
		return $result;
	}
	
	/**
     * Get a tickets for each status
	 * 
	 * @param no
	 * @return array
     */	
	public function get_tickets_each_status()
	{
		$result = $this->db
					->select(' ts.name  name, COUNT(t.id)  total_tickets')
                	->where('status_id != ', '1')
					->join('tickets_statuses  ts', 't.status_id = ts.id')
					->group_by('t.status_id')
                	->get('tickets  t')
					->result_array();
					
		return $result;
	}
	
	 /**
     * Get a tickets for each group
	 * 
	 * @param no
	 * @return array
     */
	public function get_tickets_each_group()
	{
		$result = $this->db
					->select(' g.name  name, COUNT(t.id)  total_tickets')
                	->where('status_id != ', '1')
					->join('groups  g', 't.group_id = g.id')
					->group_by('t.group_id')
                	->get('tickets  t')
					->result_array();
					
		return $result;
	}

	/**
     * Get a tickets for each created group
	 * 
	 * @param no
	 * @return array
     */
	public function get_tickets_each_created_by_group()
	{
		$result = $this->db
					->select(' g.name  name, COUNT(t.id)  total_tickets')
					->join('users  u', 't.created_by = u.id')
					->join('users_groups  ug', 'ug.user_id = u.id')
					->join('groups  g', 'ug.group_id = g.id')
					->group_by('g.id')
           	     	->get('tickets  t')
					->result_array();
					
		return $result;
	}

}
