<?php
/**
 * tickets/load_comments.php
 *
 * Partial view loaded via AJAX by Tickets::ajax_get_comment_logs().
 * Renders the comment log entries for a specific ticket.
 *
 * Expected variable injected by the controller:
 *   $comments_res  —  array of stdClass objects from get_ticket_comments()
 *                     Each object has: username, text, created_at (Unix ts)
 *
 * DST NOTE:
 * Timestamps are stored as UTC Unix integers in the database.
 * Displaying them requires conversion to the local Egypt timezone.
 *
 * We use DateTime + DateTimeZone('Africa/Cairo') so that PHP's internal
 * timezone rules automatically apply UTC+2 (winter) or UTC+3 (summer).
 * No hardcoded offset is used, so no manual change is needed at DST
 * transitions.
 */

// Single shared timezone object — avoids repeated instantiation per row.
$cairo_tz = new DateTimeZone('Africa/Cairo');

// Format pattern for displaying the comment timestamp.
$date_format = 'd-m-Y H:i:s';
?>

<?php if ( ! empty($comments_res)) : ?>

    <?php foreach ($comments_res as $comment) : ?>

        <?php
        /*
         * DST-aware comment timestamp rendering.
         *
         * Step 1 — Create a DateTime from the raw UTC Unix timestamp.
         *          The '@' prefix informs PHP that the value is a UTC epoch.
         * Step 2 — Set the timezone to Africa/Cairo.
         *          PHP resolves DST automatically: the object holds UTC+2
         *          in winter and UTC+3 in summer without any code change.
         * Step 3 — Format and escape for safe HTML output.
         */
        $dt = new DateTime('@' . (int) $comment->created_at);
        $dt->setTimezone($cairo_tz);
        $formatted_date = htmlspecialchars(
            $dt->format($date_format),
            ENT_QUOTES,
            'UTF-8'
        );
        ?>

        <div class="comment-entry media">
            <div class="media-body">
                <h5 class="media-heading">
                    <strong><?php echo htmlspecialchars($comment->username, ENT_QUOTES, 'UTF-8'); ?></strong>
                    <small class="text-muted">&mdash; <?php echo $formatted_date; ?></small>
                </h5>
                <p><?php echo nl2br(htmlspecialchars($comment->text, ENT_QUOTES, 'UTF-8')); ?></p>
            </div>
        </div>
        <hr />

    <?php endforeach; ?>

<?php else : ?>
    <p class="text-muted">No comments found for this ticket.</p>
<?php endif; ?>
