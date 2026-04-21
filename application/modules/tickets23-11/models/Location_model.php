<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		OSS Dev Team
 * @package		TTS-Te\Modules\Tickets\Models
 */
class Location_model extends CI_Model
{

	/**
	 * Get all Locations.
	 *
	 * @param no.
	 * @return array
	 */
	public function get_all()
	{
		$result = $this->db
					->select('id, name')
		  			->get('locations')
					->result();
		return $result;
	}
}