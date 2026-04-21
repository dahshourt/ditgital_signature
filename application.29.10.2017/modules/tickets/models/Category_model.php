<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		OSS Dev Team
 * @package		TTS-Te\Modules\Tickets\Models
 */
class Category_model extends CI_Model
{

	/**
	 * Get all categpries.
	 *
	 * @param no.
	 * @return array
	 */
	public function get_all()
	{
		$result = $this->db
					->select('id, name')
					->where('parent_id', NULL)
					->where('active', '1')
		  			->get('tickets_categories')
					->result();

		return $result;
	}
	
	/**
	 * assgin category to a groups.
	 *
	 * @param array $data.
	 */
	public function assign_to_group($data)
	{
		$this->db->insert('groups_categories', $data);
	}
	
	 /**
	 * Get categories for a groups.
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
					->select('tc.id, tc.name')
					->from('tickets_categories  tc')
					->join('groups_categories  gc', 'gc.category_id = tc.id')
					->where('parent_id', NULL)
					->where_in('gc.group_id', $groups)
					->where('tc.active', '1')
		  			->get()
					->result();
		
		return $result;
	}

	 /**
	 * Get all categories for all groups.
	 *
	 * @param No.
	 * @return array
	 */	 
	public function get_all_by_groups()
	{
		$result = $this->db
					->select('gc.id, g.name, tc.name  linked_name, gc.created_at')
					->from('groups_categories  gc')
					->join('tickets_categories  tc', 'tc.id = gc.category_id')
					->join('groups  g', 'g.id = gc.group_id')
		  			->get()
					->result();
		
		return $result;
	}
	
	 /**
	 * Get sub categories by category.
	 *
	 * @param array $category_id.
	 * @return array
	 */
	public function get_sub_by_category($category_id)
	{
		if ( ! $category_id)
		{ 
			return FALSE;
		}
		
		$result = $this->db
					->select('id, name')
					->from('tickets_categories')
					->where('parent_id', $category_id)
					->where('active', '1')
		  			->get()
					->result();
		return $result;
	}
	
	/**
	 * Add New Category.
	 *
	 * @param array $data.
	 */
	public function add($data)
	{
		$this->db->insert('tickets_categories', $data);
	}

	 /**
	 * Delete category for a group.
	 *
	 * @param int $id.
	 * @return boolean.
	 */ 
	public function delete_groups_categories($id)
	{
		if ( ! $id)
		{ 
			return FALSE;
		}
		
		if ($this->db->delete('groups_categories', array('id' => $id)))
		{
			return TRUE;
		}

	}


	
	public function edit()
	{

	}
	
	public function delete()
	{

	}

}