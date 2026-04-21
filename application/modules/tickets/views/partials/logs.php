<?php
/**
 * partials/logs.php  —  Ticket Logs Modal
 *
 * DST NOTE:
 * Previously this view rendered timestamps using:
 *
 *     date($this->config->item('log_date_format'), $ticket_log->created_at)
 *
 * PHP's date() function uses whatever the active default timezone is at the
 * time of the call. If the server OS or php.ini used a fixed UTC offset
 * (e.g. UTC+2) instead of a named timezone, the output was wrong during
 * summer time (UTC+3) and required manual intervention every DST change.
 *
 * FIX:
 * We now create a DateTime object explicitly anchored to 'Africa/Cairo'.
 * PHP's timezone database knows Egypt's DST rules, so the displayed time
 * is always correct — no manual change is ever needed again.
 *
 *     $dt = new DateTime('@' . $timestamp);       // interpret as UTC epoch
 *     $dt->setTimezone(new DateTimeZone('Africa/Cairo'));  // convert to local
 *     echo $dt->format('d-m-Y H:i:s');
 *
 * The 'Africa/Cairo' timezone automatically returns UTC+2 in winter and
 * UTC+3 in summer, matching Egypt's actual clock at all times.
 */

// Reusable timezone object — created once, used for every log row.
$cairo_tz = new DateTimeZone('Africa/Cairo');

// Date format: matches the existing log_date_format config value.
$date_format = $this->config->item('log_date_format') ?: 'd-m-Y H:i:s';
?>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ticket Logs : <?php echo $ticket_id; ?></h4>
      </div>
      <div class="modal-body">
        <div class="panel-body">
        <?php if ( ! empty($ticket_logs)) : ?>
            <?php foreach ($ticket_logs as $ticket_log) : ?>

                <?php
                /*
                 * DST-aware timestamp rendering.
                 *
                 * 1. Create a DateTime from the raw UTC Unix timestamp.
                 *    The '@' prefix tells PHP the integer is a UTC epoch.
                 * 2. Shift the timezone to Africa/Cairo — PHP applies the
                 *    correct DST offset automatically (UTC+2 or UTC+3).
                 * 3. Format using the configured log date format.
                 */
                $dt = new DateTime('@' . (int) $ticket_log->created_at);
                $dt->setTimezone($cairo_tz);
                $formatted_date = htmlspecialchars(
                    $dt->format($date_format),
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>

                <h4>Changed by <?php echo htmlspecialchars($ticket_log->username, ENT_QUOTES, 'UTF-8'); ?></h4>
                <blockquote>
                    <p><?php
                        if ($ticket_log->type === 'Comment') {
                            echo htmlspecialchars($ticket_log->type, ENT_QUOTES, 'UTF-8') . ' : ';
                        } else {
                            echo htmlspecialchars($ticket_log->type, ENT_QUOTES, 'UTF-8')
                                . ' changed from : '
                                . htmlspecialchars($ticket_log->old_value, ENT_QUOTES, 'UTF-8')
                                . ' To ';
                        }
                        echo htmlspecialchars($ticket_log->new_value, ENT_QUOTES, 'UTF-8');
                    ?>.</p>
                    <small>Created on : <?php echo $formatted_date; ?></small>
                </blockquote>

            <?php endforeach; ?>
        <?php else : ?>
            <h4>There are no logs</h4>
        <?php endif; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
