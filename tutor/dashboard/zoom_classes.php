<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */


if ( ! defined( 'ABSPATH' ) )
	exit;

get_tutor_header(true);
$user = wp_get_current_user();
$email = $user->user_email;
$user_id = $user->ID;
$host_id = get_user_meta($user->ID,_zoom_host_id,true);
$host_status = get_user_meta($user->ID,_zoom_status_id,true);
$new_user = get_userdata( $user->ID );
# Get the user's first and last name
$first_name = $new_user->first_name;
$last_name = $new_user->last_name;
if($last_name == ""){
	$last_name = "MHSF";
}

?>
<h2>My Live Zoom Classes</h2>
<?php do_action('tutor/das	hboard_course_builder_after'); 

		if(isset($_POST['createzoomuser'])){
			$user = array(
				"email" => $email,
				"action" => "create",
				"first_name" => $first_name,
				"last_name" => $last_name,
				"type" => 1
			);
			$zoomuserid = json_decode(zoom_conference()->createAUser( $user ));
		if(!empty($zoomuserid)){
			update_user_meta($user_id, '_zoom_host_id', $zoomuserid->id);
			update_user_meta($user_id, '_zoom_status_id', "pending");
			echo "<h4>Please check your email ". $email." to activate account!</h4>";
			
		}
			
		}
			$args = array(
				 'post_type' => 'zoom-meetings',
				 'posts_per_page' => -1,
				 'order' => 'Desc',
				 'orderby' => 'date',
				 'meta_query' => array(
					   array(
						   'key' => '_meeting_host_id',
						   'value' => $host_id,
						   'compare' => '=',
					   )
				   )
			);
			$list = get_posts($args);	
		?>
	<div class="list-meeting" id="list-meeting" >
		<div class="tutor-dashboard-info-table-wrap">
		<?php if($host_id == ""){
				echo '<form action="" method="POST">
					<input type="hidden" value="createzoomuser" name="createzoomuser">
					<input type="submit" value="Activate Account">
				</form>';
		}
		elseif($host_status == "pending"){
			echo '<form action="" method="POST">
					<input type="hidden" value="createzoomuser" name="createzoomuser">
					<input type="submit" value="Activate Account">
				</form>';
		}
		else{
			?>
            <h3>Zoom Classes</h3>
			
            <table class="tutor-dashboard-info-table">
                <thead>
                <tr>
                    <td>Class Title</td>
                    <td>Date</td>
                    <td>Duration</td>
                    <td>Start Url</td>
                </tr>
                </thead>
                <tbody>
				<?php foreach($list as $detaillist){ 
				
					$meeting_details = get_post_meta($detaillist->ID, '_meeting_fields', true);
					$start_date = get_post_meta( $detaillist->ID, '_meeting_date', true );
					$class_date = date('Y-m-d',strtotime($start_date));
					$blogtime = date("Y-m-d");
					if($class_date >= $blogtime){
				?>
				    <tr>
                        <td><?php echo $detaillist->post_title; ?></td>
                        <td><?php echo get_post_meta( $detaillist->ID, '_meeting_date', true ); ?></td>
                        <td><?php echo $meeting_details['duration']; ?></td>
                        <td><a target="_blank" href="<?php echo get_post_meta( $detaillist->ID, '_meeting_zoom_start_url', true ); ?>">Start Class</a></td>
                    </tr>
		<?php } } ?>	                   
				</tbody>
            </table>
		<?php } ?>
        </div>
</div>
<?php
do_action('tutor_load_template_after', 'dashboard.create-course', null);
get_tutor_footer(true); ?>