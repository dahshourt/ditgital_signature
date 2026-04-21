<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		OSS Dev Team
 * @package		TTS-Te\Modules\Tickets\Models
 */
class Group_model extends CI_Model
{
	/**
	 * Get all Groups.
	 *
	 * @param no.
	 * @return array
	 */
	public function get_all()
	{
		$result = $this->db
				 	->select('id, name')
					->where('active', '1')
		  			->get('groups')
					->result();
		return $result;
	}
	

    /**
     * Get group name by id.
     *
     * @param string $name.
     */
    public function get_group_name($id)
    {
        $result = $this->db
            ->select('name')
            ->from('groups')
            ->where('id', $id)
            ->get()
            ->row();
        return $result->name;
    }


    // get manager name
    public function get_manager_name($id)
    {
        $result = $this->db
            ->select('username')
            ->from('users')
            ->where('id', $id)
            ->get()
            ->row();
         return $result->username;
    }



	/**
	 * Transfer to Another Group.
	 *
	 * @param array $data.
	 */
	public function add_transferred_group($data)
	{
		$this->db->insert('groups_groups', $data);
	}
	
	/**
	 * Get group by user_id.
	 *
	 * @param int $user_id.
	 * @return array
	 */
	public function get_by_user($user_id)
	{
		if ( ! $user_id)
		{ 
			return FALSE;
		}
		$result = $this->db
					->select('group_id')
					->from('users_groups')
					->where('user_id', $user_id)
					->where('active', '1')
					->limit(1)
		  			->get()
					->result();
		return $result;
	}
	
	
	/**
	 * Get groups access for a group.
	 *
	 * @param int $group_id.
	 * @return array
	 */
	public function get_access_by_group($group_id, $rule_slug = NULL)
	{
		if ( ! $group_id)
		{ 
			return FALSE;
		}
		 
		//$rule_slug = array('edit_ticket', 'view_ticket');
		$result = $this->db
					->select('g.id, g.name')
					->from('permissions p')
					->join('groups  g', 'p.group_access = g.id')
					->join('modules_rules  mr', 'mr.id = p.module_rule_id')
					->where('p.group_id', $group_id)
					->where_in('mr.rule_slug', $rule_slug)
		  			->get()
					->result();
		
		return $result;
	}
	
	/**
	 * Get groups transfer for a group based on group id.
	 *
	 * @param int $group_id.
	 * @return array
	 */
	public function get_groups_groups($group_id)
	{
		if ( ! $group_id)
		{
			return FALSE;
		}
		$result = $this->db
					->select('g.id, g.name')
					->from('groups_groups gg')
					->join('groups g', 'gg.to_group_id = g.id')
					->where('gg.group_id', $group_id)
		  			->get()
					->result();
		return $result;
	}
	
	/**
	 * Get all groups transfer for a group.
	 *
	 * @param no.
	 * @return array
	 */
	public function get_all_groups_groups()
	{
		$result = $this->db
					->select('gg.id, g.name, tg.name  linked_name, gg.created_at')
					->from('groups_groups  gg')
					->join('groups  tg', 'gg.to_group_id = tg.id')
					->join('groups  g', 'gg.group_id = g.id')
					->order_by('g.id', 'DESC')
		  			->get()
					->result();
		return $result;
	}
	
	/**
     * Delete group transfer to group by id.
     *
     * @param string $name.
     */
    public function delete_groups_groups($id)
    {
    	if ( ! $id)
		{ 
			return FALSE;
		}
		
		if ($this->db->delete('groups_groups', array('id' => $id)))
		{
			return TRUE;
		}
    }

	 /**
	 * Get creator group by id.
	 *
	 * @param int $group_id.
	 * @return array
	 */
	public function get_group_by_id($group_id)
	{
		if ( ! $group_id)
		{ 
			return FALSE;
		}
		$result = $this->db
					->select('id, name')
					->from('groups')
					->where('id', $group_id)
		  			->get()
					->result();
		return $result;
	}
	
	public function get_users_per_group($group_id)
	{
		$result = $this->db->select('username,users.id')
					->from('users')
					->join('users_groups', 'users_groups.user_id = users.id')
					->where('users_groups.group_id', $group_id)
					->get()
					->result(); 
		return $result;						
	}
}