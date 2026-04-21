<?php
/**
 * Created by PhpStorm.
 * User: Dalia
 * Date: 4/25/2016
 * Time: 8:17 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><?php echo lang('tickets:show_log');?></button>
<?php
$this->load->view('partials/logs');

if (isset($resellers))
{
    $view_reseller_name  = array();
    foreach ($resellers as $reseller) {
        $view_reseller_name [$reseller -> id] = $reseller -> name;
    }
}

$view_status  = array();
	foreach ( $statuses as $status_name ) {
        $view_status [$status_name -> id] = $status_name -> name;
    }

if (isset($line_speed)) {
    $view_speeds = array();
    foreach ($speeds as $speed) {
        $view_speeds [$speed->id] = $speed->speed;
    }
}
if (isset($complains_channel)) {
    $view_complains_channel = array();
    foreach ($complains_channel as $complain_chanel) {
        $view_complains_channel [$complain_chanel->id] = $complain_chanel->name;
    }
}
if (isset($categories)){
$view_category  = array();
	foreach ($categories as $category_val) {
		$view_category [$category_val -> id] = $category_val -> name;
	}
}
if (isset($sub_categories))
{
    $view_sub_category  = array();
    if ($sub_categories != '0')
    {
        foreach ($sub_categories as $key => $sub_category_val) {
            $view_sub_category[$key] = $sub_category_val;
        }
    }
}

if (validation_errors()) : ?>
    <div class="alert alert-danger">
        <?php echo validation_errors();	 ?>
    </div>
<?php endif;
//$attributes = array('enctype' => 'multipart/form-data');
echo form_open_multipart('tickets/edit_ticket/'.$ticket_id);?>
<div class="col-lg-6">
	<?php
$readonly = false;
$i=0;
foreach($custom_fields as $values) {
    $i++;
    $data[$values->name] = array(
        'type'  => '',
        'name'  => $values->name,
        'id'    => $values->id,
        'value' => (isset($tickets_data->$values->name)) ? $tickets_data->$values->name : '',
        'class' => $values->class,
        'readonly' => 'readonly',
    );
    echo form_label($values->label)."</br>";
    if($values->type == "input")
    {
        echo form_input($data[$values->name]);

    }
    elseif($values->type == "dropdown")
    {
        $data[$values->name] = array(
            'type'  => '',
            'name'  => $values->name,
            'id'    => $values->id,
            'class' => $values->class,
            'selected' => (isset($tickets_data->$values->name)) ? $tickets_data->$values->name : '',
            'disabled' => 'disabled',
        );
        if($values->name == "category")
        {
            echo form_dropdown($data[$values->name],$view_category,$category_selected_value);
        }
        else if($values->name == "sub_category")
        {
            echo form_dropdown($data[$values->name], $view_sub_category, $sub_category_selected_value);
        }
        elseif($values->name == "identity_type")
        {
            echo form_dropdown($data[$values->name],$view_identity_type);
        }
        elseif($values->name == "status_id")
        {
            echo form_dropdown($data[$values->name],$view_status,$status_selected_value);
        }

        elseif($values->name == "reseller_name" and isset($data[$values->name]))
        {
            echo form_dropdown($data[$values->name], $view_reseller_name, $reseller_selected_value);
        }
        else if($values->name == "line_speed" and isset($data[$values->name]))
        {
            echo form_dropdown($data[$values->name],$view_speeds, $speed_selected_value);
        }
        else if($values->name == "complain_channel" and isset($data[$values->name]))
        {
            echo form_dropdown($data[$values->name],$view_complains_channel,$complain_channel_selected_value);
        }


    }
    elseif($values->type == "textarea")
    {
        if($values->name == "comment")
        {
            $data['comment'] = array(
                'type'  => '',
                'name'  => $values->name,
                'id'    => '9',
                'value' => (isset($tickets_data->$values->name)) ? $tickets_data->$values->name : '',
                'class' => $values->class,
                'disabled' => 'disabled',
            );

        }
        else if($values->name == "complain_details")
        {
            $data['complain_details'] = array(
                'type'  => '',
                'name'  => $values->name,
                'id'    => '8',
                'value' => (isset($tickets_data->complaint_details)) ? $tickets_data->complaint_details : '',
                'readonly' => 'readonly',
                'class' => 'form-control'
            );

        }
        echo form_textarea($data[$values->name]);
    }
    elseif($values->name == "document_name" or $values->name =="filename")
    {
        echo form_input($data[$values->name]);
        echo form_upload($data[$values->name]);
    }



    if($i==7)
    {
        ?>
        </div>
        <div class="col-lg-6">
    <?php  }


}

?>
</div>

<div class="col-lg-12">
</br>
<?php echo form_close(); ?><br/>
</div>
