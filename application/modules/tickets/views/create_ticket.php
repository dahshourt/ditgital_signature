<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$view_group = array();
$view_group[''] = '...Please select...	';
foreach($groups as $group_val)
{
    $view_group[$group_val -> id] = $group_val -> name;
}

$view_categories = array();
$view_categories[''] = '....Please select....';
$view_sub_category  = array();
$view_sub_category[''] = '';

// This URL using in ajax_sub_category.js
$ajax_sub_category_url = array(
    'type'  => 'hidden',
    'name'  => 'ajax_sub_category_url',
    'id'    => 'ajax_sub_category_url',
    'value' => ! empty($ajax_sub_category_url) ? $ajax_sub_category_url : '',
);
echo form_input($ajax_sub_category_url);

$ajax_category_url = array(
    'type'  => 'hidden',
    'name'  => 'ajax_category_url',
    'id'    => 'ajax_category_url',
    'value' => ! empty($ajax_category_url) ? $ajax_category_url : '',
);
echo form_input($ajax_category_url);

$ajax_user_id_url = array(
        'type'  => 'hidden',
        'name'  => 'ajax_user_id_url',
        'id'    => 'ajax_user_id_url',
        'value' => ! empty($ajax_user_id_url) ? $ajax_user_id_url : '',
);
echo form_input($ajax_user_id_url);

if (validation_errors()): ?>
    <div class="alert alert-danger">
        <?php echo validation_errors();	 ?>
    </div>
<?php endif;
echo form_open();?>
<div class="col-lg-3">
    <?php
	 
    echo form_label('Select Group');
    echo form_dropdown($creator_group_id, $view_group);
?>
</div>
<div class="col-lg-4">
<?php
    echo form_label('Select Category');
    echo form_dropdown($category_id, $view_categories);
?>
</div>
<div class="col-lg-5">
<?php
    echo form_label('Select Sub-Category');
    echo form_dropdown($sub_category_id, $view_sub_category);
?>
</div>

<div class="col-lg-12">
    </br>
    <?=form_submit(array('id' => 'submit','name' => 'submit' ,'value' => 'Redirect to Create Ticket Form', 'class' => 'btn btn-default' , 'class' => 'btn btn-primary'))?>
    <?=form_close()?><br/>
</div>