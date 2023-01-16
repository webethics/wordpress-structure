<?php
/**
 * Quiz Attempts, I attempted to courses
 *
 * @since v.1.1.2
 *
 * @author Themeum
 * @url https://themeum.com
 *
 *
 * @package TutorLMS/Templates
 * @version 1.6.4
 */


$userid = get_current_user_id();
global $wpdb;
//echo "SELECT * FROM $wpdb->comments WHERE user_id =$userid AND comment_type='tutor_q_and_a'";
$user_comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE user_id =$userid AND comment_type='tutor_q_and_a'");

?>
<h2>My Questions</h2>
<div class="tutor-dashboard-info-table-wrap">
	<table class="tutor-dashboard-info-table">
		<tbody>
			<tr>
				<th>Class</th>
				<th>Question</th>
				<th>Answer</th>
				<th>View</th>
				
			</tr>
			<?php foreach($user_comments as $comment){  
			$answer = $wpdb->get_var("SELECT comment_content FROM $wpdb->comments WHERE comment_parent =$comment->comment_ID AND comment_type='tutor_q_and_a'");
			?>
			<tr>
				<td><?php echo get_the_title($comment->comment_post_ID); ?></td>
				<td><?php echo $comment->comment_content; ?></td>
				<td><?php echo $answer; ?></td>
				<td><a href="<?php echo get_the_permalink($comment->comment_post_ID); ?>">View</a></td>
				
			</tr>
			<?php } ?>		   
		</tbody>
	</table>
</div>
