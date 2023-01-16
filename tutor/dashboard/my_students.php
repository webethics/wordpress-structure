<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */


?>

<h3><?php _e('My Students', 'tutor'); ?></h3>


<div class="tutor-dashboard-content-inner">

	<?php
	$my_courses = tutor_utils()->get_courses_by_instructor(null, array('publish', 'draft', 'pending'));
	 ?>
		
		
<div class="tutor-dashboard-info-table-wrap" >
				
		<table class="tutor-dashboard-info-table" id="mytable">
			<thead>
			<tr>
				<td><h5>Student Name</h5></td>
				<td><h5>Student Email</h5></td>
				<td><h5>Student Age</h5></td>
				<td><h5>Course Enrolled</h5></td>
			</tr>
			</thead>
			<tbody>
			
				<?php 
				echo "<h5>Total Students</h5>"; 
					if (is_array($my_courses) && count($my_courses)):
						global $post, $woocommerce, $wpdb;
						$users = array();
					foreach ($my_courses as $post):
						setup_postdata($post);
						$course_idd = get_the_ID();
						$course_title = get_the_title();
						$url = get_the_permalink();
						$stu_order = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_type = 'tutor_enrolled' AND post_parent = $course_idd AND post_status = 'completed'", ARRAY_A );
						foreach($stu_order as $user) {
							$final_data = $user['post_author']; // Grabing their state from their profile page
							$data = get_userdata($final_data);
							$userdate = get_user_meta($final_data,"dob",true);
							if($userdate != ""){
								$date1 = strtotime($userdate);
								$currentdate = date('d-m-Y');
								$date2  = strtotime($currentdate);
								  
								$diff = abs($date2 - $date1);  
								$years = floor($diff / (365*60*60*24)); 
							}
							else{
								$years = "";
							}
							?>
							<tr>
										<td><?php echo $data->display_name; ?></td>
										<td><?php echo $data->user_email; ?></td>
										<td><?php echo $years; ?></td>
										<td><a href="<?php echo $url; ?>"><?php echo $course_title; ?></a></td>
									</tr>
							<?php
						}
						
						
						
						
					endforeach;
					
					
			
				else : ?>
				<div>
					<h2><?php _e("0 Students Enrolled" , 'tutor'); ?></h2>
					
				</div>
			<?php endif; ?>

			</tbody>
		</table>
	</div>
	
</div>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/datatables.min.js"></script>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/datatables.min.css">
<script>
jQuery('#mytable').DataTable();
</script>
<style>
.ui-widget-header {
    border: 1px solid var(--tutor-primary-color);
    background: var(--tutor-primary-color);
}
.dataTables_wrapper .dataTables_filter input, .dataTables_wrapper select {
    color: #333;
}
</style>
