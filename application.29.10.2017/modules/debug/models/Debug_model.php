<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Debug model
 * 
 * @author		TE Data OSS Dev Team
 * @package		Modules\Debug\Models
 */
class Debug_model extends CI_Model {
	
	/**
     * Get a users to show benchmarks
	 * 
	 * @param no
	 * @return array
     */
	public function get_benchmark_users()
	{
		$result = $this->db
					->select('user_id')
                	->get('benchmark_users')
					->result_array();
		
		return $result;
	}
	
}
