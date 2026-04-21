<p></p>
<code>
	<div style="float: left; width: 120px">Tickets Counter</div><div style="float: left">Date</div><div style= "clear: both"></div>
	<?php
	foreach ($records as $row)
	{
		echo '<div style="float: left; width: 120px">'.$row->ticket_count.'</div><div style="float: left">'.$row->creation_date.'</div><div style= "clear: both"></div>';
	}
	?>
</code>
</div>


