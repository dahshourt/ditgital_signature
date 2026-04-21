<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('category_model');
		$this->load->model('group_model');
		$this->lang->load('tickets/categories');
	}
	public function add()
	{
		$user_id = $this->user_id;
		$created_at = time();
		$this->form_validation->set_rules('name','Status','required');
		if($this->form_validation->run())
		{
			$data = array('name' => $this->input->post('name'), 'active' => '1', 'parent_id' => NULL, 'created_at' => $created_at, 'created_by' => $user_id,);
			$this->category_model->add($data);
		}
		$data['name'] = array('name'  => 'name',	'id'    => 'name',	'class' => 'form-control');
		$data['main_content'] = 'tickets/categories/add_category';
 		$data['title']        = 'Add New Category';
 		$this->load->view('layouts/default',$data);
	}
	public function add_sub_category()
	{
		$user_id = $this->user_id;
		$created_at = time();
		$this->form_validation->set_rules('name','Status','required');
		if($this->form_validation->run())
		{
			$data = array('name' => $this->input->post('name'),	'active' => '1', 'parent_id' => $this->input->post('parent_id'),	'created_at' => $created_at, 'created_by' => $user_id,);
			$this->category_model->add($data);
		}
		$data['parent_id'] = array('name'  => 'parent_id',	'id'    => 'parent_id',	'class' => 'form-control');
		$data['name'] = array('name'  => 'name',	'id'    => 'name',	'class' => 'form-control');
		$data['categories']   		      = $this->category_model->get_all();
		$data['main_content'] = 'tickets/categories/add_subcategory';
 		$data['title']        = 'Add Subcategory';
 		$this->load->view('layouts/default',$data);
	}

	public function category_to_group()
	{
		$user_id = $this->user_id;
		$created_at = time();
		$this->form_validation->set_rules('group_id','Group','required');
		$this->form_validation->set_rules('category_id','Category','required');
		if($this->form_validation->run())
		{
			$data = array('group_id' => $this->input->post('group_id'),'category_id' => $this->input->post('category_id'),'created_at' => $created_at,'created_by' => $user_id,);
			$this->category_model->assign_to_group($data);
			$this->session->set_flashdata('message', 'The action has been created successfully.');
            redirect("tickets/categories/category_to_group");
		}
		$data['group_id'] = array('name'  => 'group_id','id'    => 'group_id','class' => 'form-control');
		$data['category_id'] = array('name'  => 'category_id','id'    => 'category_id','class' => 'form-control');
		$data['categories']		      = $this->category_model->get_all();
		$data['groups']   		      = $this->group_model->get_all();
		$data['results']     = $this->category_model->get_all_by_groups();
		$data['edit_url']    = 'tickets/categories/edit_/';
		$data['delete_url']  = 'tickets/categories/delete_groups_categories/';
		$data['th'] 		 = array('groups:group', 'groups:');
		$data['js'] 	     = array('bower_components/datatables/media/js/jquery.dataTables.min.js', 'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js');
		$data['main_content'] = 'tickets/categories/category_to_group';
 		$data['title']        = 'Add Category To Group';
 		$this->load->view('layouts/default',$data);
	}
	
	
	 /**
	 * Delete category for a group.
	 *
	 * @param int $id.
	 * @return void
	 */
	public function delete_groups_categories($id)
	{
		if ( ! empty($id))
		{
			$this->category_model->delete_groups_categories($id);
			$this->session->set_flashdata('message', 'Deleted successfully.');
		}
	        redirect("tickets/categories/category_to_group");
	}
	
	
	
	 /**
	 * Using ajax - Get categories by group.
	 *
	 * @param int $group_id.
	 * @return json
	 */
  	public function ajax_get_categories_by_group()
    {
        $group_id = $this->input->post('group_id');
        $categories = array();
        $categories_res = $this->category_model->get_by_groups($group_id);
		if ($categories_res)
		{
			$categories = array();
			foreach ($categories_res as $category)
			{
	        	$categories[$category -> id] = $category -> name;
	        }
	        echo json_encode($categories);
        }
        exit();
    }
	
	/**
	 * Using ajax - Get sub categories by category_id.
	 *
	 * @param int $category_id.
	 * @return json
	 */
	public function ajax_get_sub_categories()
	{
		$category_id = $this->input->post('category_id');
		$sub_categories = array();
		$sub_categories_res = $this->category_model->get_sub_by_category($category_id);
		if ($sub_categories_res)
		{
			$sub_categories = array();
			foreach ($sub_categories_res as $sub_category)
			{
	        	$sub_categories[$sub_category -> id] = $sub_category -> name;
	        }
	        echo json_encode($sub_categories);
        }
        exit();
	}

}