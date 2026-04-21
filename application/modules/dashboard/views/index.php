<div class="panel-body">
	<div class="row">
		<div class="col-lg-3 col-md-6">
        	<div class="panel panel-red">
            	<div class="panel-heading">
                	<div class="row">
                    	<div class="col-xs-3">
                        	<i class="fa fa-support fa-5x"></i>
                        </div>
                    	<div class="col-xs-9 text-right">
                			<div class="huge"><?=$count_support_tickets?></div>
                			<div>Support Tickets!</div>
            			</div>
        			</div>
				</div>
			    <?=anchor('tickets/ticket_assigned_user', '<div class="panel-footer">
							<span class="pull-left">View Details</span>
				            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
			                <div class="clearfix"></div>
			                </div>', 'title="Tickets Assigned To User"')
				?>
			</div>
		</div>
		<?php
//print_r($this->session->groups['id']) ;
//$this->session->groups['type_id']
		if($this->session->groups['type_id'] != '3'): ?>
        <div class="col-lg-3 col-md-6">
        	<div class="panel panel-yellow">
            	<div class="panel-heading">
                	<div class="row">
                    	<div class="col-xs-3">
                        	<i class="fa fa-support fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                        	<div class="huge"><?php echo $count_group_tickets; ?></div>
                            <div>Group Tickets!</div>
                        </div>
                    </div>
                </div>
                <?=anchor('tickets/ticket_assigned_group', '<div class="panel-footer">
	            	<span class="pull-left">View Details</span>
	                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                <div class="clearfix"></div>
                    </div>', 'title="Tickets Assigned To Group"');
                ?>
            </div>
        </div>
        <?php endif; ?>
        <!--
		<div class="col-lg-3 col-md-6">
        	<div class="panel panel-primary">
            	<div class="panel-heading">
                	<div class="row">
                    	<div class="col-xs-3">
                        	<i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                        	<div class="huge"></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <a href="#">
	                <div class="panel-footer">
	                	<span class="pull-left">View Details</span>
	                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                    <div class="clearfix"></div>
	                </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
        	<div class="panel panel-green">
            	<div class="panel-heading">
                	<div class="row">
                    	<div class="col-xs-3">
                        	<i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                        	<div class="huge"></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <a href="#">
                	<div class="panel-footer">
	                    <span class="pull-left">View Details</span>
	                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                    <div class="clearfix"></div>
                	</div>
				</a>
            </div>
        </div>
    </div>-->
    <!-- /.row -->
</div>
<!-- /.panel-body -->