<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		TEData OSS Dev Team
 * @package		Modules\custom_fields\Models
 */
class Custom_field_model extends CI_Model
{
	
	/**
	 * Get all active custom fields.
	 * @param no
	 * @return array
	 */
	public function get_all()
	{
		$result = $this->db
					->select('id, name, label, type')
					->from('custom_fields')
					->where('active', '1')
					->get()
					->result();
					
		$fields = array();

		foreach ($result as $key => $row)
		{
			// Either pass roles or just true
			$fields[$row->id]['id'] = $row->id;
			$fields[$row->id]['name'] = $row->name;
			$fields[$row->id]['label'] = $row->label;
			$fields[$row->id]['type'] = $row->type;
		}
		
		return $fields;
	}
	
	/**
	 * Get a custom fields based on form type, group and category on admin panel.
	 * 
	 * @param int $form_type The type of the form Either Create or Search tickets
	 * @param int $group_id The ID of the group
	 * @param int $category_id The ID of the category
	 * @return array
	 */
	public function get_fields($form_type, $group_id, $category_id = '')
	{
		
		if ( ! $group_id)
		{
			return false;
		}
		$category_id != '' ? $this->db->where('ticket_category_id', $category_id) : $this->db->where('ticket_category_id', NULL);

		$result = $this->db
					->select('custom_field_id, sort, validation_type_id')
					->from('custom_fields_groups')
					->where('groups_id', $group_id)
					->where('form_type', $form_type)
					->get()
					->result();
		
		$fields = array();
		foreach ($result as $key => $value) {
			$fields[$value->custom_field_id]['custom_field_id'] = $value->custom_field_id;
			$fields[$value->custom_field_id]['sort'] = $value->sort;
			$fields[$value->custom_field_id]['validation_type_id'] = $value->validation_type_id;
		}

		return $fields;
	}
	
	/**
	 * Save the custom fields passed
	 *  
	 * @param int $form_type The type of the form Either Create or Search tickets
	 * @param int $group_id The ID of the group
	 * @param array $custom_field_id The list of IDs of the custom fields
	 * @param int $category_id The ID of the category
	 * @param array $validation_type_id The list of IDs of the validation types ('required and etc..')
	 * @param array $sort The list of arranged data
	 * @return bool
	 * 
	 */
	public function save($form_type, $group_id, $custom_field_id, $category_id = '',  $validation_type_id = '', $sort = '')
	{
		if (! $form_type OR ! $group_id)
		{
			return FALSE;
		}
		// Clear out the old ustom fields
		$category_id != '' ? $this->db->where('ticket_category_id', $category_id) : $this->db->where('ticket_category_id', NULL);
		
		$this->db->where('form_type', $form_type);
		$this->db->where('groups_id', $group_id)->delete('custom_fields_groups');
		if (! $custom_field_id)
		{
			return FALSE;
		}
		$created_at = time();
		// Save custom fields related with group or category or sub category
		foreach ($custom_field_id as  $field_id => $field_val)
		{
			$data = array(
					'form_type' => $form_type,
					'groups_id' => $group_id,
					'custom_field_id' => $field_id,
					'created_at' => $created_at,
					'created_by' => $this->session->user_id,
			);
			$category_id != '' ? $data['ticket_category_id'] = $category_id: '';
			! empty($validation_type_id[$field_id]) ? $data['validation_type_id'] = $validation_type_id[$field_id]: '';
			! empty($sort[$field_id]) ? $data['sort'] = $sort[$field_id]: '';

			// Save this custom fields in the list of "allowed custom fields for group"
			if ( ! $result = $this->db->insert('custom_fields_groups', $data))
			{
				// Fail, give up trying
				return false;
			}
		}

		return true;
	}

	/**
	 * Gal all validation types
	 * @param no
	 * @return array
	 */
	public function get_validation_type()
	{
		$result = $this->db
					->select('id, name')
					->from('validation_type')
					->get()
					->result();

		return $result;
	}

	/**
	 * Get access fields when Create or Search tickets based on form type, group and category.
	 * 
	 * @param int $form_type The type of the form Either Create or Search tickets
	 * @param int $group_id The ID of the group
	 * @param int $category_id The ID of the category
	 * @return array
	 */
	//public function get_access_fields($form_type, $group_id, $category_id = '')
	public function get_access_fields($input_fun)
	{
		if (empty($input_fun))
		{
			return FALSE;
		}	
		$result = $this->db
					->select('cf.class,cf.label, cf.name, cf.type, cf.related_table, cf.related_table, cfg.sort, cfg.validation_type_id, vt.name  validation_type_name, cf.parent_id, cf.form_id')
					->from('custom_fields_groups  cfg')
					->join('custom_fields  cf', 'cf.id = cfg.custom_field_id')
					->join('validation_type  vt', 'vt.id = cfg.validation_type_id', 'LEFT')
					->where($input_fun)
					->get()
					->result();
		
		$fields = array();
		foreach ($result as $key => $value)
		{
			$fields[$value->name]['label'] = $value->label;
			$fields[$value->name]['class'] = $value->class;
			$fields[$value->name]['name'] = $value->name;
			$fields[$value->name]['form_id'] = $value->form_id;
			$fields[$value->name]['type'] = $value->type;
			$fields[$value->name]['related_table'] = $value->related_table;
			$fields[$value->name]['sort'] = $value->sort;
			$fields[$value->name]['validation_type_id'] = $value->validation_type_id;
			$fields[$value->name]['validation_type_name'] = $value->validation_type_name;
			$fields[$value->name]['parent_id'] = $value->parent_id;
		}
//                        $fields['Closed_by_user']['label'] = 'Closed by user';
//			$fields['Closed_by_user']['class'] = 'form-control';
//			$fields['Closed_by_user']['name'] = 'closed_by_user';
//			$fields['Closed_by_user']['form_id'] = '';
//			$fields['Closed_by_user']['type'] = 'dropdown';
//			$fields['Closed_by_user']['related_table'] = 1;
//			$fields['Closed_by_user']['sort'] ='';
//			$fields['Closed_by_user']['validation_type_id'] = '';
//			$fields['Closed_by_user']['validation_type_name'] = '';
//			$fields['Closed_by_user']['parent_id'] =' ';
	
		return $fields;
	}	
public function get_access_fields1($input_fun)
	{
		if (empty($input_fun))
		{
			return FALSE;
		}	
		$result = $this->db
					->select('cf.class,cf.label, cf.name, cf.type, cf.related_table, cf.related_table, cfg.sort, cfg.validation_type_id, vt.name  validation_type_name, cf.parent_id, cf.form_id')
					->from('custom_fields_groups  cfg')
					->join('custom_fields  cf', 'cf.id = cfg.custom_field_id')
					->join('validation_type  vt', 'vt.id = cfg.validation_type_id', 'LEFT')
					->where($input_fun)
					->get()
					->result();
		
		$fields = array();
		foreach ($result as $key => $value)
		{
			$fields[$value->name]['label'] = $value->label;
			$fields[$value->name]['class'] = $value->class;
			$fields[$value->name]['name'] = $value->name;
			$fields[$value->name]['form_id'] = $value->form_id;
			$fields[$value->name]['type'] = $value->type;
			$fields[$value->name]['related_table'] = $value->related_table;
			$fields[$value->name]['sort'] = $value->sort;
			$fields[$value->name]['validation_type_id'] = $value->validation_type_id;
			$fields[$value->name]['validation_type_name'] = $value->validation_type_name;
			$fields[$value->name]['parent_id'] = $value->parent_id;
		}
                        $fields['Closed_by_user']['label'] = 'Closed by user';
			$fields['Closed_by_user']['class'] = 'form-control';
			$fields['Closed_by_user']['name'] = 'closed_by_user';
			$fields['Closed_by_user']['form_id'] = '';
			$fields['Closed_by_user']['type'] = 'dropdown';
			$fields['Closed_by_user']['related_table'] = 1;
			$fields['Closed_by_user']['sort'] ='';
			$fields['Closed_by_user']['validation_type_id'] = '';
			$fields['Closed_by_user']['validation_type_name'] = '';
			$fields['Closed_by_user']['parent_id'] =' ';
	
		return $fields;
	}	
}