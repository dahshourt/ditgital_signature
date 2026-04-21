<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permission model
 *
 * @author		TEData Dev Team
 * @package		PyroCMS\Core\Modules\Permissions\Models
 *
 */
class Permission_model extends CI_Model
{
	private $_groups = array();

	/**
	 * Get the permission rules for a group.
	 *
	 * @param int $group_id The id for the group.
	 * @return array
	 */
	public function get_group_permissions($group_id)
	{
		if (empty($group_id))
		{
			return FALSE;
		}
		if ($group_id == 1) {
		$result = $this->db->select('mr.rule_slug, mr.rule_name, mr.menu, mr.action_name')
				->from('modules_rules  mr')
				->get()->result_array();
		}
		else {
		$result = $this->db->select('p.group_id, p.group_access, mr.rule_slug, mr.rule_name, mr.menu, mr.action_name')
				->from('permissions  p')
				->join('modules_rules  mr', 'mr.id = p.module_rule_id', 'left')
				->join('modules  m', 'm.id = mr.module_id', 'left')
				->where('p.group_id', $group_id)
				->get()->result_array();
		}
		
		return $result;
	}

	/**
	 * Get the permission rules for a group.
	 *
	 * @param int $group_id The id for the group.
	 * @return array
	 */
	public function get_group($group_id, $group_access = '')
	{
		if (empty($group_id))
		{
			return FALSE;
		}
		($group_access != '') ? $this->db->where('p.group_access', $group_access): '';
		$this->db->select('m.slug  slug, mr.rule_slug  rule_slug, mr.id  module_rule_id');
		$this->db->from('permissions  p');
		$this->db->join('modules_rules  mr', 'mr.id = p.module_rule_id', 'left');
		$this->db->join('modules  m', 'm.id = mr.module_id', 'left');
		$this->db->where('p.group_id', $group_id);
		$result = $this->db->get()->result();
		
		// Store the final rules here
		$rules = array();

		foreach ($result as $row)
		{
			// Either pass roles or just true
			$rules[$row->slug][$row->module_rule_id] = true;
			//$rules[$row->slug][$row->rule_name] = true;
		}

		// Save this result for later
		//$this->_groups[$group_id] = $rules;
		return $rules;
	}

	/**
	 * Get a role based on the group slug
	 *
	 * @param string|array $roles Either a single role or an array
	 * @param null|string $module The module to check access against
	 * @param bool $strict If set to true the user must have every role in $roles. Otherwise having one role is sufficient
	 * @return bool
	 */
	public function has_role($roles, $module = null, $strict = false)
	{
		$access = array();
		$module === null and $module = $this->module;

		// must be logged in
		if ( ! $this->current_user) return false;

		// admins can have anything
		if ($this->current_user->group == 'admin') return true;

		// do they even have access to the module?
		if ( ! isset($this->permissions[$module])) return false;

		if (is_array($roles))
		{
			foreach ($roles as $role)
			{
				if (array_key_exists($role, $this->permissions[$module]))
				{
					// if not strict then one role is enough to get them in the door
					if ( ! $strict)
					{
						return true;
					}
					else
					{
						array_push($access, false);
					}
				}
			}

			// we have to have a non-empty array but one false in the array gets them canned
			return $access and ! in_array(false, $access);
		}
		else
		{
			// they just passed one role to check
			return array_key_exists($roles, $this->permissions[$module]);
		}
	}

	/**
	 * Get a rule based on the ID
	 *
	 * @param int $group_id The id for the group to get the rule for.
	 * @param null|string $module The module to check access against
	 * @return bool
	 */
	public function check_access($group_id, $module = null)
	{
		// If no module is set, just make sure they have SOMETHING
		if ($module !== null)
		{
			$this->db->where('module', $module);
		}

		return $this->db
			->where('group_id', $group_id)
			->count_all_results('permissions') > 0;
	}

	/**
	 * Save the permissions passed
	 *
	 * @param int $group_id
	 * @param array $modules
	 * @param array $module_roles
	 * @return bool
	 */
	public function save($group_id, $module_roles, $group_access = '')
	{
		// Clear out the old permissions
		if ($group_access != '')
		{
			$this->db->where('group_access', $group_access);
		}
		$this->db->where('group_id', $group_id)->delete('permissions');
		
		if ($module_roles)
		{
			// For each module mentioned (with a value of 1 for most browser compatibility).
			foreach ($module_roles as  $module_role_id => $val)
			{
				if ( ! empty($module_role_id))
				{
					$data = array(
						'group_id' => $group_id,
						'module_rule_id' => $module_role_id,
						'created_at' => time(),
					);
					if ($group_access != '')
					{
						$data['group_access'] = $group_access;
					}
					// Save this module in the list of "allowed modules"
					if ( ! $result = $this->db->insert('permissions', $data))
					{
						// Fail, give up trying
						return false;
					}
				}
			}
			return true;
		}

		return false;
	}
	
	public function list_roles()
	{
		$this->db->select('m.name  name, m.slug  slug, m.id  module_id, mr.rule_slug  rule_slug, mr.id  module_rule_id, mr.rule_name');
		$this->db->from('modules  m');
		$this->db->join('modules_rules  mr', 'mr.module_id = m.id', 'left');
		$this->db->where('mr.enabled', '1');
		$result = $this->db->get()->result();

		// Store the final rules here
		$rules = array();

		foreach ($result as $key => $row)
		{
			// Either pass roles or just true
			$rules[$row->slug]['name'] = $row->name;
			$rules[$row->slug]['module_id'] = $row->module_id;
			$rules[$row->slug]['slug'] = $row->slug;
			$rules[$row->slug]['module_rule_id'] = $row->module_rule_id;
			$rules[$row->slug]['roles'][$row->module_rule_id] = $row->rule_name;
		}
		
		return $rules;
	}
}