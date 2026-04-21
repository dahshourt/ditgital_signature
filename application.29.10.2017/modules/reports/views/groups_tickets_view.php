<p>
<?php
$attributes = array('class' => '', 'id' => 'myform');
echo form_open($main_content, $attributes);
$options = array();
foreach ($groups as $group)
{
	$options[$group->group_id] = $group->group_name;
}
echo "Group : ".form_dropdown('GroupId', $options)." ";
?>
<input type="submit" value="Search" />
</p>
<p></p>
<code>
	<div style="float: left; width: 70px">Status</div><div style="float: left">Count</div><div style= "clear: both"></div>
	<?php
	foreach ($records as $row)
	{
		echo '<div style="float: left; width: 70px">'.$row->Counter.'</div><div style="float: left">'.$row->Status.'</div><div style= "clear: both"></div>';
	}
	?>
</code>
</div>


