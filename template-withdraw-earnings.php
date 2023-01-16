<?php
/**
 * Withdraw Earnings
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/template-withdraw-earnings.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */
 defined( 'ABSPATH' ) || exit;

global $wpdb; 
$user_id = get_current_user_id();
$earning_sum = get_user_earning_sum($user_id);
//$min_withdraw = tutor_utils()->get_option('min_withdraw_amount');
$min_withdraw = get_option( 'woocommerce_user_withdrawl_amount', 1 );
$saved_account = tutor_utils()->get_user_withdraw_method();
$withdraw_method_name = tutor_utils()->avalue_dot('withdraw_method_name', $saved_account);

?>

<div class="tutor-dashboard-content-inner">
    <div class="tutor-dashboard-inline-links">
        <?php
        $settings_url = tutor_utils()->get_tutor_dashboard_page_permalink('settings');
        $withdraw = tutor_utils()->get_tutor_dashboard_page_permalink('settings/withdraw-settings');
        $reset_password = tutor_utils()->get_tutor_dashboard_page_permalink('settings/reset-password');
        ?>
      <ul>
           
            <li class="active">
                <a href="<?php echo site_url();  ?>/user-account/withdraw-earnings"> <?php _e('Withdraw Earnings', 'tutor'); ?></a>
            </li>
                <li>
                    <a href="<?php echo site_url();  ?>/user-account/withdraw-methods"> <?php _e('Withdraw Method', 'tutor'); ?></a>
                </li>
            
        </ul>
    </div>
	    <div class="withdraw-page-current-balance">
        <h4><?php _e('Current Balance', 'tutor'); ?></h4>

        <div class="withdraw-balance-row">

			<?php
			$balance_formatted = tutor_utils()->tutor_price($earning_sum->balance);
			if ($earning_sum->balance >= $min_withdraw){
				?>
                <p class="withdraw-balance-col">
					<?php echo sprintf( __('You currently have %s %s %s ready to withdraw', 'tutor'), "<strong class='available_balance'>", $balance_formatted, '</strong>' ); ?>
                </p>

				<?php if ($withdraw_method_name) { ?>
                    <p><a class="open-withdraw-form-btn" href="javascript:;"><?php _e( 'Make a withdraw', 'tutor' ); ?></a></p>
					<?php
				}
			}else{
				?>

                <p class="withdraw-balance-col"> <?php echo sprintf( __('You currently have %s %s %s and this is insufficient balance to withdraw',
						'tutor'), "<strong class='available_balance'>", $balance_formatted, '</strong>' ); ?>
                </p>

				<?php
			}
			?>

        </div>

        <div class="current-withdraw-account-wrap">
			<?php
                if ($withdraw_method_name){
                    ?>
                    <p>
                        <?php _e('You will get paid by', 'tutor'); ?> <strong><?php echo $withdraw_method_name; ?></strong>
                        <?php
                            $my_profile_url = site_url()."/user-account/withdraw-methods/";
                            echo sprintf(__( ' You can change update your %s Paypal email address %s ' , 'tutor'), "<a href='{$my_profile_url}'>", '</a>' );
                        ?>
                    </p>
                    <?php
                }else{
                    ?>
                    <p>
                        <?php
                       $my_profile_url = site_url()."/user-account/withdraw-methods/";
                            echo sprintf(__( ' You can change update your %s Paypal email address %s ' , 'tutor'), "<a href='{$my_profile_url}'>", '</a>' );
                        ?>
						<?php echo "(If you do not have a paypal account, create one <a target='_blank' href='https://www.paypal.com/signin'>here</a>)"; ?>
                    </p>
                    <?php
                }
			?>
        </div>

    </div>
<?php
	if ($earning_sum->balance >= $min_withdraw && $withdraw_method_name){
		?>

        <div class="tutor-earning-withdraw-form-wrap" style="display: none;">

            <form id="tutor-earning-withdraw-form" action="" method="post">
				<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
                <input type="hidden" value="user_make_an_withdraw" name="action"/>
				<?php do_action('tutor_withdraw_form_before'); ?>
                <div class="withdraw-form-field-row">
                    <label for="tutor_withdraw_amount"><?php _e('Amount:', 'tutor') ?></label>
                    <div class="tutor-row">
                        <div class="tutor-col-4">
                            <div class="withdraw-form-field-amount">
                                <input type="text" name="tutor_withdraw_amount">
                            </div>
                        </div>
                        <div class="tutor-col">
                            <div class="withdraw-form-field-button">
                                <button class="tutor-btn" type="submit" id="tutor-earning-withdraw-btn" name="withdraw-form-submit"><?php _e('Withdraw', 'tutor'); ?></button>
                            </div>
                        </div>
                    </div>
                    <i><?php _e('Enter withdraw amount and click withdraw button', 'tutor') ?></i>
                </div>

                <div id="tutor-withdraw-form-response"></div>

				<?php do_action('tutor_withdraw_form_after'); ?>
            </form>

        </div>

		<?php
	}
	?>


	<?php
	$withdraw_pending_histories = get_user_withdrawals_history($user_id, array('status' => array('pending')));
	$withdraw_completed_histories = get_user_withdrawals_history($user_id, array('status' => array('approved')));
	$withdraw_rejected_histories = get_user_withdrawals_history($user_id, array('status' => array('rejected')));
	?>

    <div class="withdraw-history-table-wrap">
        <div class="withdraw-history-table-title">
            <h4> <?php _e('Pending Withdrawals', 'tutor'); ?></h4>
        </div>

		<?php
		if (tutor_utils()->count($withdraw_pending_histories->results)){
			?>
            <table class="withdrawals-history">
                <thead>
                <tr>
                    <th><?php _e('Amount', 'tutor') ?></th>
                    <th><?php _e('Withdraw Method', 'tutor') ?></th>
                    <th><?php _e('Date', 'tutor') ?></th>
                </tr>
                </thead>
				<?php
				foreach ($withdraw_pending_histories->results as $withdraw_history){
					?>
                    <tr>
                        <td><?php echo tutor_utils()->tutor_price($withdraw_history->amount); ?></td>
                        <td>
							<?php
							$method_data = maybe_unserialize($withdraw_history->method_data);
							echo tutor_utils()->avalue_dot('withdraw_method_name', $method_data)
							?>
                        </td>
                        <td>
							<?php
							echo date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($withdraw_history->created_at));
							?>
                        </td>
                    </tr>
					<?php
				}
				?>
            </table>
			<h6 class="required">Your withdrawal could take up to 24 hours to post to your account.</h6>
			<?php
		}else{
			?>
            <p><?php _e('No withdrawals pending yet', 'tutor'); ?></p>
			<?php
		}
		?>
    </div>

    <div class="withdraw-history-table-wrap">
        <div class="withdraw-history-table-title">
            <h4> <?php _e('Completed Withdrawals', 'tutor'); ?></h4>
        </div>

		<?php
		if (tutor_utils()->count($withdraw_completed_histories->results)){
			?>
            <table class="withdrawals-history">
                <thead>
                <tr>
                    <th><?php _e('Amount', 'tutor') ?></th>
                    <th><?php _e('Withdraw Method', 'tutor') ?></th>
                    <th><?php _e('Requested At', 'tutor') ?></th>
                    <th><?php _e('Approved At', 'tutor') ?></th>
                </tr>
                </thead>
				<?php
				foreach ($withdraw_completed_histories->results as $withdraw_history){
					?>
                    <tr>
                        <td><?php echo tutor_utils()->tutor_price($withdraw_history->amount); ?></td>
                        <td>
							<?php
							$method_data = maybe_unserialize($withdraw_history->method_data);
							echo tutor_utils()->avalue_dot('withdraw_method_name', $method_data)
							?>
                        </td>
                        <td>
							<?php
							echo date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($withdraw_history->created_at));
							?>
                        </td>

                        <td>
                            <?php
                            if ($withdraw_history->updated_at){
	                            echo date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($withdraw_history->updated_at));
                            }
                            ?>
                        </td>
                    </tr>
					<?php
				}
				?>
            </table>
			<?php
		}else{
			?>
            <p><?php _e('No withdrawals completed yet', 'tutor'); ?></p>
			<?php
		}
		?>
    </div>


    <div class="withdraw-history-table-wrap">
        <div class="withdraw-history-table-title">
            <h4> <?php _e('Rejected Withdrawals', 'tutor'); ?></h4>
        </div>

		<?php
		if (tutor_utils()->count($withdraw_rejected_histories->results)){
			?>
            <table class="withdrawals-history">
                <thead>
                <tr>
                    <th><?php _e('Amount', 'tutor') ?></th>
                    <th><?php _e('Withdraw Method', 'tutor') ?></th>
                    <th><?php _e('Requested At', 'tutor') ?></th>
                    <th><?php _e('Rejected At', 'tutor') ?></th>
                </tr>
                </thead>
				<?php
				foreach ($withdraw_rejected_histories->results as $withdraw_history){
					?>
                    <tr>
                        <td><?php echo tutor_utils()->tutor_price($withdraw_history->amount); ?></td>
                        <td>
							<?php
							$method_data = maybe_unserialize($withdraw_history->method_data);
							echo tutor_utils()->avalue_dot('withdraw_method_name', $method_data)
							?>
                        </td>
                        <td>
							<?php
							echo date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($withdraw_history->created_at));
							?>
                        </td>

                        <td>
							<?php
							if ($withdraw_history->updated_at){
								echo date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($withdraw_history->updated_at));
							}
							?>
                        </td>
                    </tr>
					<?php
				}
				?>
            </table>
			<?php
		}else{
			?>
            <p><?php _e('No withdrawals rejected yet', 'tutor'); ?></p>
			<?php
		}
		?>
    </div>


</div>
