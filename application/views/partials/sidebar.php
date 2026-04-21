 <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
							<?php echo anchor('dashboard/', '<i class="fa fa-dashboard fa-fw"></i> Dashboard', 'title="Dashboard"');?>
                        </li>
                        <?php
                        $menu_val = $_SESSION['menu_val'];
						$repeated_menu = array();
                        foreach($menu_val as $k => $v) 
						{
							if (in_array($v['menu'], $repeated_menu))
							{
								continue;
							}
						?>
						<li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> <?php echo $v['menu']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                        		<li>
                                <?php 
									echo anchor($v['action_name'], $v['rule_name'], 'title=');
								?>
                            	</li>
                        	<?php
				    		foreach($menu_val as $key => $value) 
				    		{
						        if($v['menu'] == $value['menu'] && $v['rule_name'] != $value['rule_name'])
						        {
						        ?>
						        <li>
                                    <?php echo anchor($value['action_name'], $value['rule_name'], 'title=');?>
                                </li>
						        <?php
						        $repeated_menu[] = $value['menu'];
						        }
				    		}
							
							?>
							</ul>
                        </li>
						<?php } ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->