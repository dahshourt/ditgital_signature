<strong>&copy; 2015</strong>
<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>

<!-- jQuery -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<?php
// Check if JS files sent from controller or not
if ( ! empty($js))
{
	foreach ($js as $js_key => $js_value)
	{
		// JS files from controler
		echo '<script type="text/javascript" src="'.base_url().'assets/'.$js[$js_key].'"></script>';
	}
}
?>

<!-- Metis Menu Plugin JavaScript -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/bower_components/metisMenu/dist/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/dist/js/sb-admin-2.js"></script>
    
<script type="text/javascript">
	$('#dataTables-example').DataTable({
                responsive: true
        });
</script>
