<?

/**
 * Display single login
 *
 * @since v.1.0.0
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

get_header();

?>

<? do_action('tutor/template/login/before/wrap'); ?>
    <div <? tutor_post_class('tutor-page-wrap'); ?>>

        <div class="tutor-template-segment tutor-login-wrap">
            <div class="tutor-login-title">
                <h4><? _e('Sign In', 'tutor'); ?></h4>
            </div>

            <div class="tutor-template-login-form">
				<? tutor_load_template( 'global.login' ); ?>
            </div>
        </div>
    </div><!-- .wrap -->

<? do_action('tutor/template/login/after/wrap'); ?>



<?
get_footer();
