<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		OSS Dev Team
 * @package		TTS-Te\Modules\Tickets\Models
 */
class Status_model extends CI_Model
{

	/**
	 * Get all statuses.
	 *
	 * @param no.
	 * @return array
	 */
	public function get_all()
	{
		$result = $this->db
					->select('id, name')
		  			->get('tickets_statuses')
					->result();
		return $result;
	}

	/**
	 * Get the statuses for a groups.
	 *
	 * @param array $groups.
	 * @return array
	 */
	public function get_by_groups($groups)
	{
		if ( ! $groups)
		{ 
			return FALSE;
		}

		$result = $this->db
					->select('ts.id, ts.name')
					->from('tickets_statuses  ts')
					->join('groups_statuses  gs', 'gs.status_id = ts.id')
					->where_in('gs.group_id', $groups)
		  			->get()
					->result();
		
		return $result;
	}
	/**
	 * assgin status to a a groups.
	 *
	 * @param array $data.
	 */
	public function assign_to_groups($data)
	{
		$this->db->insert('groups_statuses', $data);
	}

    /**
 * Get status name by id.
 *
 * @param string $name.
 */
    public function get_status_name($id)
    {
        $result = $this->db
            ->select('name')
            ->from('tickets_statuses')
            ->where('id', $id)
            ->get()
            ->row();
        return $result->name;
    }
	/**
	 * Add New Status.
	 *
	 * @param array $data.
	 */
	public function add($data)
	{
		$this->db->insert('tickets_statuses', $data);
	}

}