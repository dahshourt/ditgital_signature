<div id="container">
<ul id="nav">
 <li id="nav-1"><?php echo anchor('reports/sla', 'SLA Report', 'title="SLA Report"');?></li>
 <li id="nav-2"><?php echo anchor('reports/no_of_transferred_tickets', 'Number Of Transfered Tickets', 'title="Number Of Transfered Tickets"');?></li>
 <li id="nav-3"><?php echo anchor('reports/groups_tickets_view', 'Groups Tickets View', 'title="Groups Tickets View"');?></li>
 <li id="nav-4"><?php echo anchor('reports/closed_items_by_closing_reasons', 'Closed Items By Closing Reasons', 'title="Closed Items By Closing Reasons"');?></li>
 <li id="nav-5"><?php echo anchor('reports/automatic_transfer', 'Automatic Transfer', 'title="Automatic Transfer"');?></li>
 <li id="nav-7" style="float: right"><?php echo anchor('users/login', 'Log off', 'title="Log off"');?></li>
 <li id="nav-6" style="float: right ; width: 200px">Welcome to : <?php echo $this->session->userdata('user_name'); ?></li>
 
</ul>
	<h1><?php echo $title; ?></h1>
	<div id="body">
	<div style="height: 35px; color: red"><?php if (isset($interval)) { echo $interval; } ?></div>w