<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ticket Logs : <?php echo $ticket_id; ?></h4>
      </div>
      <div class="modal-body">
        <div class="panel-body">
        <?php
        if ( ! empty($ticket_logs)) :
	        foreach ($ticket_logs as $ticket_log) :?>
				<h4>Changed by <?php echo $ticket_log->username ?></h4>
				<blockquote>
		        	<p><?php echo (($ticket_log->type == 'Comment') ? $ticket_log->type.' : ' : $ticket_log->type.' changed from : '.$ticket_log->old_value.' To ' ); echo $ticket_log->new_value ?>.</p>
		            <small>Created on : <?php echo htmlspecialchars(date($this->config->item('log_date_format'), $ticket_log->created_at),ENT_QUOTES,'UTF-8');?></small>
		        </blockquote>
	        	<?php 
	        endforeach;
        else: ?>
            <h4>There are no logs</h4>
            <?php 
        endif; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>