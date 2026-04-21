<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Reports_model extends CI_Model {
	
	function __construct() 
	{
		$this->load->database();
	}

	// Groups Tickets View
	function sla($group_id, $from, $to)
	{
		$this->db->select('sla.itemId, sla.`status`, sla.slaTime, item_title');
		$this->db->from('itemSLA  sla');
		$this->db->where('sla.slaTime >', $from);
		$this->db->where('sla.slaTime <', $to);
		$this->db->where('sla.groupId', $group_id);
		$this->db->join('aims_items  ai', 'ai.item_id = sla.itemId', 'left');
		$this->db->order_by('sla.itemId', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	

	// Number Of Transfered Tickets
	function no_of_transferred_tickets($conditions_value, $group_by_value)
	{

		// Check conditions
		if (array_key_exists('start_date', $conditions_value)) {
			$this->db->where('transfareDate >=' , $conditions_value['start_date']);
		}
		if (array_key_exists('end_date', $conditions_value)) {
			$this->db->where('transfareDate <=' , $conditions_value['end_date']);	
		}
		if (array_key_exists('status_id', $conditions_value)) {
			$this->db->where('status', $conditions_value['status_id']);
		}
		if (array_key_exists('zone_id', $conditions_value)) {
			$this->db->where('z.Id', $conditions_value['zone_id']);
		}
		
		if (array_key_exists('to_all_group', $conditions_value)) {
			$this->db->where_in('fromGroupId', $conditions_value['to_all_group']);
		} else if (array_key_exists('to_my_group', $conditions_value)){
			$this->db->where_in('toGroupId', $conditions_value['to_my_group']);
		} else if (array_key_exists('from_group_id', $conditions_value) && in_array('to_group_id', $conditions_value)) {
			$this->db->where('fromGroupId', $conditions_value['from_group_id']);
			$this->db->where('toGroupId', $conditions_value['to_group_id']);
		}
		
		// Check 'group by' parameters and specific joined tables and specific selected parameters  
		$selected_value = 'COUNT(igt.item_id)  `Count` ';
		if (array_key_exists('group_by_group', $group_by_value)) {
			if ($group_by_value['group_by_group'] == 'toGroupId') {
				$join_group_paramters = 'toGroupId';
			} else if ($group_by_value['group_by_group'] == 'fromGroupId') {
				$join_group_paramters = 'fromGroupId';
			}
			$this->db->join('aims_groups  g', 'g.group_id = igt.'.$join_group_paramters.'', 'left');
			$selected_value .= ',group_name  `Group` ';
		}
		if (array_key_exists('status', $group_by_value)) {
			$selected_value .= ',status  `Status`';
		}
		if (array_key_exists('igt.user_id', $group_by_value)) {
			$this->db->join('aims_users  u', 'u.user_id = igt.user_id', 'left');
			$selected_value .= ',user_name  `Agent`';
		}
		if (array_key_exists('transfareDate', $group_by_value)) {
			$selected_value .= ',DATE(FROM_UNIXTIME(transfareDate))  `Date` ';
		}
		if (array_key_exists('zone', $group_by_value) || array_key_exists('zone_id', $conditions_value)) {
			$this->db->join('aims_items  i', 'i.item_id=igt.item_id', 'left');
			$this->db->join('aims_Pops_Zone  pz', 'pz.POPId=i.custom_field_8', 'left');
			$this->db->join('aims_Zones  z', 'pz.Zone=z.Id', 'left');
			if (array_key_exists('zone', $group_by_value)) {
				$selected_value .= ',z.zone  `Zone` ';
			}
		}
		
		// Selected parameters
		$this->db->select($selected_value);
		
		// Group by parameters
		$this->db->group_by($group_by_value);
		
		$query = $this->db->get('aims_item_group_transfare  igt');
		// Return query to generate automatic table by query.		
		return $query;		

	}
	
	// Groups Tickets View
	function Groups_tickets_view ($group_security = '')
	{
		if ($group_security != '') {
			$this->db->select('count(item_id)  Counter, custom_field_3 Status');
			$this->db->group_by("custom_field_3"); 
			$query = $this->db->get_where('aims_items', array('group_security' => $group_security, 'custom_field_3 !='  => 'Closed'));
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Closed Items By Closing Reasons Report
	function closed_items_by_closing_reasons($start_date, $end_date, $group_id, $platform, $problem = '', $closing_reason = '')
	{
		$this->db->select('custom_field_19  product, custom_field_18  problem, custom_field_48  closing_reason, count(item_id)  counter ');
		if ($problem !== '') {
			$this->db->where('custom_field_18', $problem);
		}
		if ($closing_reason !== '') {
			$this->db->where('custom_field_48', $closing_reason);
		}
		$this->db->where('custom_field_3', 'Closed');
		//$this->db->where('core_log_updated >=', $start_date);
		//$this->db->where('core_log_updated <=', $end_date);
		$this->db->where('group_security', $group_id);
		$this->db->where('custom_field_19', $platform);
		$this->db->group_by('custom_field_19, custom_field_18, custom_field_48');
		$query = $this->db->get('aims_items');
		//echo $this->db->last_query();
		return $query->result();
	}

	// Automatic Transfer
	function Automatic_transfer()
	{
		//SELECT ticket_count, creation_date FROM aims_tickets_count ORDER BY creation_date DESC LIMIT 0,30
		$this->db->select('ticket_count, creation_date');
		$this->db->order_by("creation_date", "desc"); 
		$query = $this->db->get('aims_tickets_count', 30, 0);
		return $query->result();
	}

	// IU Maintenance Reports
	function Maintenance($zone, $exchange, $adsl)
	{
		$this->db->select('user_id, first_name');
		
		$query = $this->db->get_where('aims_users', array('user_id' => '17'));
		
		foreach ($query->result() as $row)
		{
		    echo "xx ".$row->first_name;
		}
		//die('Good');
	}

	// IU  Maintenance TE Reports
	function Maintenance_TE($id = FALSE)
	{

	}
	
	// IU Reports SDM Exchanges
	function SDM_Exchanges($id = FALSE)
	{
		
	}
	
	// Get user groups
	function get_user_groups($user_id = '')
	{
		if ($user_id !== '') {
			$this->db->select('groups');
			$query = $this->db->get_where('aims_group_members ', array('user_id' => $user_id));
			foreach ($query->result() as $row)
			{
				$groupArray = explode('}-{',$row->groups);
				$groupArray = array_filter($groupArray);
			}
			$this->db->select('group_id, group_name');
			$this->db->where_in('group_id', $groupArray);
			$query = $this->db->get('aims_groups');
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Get user groups
	function get_user_groups_id($user_id = '')
	{
		if ($user_id != '') {
			$this->db->select('groups');
			$query = $this->db->get_where('aims_group_members ', array('user_id' => $user_id));

			$groupArray = explode('}-{',$query->row()->groups);
			$groupArray = array_filter($groupArray);
			return $groupArray;
		} else {
			return false;
		}
	}
	
	// Get all status
	function get_all_status()
	{
		$this->db->select('menu_value');
		$query = $this->db->get_where('aims_custom_field_menu_values', array('custom_field_id' => 3));
		return $query->result();
	}
		
	// Get all Zones
	function get_all_zones()
	{
		$this->db->select('Id, zone');
		$query = $this->db->get('aims_Zones');
		return $query->result();
	}
	
	// Get All Groups
	function get_all_groups()
	{
		$this->db->select('group_id, group_name');
		//$this->db->order_by('group_name', 'ASC'); 
		$query = $this->db->get('aims_groups');
		return $query->result();
	}
	
	// Get Group by id
	function get_group_by_id($id = '')
	{
		if ($id !== '') {
			$this->db->select('group_name'); 
			$query = $this->db->get_where('aims_groups', array('group_id' => $id));
			return $query->row()->group_name;
		} else {
			return false;
		}
	}
	
	// Get all platforms
	function get_all_platforms()
	{
		$this->db->select('menu_value_id, menu_value');
		$query = $this->db->get_where('aims_custom_field_menu_values', array('custom_field_id' => '19'));
		return $query->result();	
	}

	// Get problem type by platform
	function get_all_problems_types($platform = '')
	{
		if ($platform !== '') {
			$this->db->select('sub_menu_values');
			$query = $this->db->get_where('aims_custom_field_menu_values', array('custom_field_id' => '19', 'menu_value' => $platform));
			$problem_type = $query->row()->sub_menu_values;
			$problem_type = explode(',',$problem_type);
			return $problem_type;
		} else {
			return false;
		}	
	}
	
	// Get closing reason by platform and problem type
	function get_all_closing_reasons($platform_id = '', $problem_type = '')
	{
		if ($platform_id !== '' && $problem_type !== '') {
			$this->db->select('closingReason');
			$query = $this->db->get_where('aims_closing_reason', array('platform' => $platform_id, 'problem' => $problem_type));
			return $query->result();
		} else {
			return false;
		}	
	}
}
