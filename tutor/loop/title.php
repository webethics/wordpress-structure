<?php
/**
 * Course loop title
 *
 * @since v.1.0.0
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */
?>
<div class="elementor-widget-container">
			<h4 class="elementor-heading-title elementor-size-default"><?php the_title(); ?></h4>		
</div>

<p class="descrition-wrap"><?php 
					$excerpt = wp_trim_words( get_the_content(), 25); ?>
					<?php echo $excerpt; ?></p>



