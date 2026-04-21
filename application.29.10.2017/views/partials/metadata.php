<!-- Begin meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<title><?php echo $title ?></title>
	
	<!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- MetisMenu CSS -->
	<link type="text/css" href="<?php echo base_url() ?>assets/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet" />

	<?php
	// Check if CSS files sent from controller or not 
	if ( ! empty($css))
	{
		foreach ($css as $css_key => $css_value)
		{
			// CSS files from controler
			echo '<link type="text/css" href="'.base_url().'assets/'.$css[$css_key].'" rel="stylesheet" />';
		}
	}
	?>
	
	<!-- Custom CSS -->
	<link type="text/css" href="<?php echo base_url() ?>assets/dist/css/sb-admin-2.css" rel="stylesheet" />
	
	<!-- Custom Fonts -->
	<link type="text/css" href="<?php echo base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]--> 
