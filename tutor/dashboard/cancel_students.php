<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */


?>

<h3><?php _e('Cancel Class Request', 'tutor'); ?></h3>


<div class="tutor-dashboard-content-inner">

<?php
//echo $current_user_id = get_usermeta(get_current_user_id(),"learner_cancel_request_id",true);
global $wpdb;

$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}usermeta WHERE meta_key LIKE 'learner_cancel_request_id_%'  AND user_id=".get_current_user_id()." order by `_EXL_usermeta`.`umeta_id` desc");

 ?>
		
		
<div class="tutor-dashboard-info-table-wrap" >
				
		<table class="tutor-dashboard-info-table">
			<thead>
			<tr>
				<td><h5>Student Name</h5></td>
				<td><h5>Student Email</h5></td>
				<td><h5>Class Name</h5></td>
				<td><h5>Student Comment</h5></td>
				<td><h5>In Refund Policy</h5></td>
				<td><h5>Approve Cancellation</h5></td>
			</tr>
			</thead>
			<tbody>
			<?php 
			
			foreach($results as $result){
			$stu_id = $result->meta_value;
			$stu_key = $result->meta_key;
			$res = explode("_",$stu_key);
			$cancel_meta = end($res);
			$user_info = get_userdata($stu_id);
			$approve_status = get_usermeta($stu_id,"refund_approved_".$cancel_meta,true);
			$approve_status_type = get_usermeta($stu_id,"refund_approved_type_".$cancel_meta,true);
			if($approve_status_type == "withrefund"){
				$approve_status_type = "With Refund";
			}
			if($approve_status_type == "withoutrefund"){
				$approve_status_type = "Without Refund";
			}
			$desc_status = get_usermeta($stu_id,"learner_cancel__description_request_".$cancel_meta,true);
			
			$time_status = get_usermeta($stu_id,"learner_cancel__timeline_request_".$cancel_meta,true);
			$timedate = get_usermeta($stu_id,"learner_cancel__timeline_date_".$cancel_meta,true);
			$data = get_post_meta($cancel_meta,"_insert_meeting_zoom_meeting_id",true);
			$refund = get_post_meta($cancel_meta,"refund",true);
			
			$result_meeting = $wpdb->get_var( "SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = '_meeting_zoom_meeting_id' AND meta_value=".$data[0]);
			$checkttime = get_post_meta($result_meeting,"_meeting_date",true);
			if($checkttime == ""){
				$checkttime = "";
			}
			else{
				if($refund == "class pack 14"){
					$checkttime = date('Y-m-d',strtotime("-7 days", strtotime($checkttime)));
				}
				elseif($refund == "class pack 15"){
					$checkttime = date('Y-m-d',strtotime("-30 days", strtotime($checkttime)));
				}	
			}
			
			$currenttime = date("Y-m-d",strtotime($timedate));
			$checkttime = strtotime($checkttime);
			$currenttime = strtotime($currenttime);
			?>

				<tr>
					<td><?php echo $user_info->first_name." ".$user_info->last_name; ?></td>
					<td><?php echo $user_info->user_email; ?></td>
					<td><?php echo get_the_title($cancel_meta); ?></td>
					<td><?php echo $desc_status; ?></td>
					<td class='<?php if($currenttime <= $checkttime){echo "successgreen";}else{echo "required";}?>'><?php if($checkttime != ""){if($currenttime <= $checkttime){ echo "Yes";}else{echo "No";}} ?></td>
					<td style="width:190px;">
						<form class="approveform" method="post">
							<input type="hidden" name="user_student" value="<?php echo $stu_id; ?>">
							<input type="hidden" name="user_class" value="<?php echo $cancel_meta; ?>">
							<input type="hidden" name="user_email" value="<?php echo $user_info->user_email; ?>">
							<input type="hidden" class="user_type" name="user_type" value="">
							<span class="statusapprove" style='color:#25a9e0'><?php if($approve_status == $cancel_meta){echo "Approved ". $approve_status_type;} ?></span> 
							
							<?php if($approve_status != $cancel_meta){?>
							<a data-id="withrefund" class="successgreen <?php if($approve_status == ''){echo "approve";}?>" href="javascript:void(0);">Remove with refund </a><a data-id="withoutrefund" class="required <?php if($approve_status == ''){echo "approve";}?>" href="javascript:void(0);">Remove without refund</a>
							<?php } ?>
						</form>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	
</div>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/datatables.min.js"></script>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/datatables.min.css">
<script>
jQuery('#mytable').DataTable();
jQuery(document).ready(function(){
	jQuery(".approve").click(function(e){
			e.preventDefault();
			var $btn = jQuery(this);
			var $btn_hide1 =  $btn.parent('.approveform').find(".successgreen");
			var $btn_hide2 =  $btn.parent('.approveform').find(".required");
			var $btn_hide3 =  jQuery(this).parent('.approveform').find(".statusapprove");
			var $btn_attr = jQuery(this).attr("data-id");
		   jQuery(this).parent('.approveform').find(".user_type").val($btn_attr);
		   var val = jQuery(".user_type").val();
		   
		   
		   var data = jQuery(this).parent('.approveform').serialize();
			$.ajax({
				url: '/approve_payment.php/',
				type: 'POST',
				data: data,
				beforeSend: function () {
						$btn.addClass('updating-icon');
				},
				success: function(response) {
					if(response == "success"){
						$btn.removeClass("approve");
						$btn_hide2.css("display","none");
						 $btn_hide1.css("display","none");
						 $btn_hide3.text("Approved");
						 $btn.removeClass('updating-icon');
						 window.location.reload(true);
					}
				}
			});      
			
    });
		
})
</script>
<style>
.ui-widget-header {
    border: 1px solid var(--tutor-primary-color);
    background: var(--tutor-primary-color);
}
.dataTables_wrapper .dataTables_filter input, .dataTables_wrapper select {
    color: #333;
}
.successgreen{color:green;}
.successgreen.approve, .required.approve {
    border: 1px solid #333;
	padding: 4px;
	display: block;
	margin-bottom: 10px;
	text-align: center;
}
.tutor-dashboard-info-table tbody tr td {
   
    padding: 20px 10px;
}
.tutor-dashboard-info-table thead tr td:first-child, .tutor-dashboard-info-table tbody tr td:first-child {
    padding-left: 10px;
}
</style>