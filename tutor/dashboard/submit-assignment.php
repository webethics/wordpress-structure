<?php
/* template for submit assignment */
global $wpdb, $current_user;
if(isset($_POST['submit'])){
$content = stripcslashes($_POST['mycustomeditor1']);
$content = htmlentities($content);
 
$commentdata = array(
    'comment_post_ID'      => '',             // To which post the comment will show up.
    'comment_author'       => $current_user->user_nicename,     // Fixed value - can be dynamic.
    'comment_author_email' => $current_user->user_email, // Fixed value - can be dynamic.
    'comment_agent'   => '',  // Fixed value - can be dynamic.
    'comment_content'      => $content, // Fixed value - can be dynamic.
    'comment_type'         => 'assignments_answer',                    // Empty for regular comments, 'pingback' for pingbacks, 'trackback' for trackbacks.
    'comment_parent'       => $_POST['parent'],                     // 0 if it's not a reply to another comment; if it's a reply, mention the parent comment ID here.
    'user_id'              => $current_user->ID,     // Passing current user ID or any predefined as per the demand.
);
 
// Insert new comment and get the comment ID.
$comment_id = wp_new_comment( $commentdata );
if($comment_id){
	echo "<h3>Assignment Submitted Successfully!</h3>";
}
}
$results = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_type='assignments' AND comment_parent=".$current_user->ID);
if(isset($_GET['id'])){ 
$data = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_ID=".$_GET['id']);
$data1 = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_parent=".$_GET['id']);
$assignval= get_comment_meta($_GET['id'],"assignval",true);
?>
	<h3>Student Name: <?php echo $data[0]->comment_author; ?></h3>
	<label style="margin-bottom:20px;">Title</label>
	<input style="margin-bottom:20px;" readonly type="text" value="<?php echo $data[0]->comment_agent; ?>">
	<label style="margin-bottom:20px;">Content</label>
	<div class="content"><?php echo html_entity_decode($data[0]->comment_content); ?></div>
<?php foreach($data1 as $reply){ ?>
	<div class="content"><?php echo html_entity_decode($reply->comment_content); ?></div>
<?php }
if($assignval == "writeassign"){
?>
<label style="margin-bottom:20px;">Add Reply</label>
<form method="post">
	<?php $content1   = "";
		$editor_id1 = 'mycustomeditor1';
		$settings  = array('editor_height' => 100,'media_buttons' => false);
		wp_editor( $content1, $editor_id1, $settings ); 
	?>
	<input type="hidden" name="parent" value="<?php echo $_GET['id']; ?>">
	<input type="submit" value="Submit" name="submit">
</form>
	
<?php 	}
}
else{
?>

<h3>Student Assignments</h3>
<div class="tutor-dashboard-info-table-wrap">
        <table class="tutor-dashboard-info-table">
            <tbody>
				<tr>
					<th>Title</th>
					<th>Student Name</th>
					<th>Class Name</th>
					<th>Content</th>
					<th>Action</th>
					
				</tr>
				<?php foreach($results as $result){ ?>
				<tr>
				
					<td><?php echo $result->comment_agent;?></td>
					<td><?php echo $result->comment_author; ?></td>
					<td><?php echo get_the_title($result->comment_post_ID) ; ?></td>
					<td><?php echo  html_entity_decode(wp_trim_words( $result->comment_content, 20, '...' )); ?></td>
					<td><a href="/my-account/submit-assignment/?id=<?php echo $result->comment_ID; ?>">View</a></td>
					
				</tr>
				<?php }	?>		
            </tbody>
		</table>
    </div>

<?php } ?>
<style>
.content {
    padding: 20px;
    border: 1px solid #eee;
    margin-bottom: 20px;
}
</style>