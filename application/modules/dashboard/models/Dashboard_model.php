<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard model
 * 
 * @author		TEData OSS Dev Team
 * @package		application\Modules\Dashboard\Models
 *
 */
class Dashboard_model extends MY_Model
{

	/**
	 * Get the count of tickets based on manager and status of tickets
	 *
	 * @param int $user_id The ID of manager of ticket
	 * @param int Optional $status_id The ID of the status of ticket
	 * @return int Number of tickets
	 */
	public function count_user_tickets($user_id, $status_id = '')
	{
		if ($status_id == '')
		{
			$this->db->where('status_id != ', '1');
		}
		else
		{
			$this->db->where('status_id', $status_id);
		}

		$this->db->where('manager_id', $user_id);

		return $this->db->count_all_results('tickets');
	}

	/**
	 * Get the count of tickets based on supported group and status
	 *
	 * @param int $group_id The ID of supported group of ticket
	 * @param int Optional $status_id The ID of the status of ticket
	 * @return int Number of tickets
	 */
	public function count_group_tickets($group_id, $status_id = '')
	{
		
		if ($status_id == '')
		{
			$this->db->where('status_id != ', '1');
		}
		else
		{
			$this->db->where('status_id', $status_id);
		}

		$this->db->where('group_id', $group_id);

		return $this->db->count_all_results('tickets');	
	}

}