<?php defined('BASEPATH') OR exit('No direct script access allowed');
if (validation_errors()):
    ?>
    <div class="alert alert-danger">
    <?= validation_errors() ?>
    </div>
<?php
endif;
echo form_open();
if (!empty($ajax_url['sub_location_id'])) :
    $ajax_location_id_url = array(
        'type' => 'hidden',
        'name' => 'ajax_location_id_url',
        'id' => 'ajax_location_id_url',
        'value' => $ajax_url['sub_location_id'],
    );
    echo form_input($ajax_location_id_url);
endif;
if (!empty($ajax_url['sub_category_id'])) :
    $ajax_sub_category_id_url = array(
        'type' => 'hidden',
        'name' => 'ajax_sub_category_url',
        'id' => 'ajax_sub_category_url',
        'value' => $ajax_url['sub_category_id'],
    );
    echo form_input($ajax_sub_category_id_url);
endif;
?>
<div class="col-lg-3">
    <?php
    if ($get_access_fields):
        $x = intval((count($get_access_fields) + 1) / 4);
        $i = 1;
        foreach ($get_access_fields as $value_access_field):
            $data_form = array(
                'name' => $value_access_field['name'],
                'id' => (!empty($value_access_field['form_id'])) ? $value_access_field['form_id'] : $value_access_field['name'],
                'value' => $this->form_validation->set_value($value_access_field['name']),
                'class' => 'form-control'
            );
            ($value_access_field['name'] == 'type_id') ? $data_form['disabled'] = 'disabled' : '';
            $form_type = 'form_' . $value_access_field['type'];
            if ($i % $x == 0):
                ?>
            </div>
            <div class="col-lg-3">
                <?php
            endif;
            echo form_label($value_access_field['label']);
            if ($value_access_field['type'] == 'dropdown'):
                $view_values = array();
                $view_values[''] = '';
                $selected_val = '';
                if (!empty(${$value_access_field['name']})):
                    foreach (${$value_access_field['name']} as $val):
                        switch ($value_access_field['name']):
                            case 'type_id':
                                $selected_val = $type_id_selected;
                                break;
                        endswitch;
                        $view_values [$val->id] = $val->name;
                    endforeach;
                endif;
                echo $form_type($data_form, $view_values, $selected_val);
            else:
                echo $form_type($data_form);
            endif;
            $i++;
        endforeach;
        ?>
    </div>

    <div class="col-lg-12 panel">
    <?= form_submit(array('id' => 'submit', 'value' => 'Search', 'class' => 'btn btn-default')) ?>
    </div>

    <?= form_close() ?>
<?php endif; ?>
<?php if (isset($search_tickets)): ?>
    <div class="col-lg-12">
        <div class="panel-body">
            <h1 class="page-header">Results</h1>
                <?php if (!empty($search_tickets)): ?>
                <div class="form-group">
                <?= anchor('reports/export_csv', 'Export Data', 'title="Export Data" class="btn btn-outline btn-success"') ?>
                </div>
    <?php endif; ?>
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th><?= lang('tickets:id') ?></th>
                            <th><?= lang('tickets:created_on') ?></th>
                            <th><?= lang('tickets:platform') ?></th>
                            <th><?= lang('tickets:problem') ?></th>

                            <th><?= lang('tickets:status') ?></th>
                            <th><?= lang('tickets:mobile') ?></th>

                            <th><?= lang('tickets:secondery_mobile') ?></th>
                            <th><?= lang('tickets:service_identifier') ?></th>
                            <th><?= lang('tickets:application_id') ?></th>
                         
                             <th>Complaint Details</th>
                                <th> closed by user </th>
                            <th><?= lang('tickets:service_type') ?></th>
                            <th><?= lang('tickets:device_type') ?></th>
                           




                            <th><?= lang('tickets:edit') ?></th>
                            <th><?= lang('tickets:view'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // echo $search_tickets{0}{'CREATED_AT'};
                        
                        foreach ($search_tickets as $search_ticket):
                            ?>
                            <tr class="odd gradeX">
                                <td><?= htmlspecialchars($search_ticket->id, ENT_QUOTES, 'UTF-8') ?></td>

                                <td><?=$search_ticket->CREATED_AT?></td>

                                <td><?= htmlspecialchars($search_ticket->categrory, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($search_ticket->sub_categorey, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($search_ticket->status_name, ENT_QUOTES, 'UTF-8') ?></td>

                                <td><?= htmlspecialchars($search_ticket->mobile_num, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($search_ticket->second_num, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($search_ticket->service_identifier, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($search_ticket->application_id, ENT_QUOTES, 'UTF-8') ?></td>
                                 <td><?= htmlspecialchars($search_ticket->complaint_details, ENT_QUOTES, 'UTF-8') ?></td>
                                                                  <td><?= htmlspecialchars($search_ticket->closed_by_user, ENT_QUOTES, 'UTF-8') ?></td>

                                <td><?= htmlspecialchars($search_ticket->service_type, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($search_ticket->device_type, ENT_QUOTES, 'UTF-8') ?></td>
                               




                                <td><?php
                                    echo (!empty($search_ticket->status_name != 'Closed') ? anchor("tickets/edit/" . $search_ticket->id, 'Edit') : '');
                                    //echo anchor("tickets/edit/".$search_ticket->id, 'Edit');
                                    ?></td>
                                <td><?php //echo ( ! empty($view_ticket) ? anchor("tickets/view/".$search_ticket->id, 'View') : '');
                    echo anchor("tickets/view/" . $search_ticket->id, 'View');
                    ?></td>
                            </tr>
                <?php endforeach; ?> 
                    </tbody>
                </table>
            </div>
    <?php if (!empty($search_tickets)): ?>
                <div class="form-group">
        <?= anchor('reports/export_csv', 'Export Data', 'title="Export Data" class="btn btn-outline btn-success"') ?>
                </div>
    <?php endif; ?>
        </div>
    </div>
    <!-- /.panel-body -->
    </div>
<?php endif; ?>