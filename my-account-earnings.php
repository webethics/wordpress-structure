<?php
/**
 * Earnings
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/earnings.php.
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

$userid = get_current_user_id();
$earning_sum = get_user_earning_sum($userid);


$complete_status = get_user_earnings_completed_statuses();
$complete_status = "'".implode("','", $complete_status)."'";
$start_date = date("Y-m-01");
$end_date = date("Y-m-t");

$begin = new DateTime($start_date);
$end = new DateTime($end_date.' + 1 day');
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$datesPeriod = array();
foreach ($period as $dt) {
	$datesPeriod[$dt->format("Y-m-d")] = 0;
}

$salesQuery = $wpdb->get_results( "
              SELECT SUM(user_amount) as total_earning, 
              DATE(created_at)  as date_format 
              from {$wpdb->prefix}user_earnings 
              WHERE user_id = {$userid} AND order_status IN({$complete_status}) 
              AND (created_at BETWEEN '{$start_date}' AND '{$end_date}')
              GROUP BY date_format
              ORDER BY created_at ASC ;");
			  
$total_earning = wp_list_pluck($salesQuery, 'total_earning');
$queried_date = wp_list_pluck($salesQuery, 'date_format');
$dateWiseSales = array_combine($queried_date, $total_earning);

$chartData = array_merge($datesPeriod, $dateWiseSales);
foreach ($chartData as $key => $salesCount){
	unset($chartData[$key]);
	$formatDate = date('d M', strtotime($key));
	$chartData[$formatDate] = $salesCount;
}
?>

<h3><?php _e('Earnings', 'tutor') ?></h3>

<div class="tutor-dashboard-content-inner">

	<div class="tutor-dashboard-inline-links">
		<ul>
			<li class="active">
                <a href="<?php echo site_url().'/user-account/earnings'; ?>">
                    <?php _e('Earnings', 'tutor'); ?>
                </a>
			</li>
			<li>
                <a href="<?php echo site_url().'/user-account/earning-reports'; ?>">
                    <?php _e('Reports', 'tutor'); ?>
                </a>
			</li>
			<!--li>
                <a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('earnings/statements'); ?>">
                    <?php _e('Statements', 'tutor'); ?>
                </a>
            </li-->
		</ul>
	</div>

    <div class="tutor-dashboard-info-cards">
        <div class="tutor-dashboard-info-card">
            <p>
                <span> <?php _e('My Balance', 'tutor'); ?> </span>
                <span class="tutor-dashboard-info-val"><?php echo tutor_utils()->tutor_price($earning_sum->balance); ?></span>
            </p>
        </div>
        <div class="tutor-dashboard-info-card" title="<?php _e('All Time', 'tutor'); ?>">
            <p>
                <span> <?php _e('My Earnings', 'tutor'); ?> </span>
                <span class="tutor-dashboard-info-val"><?php echo tutor_utils()->tutor_price($earning_sum->user_amount); ?></span>
            </p>
        </div>
        <div class="tutor-dashboard-info-card"  title="<?php _e('Based on course price', 'tutor'); ?>">
            <p>
                <span> <?php _e('All time sales', 'tutor'); ?> </span>
                <span class="tutor-dashboard-info-val"><?php echo tutor_utils()->tutor_price($earning_sum->product_price_total); ?></span>
            </p>
        </div>
        <div class="tutor-dashboard-info-card" title="<?php _e('All of withdraw type excluding rejected.', 'tutor'); ?>">
            <p>
                <span> <?php _e('All time withdrawals', 'tutor'); ?> </span>
                <span class="tutor-dashboard-info-val"><?php echo tutor_utils()->tutor_price($earning_sum->withdraws_amount); ?></span>
            </p>
        </div>
        <div class="tutor-dashboard-info-card">
            <p>
                <span> <?php _e('Deducted Commissions', 'tutor'); ?> </span>
                <span class="tutor-dashboard-info-val"><?php echo tutor_utils()->tutor_price($earning_sum->admin_amount); ?></span>
            </p>
        </div>

        <?php if ($earning_sum->deduct_fees_amount > 0){ ?>
            <div class="tutor-dashboard-info-card">
                <p>
                    <span> <?php _e('Deducted Fees.', 'tutor'); ?> </span>
                    <span class="tutor-dashboard-info-val"><?php echo tutor_utils()->tutor_price($earning_sum->deduct_fees_amount); ?></span>
                </p>
            </div>
        <?php } ?>
    </div>

    <div class="tutor-dashboard-item-group">
        <h4><?php //_e('Earnings Chart for this month', 'tutor') ?> (<?php echo date("F") ?>)</h4>
        <canvas id="tutorChart" style="width: 100%; height: 400px;"></canvas>
    </div>

</div>

<?php
$tutor_primary_color = tutor_utils()->get_option('tutor_primary_color');
if ( ! $tutor_primary_color){
    $tutor_primary_color = '#3057D5';
}
?>

<script>
    var ctx = document.getElementById("tutorChart").getContext('2d');
    var tutorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_keys($chartData)); ?>,
            datasets: [{
                label: 'Earning',
                backgroundColor: '<?php echo $tutor_primary_color; ?>',
                borderColor: '<?php echo $tutor_primary_color; ?>',
                data: <?php echo json_encode(array_values($chartData)); ?>,
                borderWidth: 2,
                fill: false,
                lineTension: 0,
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0, // it is for ignoring negative step.
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            if (Math.floor(value) === value) {
                                return value;
                            }
                        }
                    }
                }]
            },

            legend: {
                display: false
            }
        }
    });
</script>