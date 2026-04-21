<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('partials/metadata'); ?>
</head>
<body>
	<div id="wrapper">	
		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<!-- navbar-top-links -->
			<?php $this->load->view('partials/top_navbar.php'); ?>
		<!--/.navbar-top-links -->
 
		<!-- navbar-static-side -->
			<?php $this->load->view('partials/sidebar.php'); ?>
			
		<!-- /.navbar-static-side -->
		</nav>
	    
	    <!-- Page Content -->
	    <div id="page-wrapper">
	    	<div class="container-fluid">
	        	<div class="row">
	            	<div class="col-lg-12">
	                	<h1 class="page-header"></h1>
	                </div>
	            	<div class="col-lg-12">
	            		<div class="panel panel-info">
							<div class="panel-heading">
								<?php echo $title; ?>
							</div>
							<?php if ($this->session->flashdata('message')): ?>
							<div class="panel-body">
								<div class="alert alert-success">
									<?php echo $this->session->flashdata('message'); ?>
								</div>
							</div>
							<?php elseif ($this->session->flashdata('info')): ?>
							<div class="panel-body">
								<div class="alert alert-info">
	                                <?php echo $this->session->flashdata('info'); ?>
	                            </div>
	                        </div>
	                        <?php elseif ($this->session->flashdata('warning')): ?>
                            <div class="panel-body">
	                            <div class="alert alert-warning">
	                               <?php echo $this->session->flashdata('warning'); ?>
	                            </div>
                            </div>
							<?php elseif ($this->session->flashdata('danger')): ?>
							<div class="panel-body">
								<div class="alert alert-danger">
									<?php echo $this->session->flashdata('danger'); ?>
								</div>
							</div>
							<?php endif; ?>
							<div class="panel-body">
								<p><?php $this->load->view($main_content); ?></p>
		            		</div>
						</div>
	            	</div>
	            <!-- /.col-lg-12 -->
	            </div>
	        <!-- /.row -->
	        </div>
	    <!-- /.container-fluid -->
	    </div>
	    <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
		<!-- Footer -->
		<?php $this->load->view('partials/footer'); ?>
	</body>
</html>