<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		TEData OSS Dev Team
 * @package		Modules\Tickets\Models
 */
class Ticket_model extends MY_Model
{
	
	public function __construct() 
	{
		parent::__construct(); 
	}

	public function get_tickets_by_user($user_id)
	{
		if (empty($user_id))
		{
			return FALSE;
		}
		$group_id = $this->session->groups['id'];
		$result = $this->db
					->select('t.id, t.created_at, ts.name, ci.product_phone')
					->from('tickets  t')
					->join('customers_info  ci', 'ci.id = t.customers_info_id', 'left')
					->join('tickets_statuses  ts', 'ts.id = t.status_id', 'left')
					->where('t.manager_id', $user_id)
					->where('t.group_id', $group_id)
					->where('t.status_id != ', '1')
					->get()
					->result();
					
		return $result;
	}
	
	//
	public function get_tickets_by_group($group_id)
	{
		if (empty($group_id))
		{
			return FALSE;
		}
		$result = $this->db
					->select('t.id, t.created_at, ts.name, ci.product_phone')
					->from('tickets  t')
					->join('customers_info  ci', 'ci.id = t.customers_info_id', 'left')
					->join('tickets_statuses  ts', 'ts.id = t.status_id', 'left')
					->where('t.group_id', $group_id)
					->where('t.status_id != ', '1')
					->get()
		 			->result();

		return $result;
	}
	
	//
	public function get_tickets_created_by_group($group_id)
	{
		if (empty($group_id))
		{
			return FALSE;
		}
		$result = $this->db
					->select('t.id, t.created_at, ts.name')
					->from('tickets  t')
					->where('t.creator_group_id', $group_id)
					->where('t.status_id != ', '1')
					->join('tickets_statuses  ts', 'ts.id = t.status_id', 'left')
					->get()
					->result();
					
		return $result;
	}

	public function get_ticket_file_data($ticket_id)
	{
		if (empty($ticket_id))
		{
			return FALSE;
		}
		$result = $this->db
					->select('tf.id, tf.file_name, tf.created_at, tf.file_path, u.username')
					->from('tickets_files  tf')
					->join('users  u', 'u.id = tf.user_id')
					->where('tf.ticket_id', $ticket_id)
					->where('tf.active', '1')
					->get()
					->result();
					
		return $result;
	}
	
	public function get_ticket_data($ticket_id)
	{
		if (empty($ticket_id))
		{
			return FALSE;
		}

		$result = $this->db
                ->select('t.*, ts.name  status_name,tc.parent_id, stc.id  sub_category_id, tc.id  category_id,
                sl.id  sub_location_id, l.id  location_id, ci.*, tlt.text  complaint_details,u.username  manager_name, g.name group_name')
                ->from('tickets t')
                ->join('customers_info ci', 'ci.id = t.customers_info_id')
                ->join('tickets_categories tc', 'tc.id = t.category_id', 'LEFT')
				->join('tickets_categories stc', 'stc.id = t.sub_category_id', 'LEFT')
                ->join('locations l', 'l.id = t.location_id', 'LEFT')
				->join('locations sl', 'sl.id = t.sub_location_id', 'LEFT')
                ->join('users u', 'u.id = t.manager_id', 'LEFT')
				->join('groups g', 'g.id = t.group_id', 'LEFT')
                ->join('tickets_statuses ts', 'ts.id = t.status_id')
		        ->join('tickets_logs_texts tlt', 'tlt.ticket_id = t.id AND tlt.log_type_id = 8', 'left')
		        ->where('t.id', $ticket_id)
		        ->get()
                ->row_array();

		return $result;
	}

	public function get_ticket_logs($ticket_id)
	{
		if (empty($ticket_id))
		{
			return FALSE;
		}
		$query = $this->db->query(
			'SELECT "tl"."old_value" ,"tl"."new_value" , "u"."username", "lt"."type"  "type" ,"tl"."created_at"
			FROM "tickets_logs"  "tl"
			JOIN "users"  "u" ON "u"."id" = "tl"."created_by"
			LEFT JOIN "log_type" "lt" ON "lt"."id" = "tl"."log_type_id"
			WHERE "tl"."ticket_id" = '.$ticket_id.'
			UNION ALL
			SELECT NULL  "old_value",  "tlt"."text"  "new_value", "u"."username" , "lt"."type" "type", "tlt"."created_at" 
			FROM "tickets_logs_texts" "tlt"
			JOIN "users"  "u" ON "u"."id" = "tlt"."created_by"
			LEFT JOIN "log_type" "lt" ON "lt"."id" = "tlt"."log_type_id"
			WHERE "tlt"."ticket_id" = '.$ticket_id.' AND "tlt"."log_type_id" = 9
			ORDER BY "created_at"'
		);
		return $query->result();
	}

	public function edit_ticket($id, $data)
	{
		$this->db->where('id', $id)->update('tickets', $data);
	}
	
	public function add_file($data)
	{
		$this->db->insert('tickets_files', $data);
	}
	
	public function delete_file($id, $data)
	{
		$this->db->where('id', $id)->update('tickets_files', $data);
	}
	
	public function get_file_path($id)
	{
		$result = $this->db
					->select('file_path')
				 	->where('id', $id)
				 	->get('tickets_files')
			 		->row()->file_path;
			 		
		return $result;
	}

	public function add_tickets_logs($data)
	{
		$this->my_insert_batch('tickets_logs', $data);
	}

	public function add_tickets_logs_texts($data)
	{
		$this->my_insert_batch('tickets_logs_texts', $data);
	}

	public function add_customer_info($data)
	{
		if($this->db->insert('customers_info', $data))
		{
			$this->set_table_name('customers_info');
			return $this->insert_id();
		}
		return FALSE;
	}
	
	public function add_items($data)
	{
		if($this->db->insert('tickets', $data))
		{
			$this->set_table_name('tickets');
			return $this->insert_id();
		}
		return FALSE;
	}
	
	public function add_text($data)
	{
		$this->db->insert('tickets_logs_texts', $data);
	}
	
	// List all parent or child names
	public function get_all_parent($table_name, $parent_id = NULL)
	{
		$result = $this->db
			->select('id, name')
			->from($table_name)
			->where('parent_id', $parent_id)
			->get()
			->result();
		return $result;
	}
	
	// List all names
	public function get_all($table_name = '')
	{
		if ( empty($table_name))
		{
			return false;
		}
		$result = $this->db
			->select('id, name')
			->from($table_name)
			->get()
			->result();
		return $result;
	}

    // Need improvement
    public function ajax_get_sub_location_id($location_id ='')
    {
        if ($location_id != '')
        {
            $this->db->select('id, name');
            $this->db->from('locations');
            $this->db->where('parent_id', $location_id);
            $query = $this->db->get();
            $sub_location_id = array();
            if ($query -> result()) {
                foreach ($query -> result() as $sub_location) {
                    $sub_location_id[$sub_location -> id] = $sub_location -> name;
                }
                return $sub_location_id;
            } else {
                return 0;
            }
        }
        else
        {
            return 0;
        }
    }
	public function get_speed()
	{
		$result = $this->db
					->select('name, id')
					->from('speeds')
					->get()
					->result();
		
		return $result;
	}
	
	public function complain_channel()
	{
		$result = $this->db
					->select('name, id')
					->from('complain_channels')
					->get()
					->result();
		
		return $result;
	}
	
	public function get_reseller_name()
	{
		$result = $this->db
					->select('name, id')
					->from('resellers')
					->get()
					->result();
		
		return $result;
	}
	public function get_user_name($id)
	{
		$result = $this->db
					->select('username, id')
					->from('users')
					->where ('id',$id)
					->get()
					->row();
		
		return $result->username;
	} 
        
        public function get_user_names()
	{
		$result = $this->db
					->select('username name, id')
					->from('users')
					->get()
					->result();
		
		return $result;
	}
        
	public function get_user()
	{
		$result = $this->db
					->select('name, id')
					->from('users')
					->get()
					->result();
		
		return $result;
	}
	
	public function get_problem()
	{
		$result = $this->db
					->select('name, id')
					->from('tickets_problems')
					->get()
					->result();
		
		return $result;
	}
	
	public function get_closing_reason()
	{
		$result = $this->db
					->select('name, id')
					->from('tickets_closing_reasons')
					->get()
					->result();
					
		return $result;
	}
	
	public function get_cpe()
	{
		$result = $this->db
					->select('name, id')
					->from('cpes')
					->get()
					->result();
		
		return $result;
	}
	
	public function get_exchange()
	{
		$result = $this->db
					->select('exchange_name, exchange_id')
					->from('exchanges_zones')
					->get()
					->result();

		return $result;
	}
	
  	public function get_customer_info($customer_no)
    {
        if (empty($customer_no))
        {
            return 0;
        }

        $result = $this->db
        			->select('*')
        			->from('customers_info  c')
        			->where('c.account_no',$customer_no)
        			->db->get()
        			->result();
		
		return $result;
    }
	
	public function get_user_type($user_id)
	{
		$result = $this->db
						->select('type_id')
						->from('users')
						->where('id',$user_id)
						->get()
						->row();
					
		return $result;
	}

    public function get_ticket_transfer_groups($input_fun_array)
    {
        if (empty($input_fun_array))
        {
            return 0;
        }

        $result = $this->db
            ->select('distinct("g"."id"), g.name')
            ->from('ticket_workflows tw')
            ->join('groups g', 'g.id = tw.transfer_group', 'left')
            ->where($input_fun_array)
            ->get()
            ->result();
//print_r($input_fun_array);die;
        return $result;
    }

    public function get_transfer_status($input_fun_array)
    {
        if (empty($input_fun_array))
        {
            return 0;
        }

        $data = $this->db
            ->select('transfer_status')
            ->from('ticket_workflows')
            ->where($input_fun_array)
            ->get()
            ->row();
            if($data)
            {
            	$result=$data->transfer_status;
            }
            else
            {
            	$result="";
            }

        return $result;
    }

    function ajax_get_sub_users_id($group_id, $creator_id = null, $group_type_id = null)
    {
        if ($group_id != '') {
            $this->db->select('users.id, users.username,groups.type_id');
            $this->db->from('users');
            $this->db->where('groups.id', $group_id);
            if($group_type_id == 3)
            {
                $this->db->where('users.id', $creator_id);
            }
            $this->db->join('users_groups', 'users.id = users_groups.user_id', 'inner');
            $this->db->join('groups', 'users_groups.group_id = groups.id', 'inner');


        $query = $this->db->get();
        $sub_user_id = array();
        if ($query->result()) {
            foreach ($query->result() as $sub_user) {
                $sub_user_id [$sub_user->id] = $sub_user->username;
                $res['group_type_id'] = $sub_user->type_id;
            }
            $res['sub_user_id'] = $sub_user_id;
            return $res;
        } else {
            return 0;
        }
        }
    }


        public function get_users_by_group($group_id)
        {
            if ( ! $group_id)
            {
                return FALSE;
            }

            $result = $this->db
                   ->select('users.id, users.username  name')
                   ->from('users')
                   ->where('groups.id', $group_id)
                   ->join('users_groups', 'users.id = users_groups.user_id', 'inner')
                   ->join('groups', 'users_groups.group_id = groups.id', 'inner')
                   ->get()
                   ->result();

            return $result;
        }

    public function get_group_info($input_fun)
        {

            $result = $this->db
                   ->select('*')
                   ->from('groups')
                   ->where($input_fun)
                   ->get()
                   ->result();

            return $result;
        }

	public function check_ticket_access($ticket_id = '', $type = '')
	{
		if (empty($ticket_id))
		{
			return FALSE;
		}
		$type_id = $this->session->groups['type_id'];
		$user_id = $this->session->user_id;
		$group_id = $this->session->groups['id'];

		if ($type_id == '3')
		{
			$this->db->group_start();
			$this->db->where('manager_id', $user_id)
					->where('group_id', $group_id);
			if ($type == 'view_ticket')
			{
				$this->db->or_where('creator_group_id', $group_id);
			}
			$this->db->group_end();
		}
		elseif($type_id == '2')
		{
            /*check user permission for ticket*/
            $get_ticket_group = $this->db
                ->select('*')
                ->from('tickets')
                ->where('id', $ticket_id)
                ->limit('1')
                ->get()
                ->row()->group_id;

            /*get get group access above ticket group*/
            $this->db->select('p.group_id, p.group_access, mr.rule_slug, mr.rule_name, mr.menu, mr.action_name')
                ->from('permissions  p')
                ->join('modules_rules  mr', 'mr.id = p.module_rule_id', 'left')
                ->join('modules  m', 'm.id = mr.module_id', 'left')
                ->where('p.group_id', $group_id)
                ->where('p.group_access', $get_ticket_group);
                if ($type)
                {
                    $this->db->where('mr.rule_slug', $type);
                }
            $get_group_permission =  $this->db->get()->row();
            return $get_group_permission;
            /*end of user permission check*/

            /*old implementation*/
//			$this->db->group_start();
//			$this->db->where('group_id', $group_id)
//				->or_where('creator_group_id', $group_id);
//			$this->db->group_end();
		}
		$result = $this->db
					->select('id')
					->where('id', $ticket_id)
					->limit('1')
					->get('tickets')
					->row()->id;
		return $result;
	}

    /*get status by IDs*/
    public function getStatusById($id)
    {
        if(empty($id)) {
            return false;
        }

        $this->db
            ->select('id, name')
            ->from('tickets_statuses');
        if(is_array($id))
        {
            $this->db->where_in('id',$id);
        }else{
            $this->db->where('id',$id);
        }
        return $this->db->get()->result();

    }

}