<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

global $post; ?>


<h3><?php _e('Favorites', 'tutor'); ?></h3>

<div class="tutor-dashboard-content-inner">
    

	<?php
	$wishlists = tutor_utils()->get_wishlist();
	$i = 1;
	if (is_array($wishlists) && count($wishlists)):
	?>
	<div class="tutor-wishlist">
        <table>
            <tbody>
				<tr>
					<th>S.No</th>
					<th>Class Info</th>
					<th>Class Status</th>
					<th>Action</th>
                </tr>
	<?php
        foreach ($wishlists as $post):
	        setup_postdata($post);
			
			$coming_soon = get_post_meta(get_the_ID(),"comingsoon",true);
			
	        /**
	         * @hook tutor_course/archive/before_loop_course
	         * @type action
	         * Usage Idea, you may keep a loop within a wrap, such as bootstrap col
	         */
		?>
		
	
                <tr>
					<td><?php echo $i; ?></td>
                    <td>
                        <div class="course">
                            <a href="<?php echo get_the_permalink(); ?>" ><?php echo get_the_title(); ?></a>
                        </div>
                    </td>
					<td>
                        <?php if($coming_soon == "coming"){ echo "Coming Soon"; }else{ if(get_post_status ( get_the_ID() ) == "publish"){echo "Published"; }}?>
                    </td>
					<td><div style="position:relative;" class="single-coursebtn btn-wrap tutor-course-loop-header-meta"><?php
					$course_id = get_the_ID();
						$is_wishlisted = tutor_utils()->is_wishlisted($course_id );
						$has_wish_list = '';
						if ($is_wishlisted){
							$has_wish_list = 'has-wish-listed';
							$text = "Remove From Favorites";
						}
						else{
							$text = "Add To Favorites";
						}

						$action_class = '';
						if ( is_user_logged_in()){
							$action_class = apply_filters('tutor_wishlist_btn_class', 'tutor-course-wishlist-btn');
						}else{
							$action_class = apply_filters('tutor_popup_login_class', 'cart-required-login');
						}
						echo '<span class="tutor-course-wishlist"><a href="javascript:;" class="tutor-icon-fav-line '.$action_class.' '.$has_wish_list.' " data-course-id="'.$course_id.'"><span>'.$text.'</span></a> </span>';
						?></div>
					</td>
                </tr>
                
			
		<?php
	
	        //do_action('tutor_course/archive/before_loop_course');

	        //tutor_load_template('loop.title');

	        /**
	         * @hook tutor_course/archive/after_loop_course
	         * @type action
	         * Usage Idea, If you start any div before course loop, you can end it here, such as </div>
	         */
	        do_action('tutor_course/archive/after_loop_course');
		$i++;
		endforeach;
		?>
		</tbody>
		</table>
    </div>
		<?php
		wp_reset_postdata();

	else:
        $msg = __('You do not have any course on the Favorites yet.', 'tutor');
        echo "<div class=\"tutor-col\">{$msg}</div>";
	endif;

	?>
   
</div>
