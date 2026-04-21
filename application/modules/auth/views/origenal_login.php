<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <!DOCTYPE html>
    <html>
      <head>
        <title>TTS TE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="<?php echo base_url() ?>assets/css/bootstrap/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo base_url() ?>assets/css/bootstrap/bootstrap-responsive.css" rel="stylesheet">
 <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #FFFFFF;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>    
      </head>
	<body>
		
    <div class="container">
<?php 
$attributes = array('class' => 'form-signin');
echo form_open("auth/login", $attributes);
?>
      	<div style="clear: both"><?php echo validation_errors(); ?></div>
      	<img class="logo-img" src="<?php echo base_url() ?>assets/images/logo.png">
      	<hr />
        <h1><?php echo lang('login_heading');?></h1>
<p><?php echo lang('login_subheading');?></p>

<div id="infoMessage"><?php echo $message;?> <?php echo validation_errors(); ?></div>
  <p>
    <?php echo lang('login_identity_label', 'identity');?>
    <?php echo form_input($identity);?>
  </p>

  <p>
    <?php echo lang('login_password_label', 'password');?>
    <?php echo form_input($password);?>
  </p>

 <!-- <p>
    <?php //echo lang('login_remember_label', 'remember');?>
    <?php //echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>
-->
  <p><?php 
  $attributes = array(
        'class' => 'btn btn-large btn-primary',
  );
  echo form_submit('submit', lang('login_submit_btn'), $attributes);?></p>
<?php echo form_close();?>
<!-- <p><a href="forgot_password"><?php //echo lang('login_forgot_password');?></a></p>-->
    </div> <!-- /container -->
	</body>
</html>