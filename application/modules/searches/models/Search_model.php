<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard model
 *
 * @author		Ticketing 
 * @author		OSS Dev Team
 * @package		TTS-TE\application\Modules\Searches\Models
 *
 */
class Search_model extends MY_Model
{
	/** 
	 * 
	 * @param 
	 * @return 
	 */
	public function get_ticket_quick_search($data_search)
	{
		if ( ! empty ($data_search))
		{
			$result = $this->db
						->select("t.id, to_char(TO_DATE('19700101','yyyymmdd')  + (  (\"t\".\"created_at\" + 7200 )/24/60/60),'DD-MM-YYYY HH24:MI:SS') as created_at, ts.name status_name, g.name group_name,
								  tc.name categrory,sub.name sub_categorey, cus.mobile mobile_num,cus.second_mobile_no second_num,serv.name service_type,dev.name device_type,t.service_identifier,t.application_id,cus.customer_name customer_name,tex.text description,user.username creator_name,u.username closed_by_user,cty.name customer_type ")
						->from('tickets t')
						->where($data_search)
						->join('tickets_statuses ts', 'ts.id = t.status_id', 'left')
						->join('customers_info ci', 'ci.id = t.customers_info_id', 'left')
						->join('area_codes ac', 'ac.id = ci.area_code_id', 'left')
						->join('tickets_categories tc', 'tc.id = t.category_id', 'left')
						->join('tickets_categories sub', 'sub.id = t.sub_category_id', 'left')
						->join('customers_info cus', 'cus.id = t.customers_info_id', 'left')
						->join('customer_types cty', 'cty.id = t.customer_type_id', 'left')

						->join('groups g', 'g.id = t.group_id', 'left')
						->join('service_types serv', 'serv.id = t.service_type', 'left')
						->join('device_types dev', 'dev.id = t.device_type', 'left')
				->join('tickets_logs_texts tex', 'tex.ticket_id=t.id and tex.log_type_id=8', 'left')
						//->join('users_groups ug', 'ug.user_id = t.created_by')
				->join('users user', 'user.id = t.created_by')
				->join('users u','t.closed_by_user= u.id','left')
				->order_by('t.id', 'DESC')
						//->where('ts.name <>','Closed')								
						->get();

		  	if ($result)
			{
		  		return $result;
			}
			return FALSE;
		}			
	}
}