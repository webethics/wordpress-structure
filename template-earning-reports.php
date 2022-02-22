<?php
/**
 * Reports
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/reports.php.
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
$sub_page = 'this_month';
if ( ! empty($_GET['time_period'])){
	$sub_page = sanitize_text_field($_GET['time_period']);
}
if ( ! empty($_GET['date_range_from']) && ! empty($_GET['date_range_to'])){
	$sub_page = 'date_range';
}


?>

    <h3><?php _e('Earning Report', 'tutor'); ?></h3>
    <div class="tutor-dashboard-inline-links">
        <ul>
            <li><a href="<?php echo site_url().'/user-account/earnings'; ?>">
                    <?php _e('Earnings', 'tutor'); ?>
                </a>
            </li>
            <li class="active"><a href="<?php echo site_url().'/user-account/earning-reports'; ?>">
                    <?php _e('Reports', 'tutor'); ?>
                </a>
            </li>
            <!--li>
                <a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('earning/statements'); ?>">
                    <?php _e('Statements'); ?> </a>
            </li-->
        </ul>
    </div>
<div class="tutor-date-range-filter-wrap">
	<?php
	$time_periods = array(
		'last_year' => __('Last Year', 'tutor'),
		'this_year' => __('This Year', 'tutor'),
		'last_month' => __('Last Month', 'tutor'),
		'this_month' => __('This Month', 'tutor'),
		'last_week' => __('Last Week', 'tutor'),
		'this_week' => __('This Week', 'tutor'),
	);
	?>
	<div class="report-top-sub-menu">
		<?php
		foreach ($time_periods as $period => $period_name){
			$activeClass = ( $sub_page === $period ) ? 'active' : '' ;

			$timePeriodPageURL = add_query_arg(array('time_period' => $period));
			$timePeriodPageURL = remove_query_arg(array('date_range_from', 'date_range_to', 'tutor_report_action'), $timePeriodPageURL);

			echo '<a href="'.$timePeriodPageURL.'" class="'.$activeClass.'">'.$period_name.'</a> ';
		}
		?>
	</div>
	<div class="tutor-date-range-wrap">
		<form action="" class="report-date-range-form" method="get">
			<?php
			$query_arg = $_GET;
			if ( ! empty($query_arg) && is_array($query_arg)){
				if (isset($query_arg['time_period'])){
					unset($query_arg['time_period']);
				}

				foreach ($query_arg as $name => $value){
					echo "<input type='hidden' name='{$name}' value='{$value}' />";
				}
			}

			$date_range_from = '';
			if (isset($query_arg['date_range_from'])) {
				$date_range_from = sanitize_text_field($query_arg['date_range_from']);
			}
			$date_range_to = '';
			if (isset($query_arg['date_range_to'])) {
				$date_range_to = sanitize_text_field($query_arg['date_range_to']);
			}
			?>

			<div class="date-range-input">
				<input type="text" name="date_range_from" class="tutor_report_datepicker" value="<?php echo $date_range_from; ?>" autocomplete="off" placeholder="<?php echo date("Y-m-d", strtotime("last sunday midnight")); ?>" />
				<i class="tutor-icon-calendar"></i>
			</div>

			<div class="date-range-input">
				<input type="text" name="date_range_to" class="tutor_report_datepicker" value="<?php echo $date_range_to; ?>" autocomplete="off" placeholder="<?php echo date("Y-m-d"); ?>" />
				<i class="tutor-icon-calendar"></i>
			</div>

			<div class="date-range-input">
				<button type="submit"><i class="tutor-icon-magnifying-glass-1"></i> </button>
			</div>
		</form>
	</div>
</div>
<?php



if($sub_page == "this_month"){


/**
 * Getting the This Month
 */
$start_date = date("Y-m-01 00:00:00");
$end_date = date("Y-m-t 23:59:59");
$datearr = compact('start_date', 'end_date');

$earning_sum = get_user_earning_sum($user_id,$datearr);
if ( ! $earning_sum){
	echo '<p>'.__('No Earning info available', 'tutor' ).'</p>';
	return;
}

$complete_status = get_user_earnings_completed_statuses();
$statuses = $complete_status;
$complete_status = "'".implode("','", $complete_status)."'";

/**
 * Format Date Name
 */
$begin = new DateTime($start_date);
$end = new DateTime($end_date);
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$datesPeriod = array();
foreach ($period as $dt) {
	$datesPeriod[$dt->format("Y-m-d")] = 0;
}

/**
 * Query This Month
 */

$salesQuery = $wpdb->get_results( "
              SELECT SUM(user_amount) as total_earning, 
              DATE(created_at)  as date_format 
              from {$wpdb->prefix}user_earnings 
              WHERE user_id = {$user_id} AND order_status IN({$complete_status}) 
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
}
if($sub_page == "last_year"){

$year = date('Y', strtotime('-1 year'));
$dataFor = 'yearly';
$datayear = compact('year', 'dataFor');
$earning_sum = get_user_earning_sum($user_id,$datayear);

if ( ! $earning_sum){
	echo '<p>'.__('No Earning info available', 'tutor' ).'</p>';
	return;
}

$complete_status = get_user_earnings_completed_statuses();
$statuses = $complete_status;
$complete_status = "'".implode("','", $complete_status)."'";


/**
 * Query This Month
 */

$salesQuery = $wpdb->get_results( "
              SELECT SUM(user_amount) as total_earning, 
              MONTHNAME(created_at)  as month_name 
              from {$wpdb->prefix}user_earnings 
              WHERE user_id = {$user_id} AND order_status IN({$complete_status}) 
              AND YEAR(created_at) = {$year} 
              GROUP BY MONTH (created_at) 
              ORDER BY MONTH(created_at) ASC ;");

$total_earning = wp_list_pluck($salesQuery, 'total_earning');
$months = wp_list_pluck($salesQuery, 'month_name');
$monthWiseSales = array_combine($months, $total_earning);

/**
 * Format yearly
 */
$emptyMonths = array();
for ($m=1; $m<=12; $m++) {
	$emptyMonths[date('F', mktime(0,0,0,$m, 1, date('Y')))] = 0;
}
$chartData = array_merge($emptyMonths, $monthWiseSales);
}
if($sub_page == "this_year"){

$year = date('Y');
$dataFor = 'yearly';
$datedata = compact('year', 'dataFor');
$earning_sum = get_user_earning_sum($user_id,$datedata);

if ( ! $earning_sum){
	echo '<p>'.__('No Earning info available', 'tutor' ).'</p>';
	return;
}

$complete_status = get_user_earnings_completed_statuses();
$statuses = $complete_status;
$complete_status = "'".implode("','", $complete_status)."'";


/**
 * Query This Month
 */

$salesQuery = $wpdb->get_results( "
              SELECT SUM(user_amount) as total_earning, 
              MONTHNAME(created_at)  as month_name 
              from {$wpdb->prefix}user_earnings 
              WHERE user_id = {$user_id} AND order_status IN({$complete_status}) 
              AND YEAR(created_at) = {$year} 
              GROUP BY MONTH (created_at) 
              ORDER BY MONTH(created_at) ASC ;");

$total_earning = wp_list_pluck($salesQuery, 'total_earning');
$months = wp_list_pluck($salesQuery, 'month_name');
$monthWiseSales = array_combine($months, $total_earning);

/**
 * Format yearly
 */
$emptyMonths = array();
for ($m=1; $m<=12; $m++) {
	$emptyMonths[date('F', mktime(0,0,0,$m, 1, date('Y')))] = 0;
}
$chartData = array_merge($emptyMonths, $monthWiseSales);
}
if($sub_page == "last_month"){ 
$start_date = date('Y-m-01 00:00:00', strtotime('last day of last month'));
$end_date = date("Y-m-t 23:59:59", strtotime($start_date));
$datedata = compact('start_date', 'end_date');
$earning_sum = get_user_earning_sum($user_id,$datedata);

if ( ! $earning_sum){
	echo '<p>'.__('No Earning info available', 'tutor' ).'</p>';
	return;
}

$complete_status = get_user_earnings_completed_statuses();
$statuses = $complete_status;
$complete_status = "'".implode("','", $complete_status)."'";

/**
 * Format Date Name
 */
$begin = new DateTime($start_date);
$end = new DateTime($end_date);
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$datesPeriod = array();
foreach ($period as $dt) {
	$datesPeriod[$dt->format("Y-m-d")] = 0;
}

/**
 * Query This Month
 */

$salesQuery = $wpdb->get_results( "
              SELECT SUM(user_amount) as total_earning, 
              DATE(created_at)  as date_format 
              from {$wpdb->prefix}user_earnings 
              WHERE user_id = {$user_id} AND order_status IN({$complete_status}) 
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
}
if($sub_page == "last_week"){ 
$previous_week = strtotime("-1 week +1 day");
$start_date = strtotime("last sunday midnight",$previous_week);
$end_date = strtotime("next saturday",$start_date);
$start_date = date("Y-m-d 00:00:00",$start_date);
$end_date = date("Y-m-d 23:59:59",$end_date);

$weekdata = compact('start_date', 'end_date');

$earning_sum = get_user_earning_sum($user_id,$weekdata);

if ( ! $earning_sum){
	echo '<p>'.__('No Earning info available', 'tutor' ).'</p>';
	return;
}

$complete_status = get_user_earnings_completed_statuses();
$statuses = $complete_status;
$complete_status = "'".implode("','", $complete_status)."'";

/**
 * Format Date Name
 */
$begin = new DateTime($start_date);
$end = new DateTime($end_date);
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$datesPeriod = array();
foreach ($period as $dt) {
	$datesPeriod[$dt->format("Y-m-d")] = 0;
}

/**
 * Query This Month
 */

$salesQuery = $wpdb->get_results( "
              SELECT SUM(user_amount) as total_earning, 
              DATE(created_at)  as date_format 
              from {$wpdb->prefix}user_earnings 
              WHERE user_id = {$user_id} AND order_status IN({$complete_status}) 
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
}

if($sub_page == "this_week"){ 
$start_date = date("Y-m-d 00:00:00", strtotime("last sunday midnight"));
$end_date = date("Y-m-d 23:59:59", strtotime("next saturday"));
$dateadata = compact('start_date', 'end_date');
$earning_sum = get_user_earning_sum($user_id,$dateadata);

if ( ! $earning_sum){
	echo '<p>'.__('No Earning info available', 'tutor' ).'</p>';
	return;
}

$complete_status = get_user_earnings_completed_statuses();
$statuses = $complete_status;
$complete_status = "'".implode("','", $complete_status)."'";

/**
 * Format Date Name
 */
$begin = new DateTime($start_date);
$end = new DateTime($end_date);
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$datesPeriod = array();
foreach ($period as $dt) {
	$datesPeriod[$dt->format("Y-m-d")] = 0;
}

/**
 * Query This Month
 */

$salesQuery = $wpdb->get_results( "
              SELECT SUM(user_amount) as total_earning, 
              DATE(created_at)  as date_format 
              from {$wpdb->prefix}user_earnings 
              WHERE user_id = {$user_id} AND order_status IN({$complete_status}) 
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

}

$date_range_from = $_GET['date_range_from'];
$date_range_to = $_GET['date_range_to'];
if(!empty($date_range_from) || !empty($date_range_to)){
 $start_date = sanitize_text_field(tutor_utils()->avalue_dot('date_range_from', $_GET)).' 00:00:00';
 $end_date = sanitize_text_field(tutor_utils()->avalue_dot('date_range_to', $_GET)).' 23:59:59';
 $datedata = compact('start_date', 'end_date');
$earning_sum = get_user_earning_sum($user_id,$datedata);

if ( ! $earning_sum){
	echo '<p>'.__('No Earning info available', 'tutor' ).'</p>';
	return;
}
$complete_status = get_user_earnings_completed_statuses();
$statuses = $complete_status;
$complete_status = "'".implode("','", $complete_status)."'";

$begin = new DateTime($start_date);
$end = new DateTime($end_date);
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$datesPeriod = array();
foreach ($period as $dt) {
	$datesPeriod[$dt->format("Y-m-d")] = 0;
}

/**
 * Query This Month
 */

$salesQuery = $wpdb->get_results( "
              SELECT SUM(user_amount) as total_earning, 
              DATE(created_at)  as date_format 
              from {$wpdb->prefix}user_earnings 
              WHERE user_id = {$user_id} AND order_status IN({$complete_status}) 
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


}
?>
   <div class="tutor-dashboard-info-cards">
        <div class="tutor-dashboard-info-card" title="<?php _e('All time', 'tutor'); ?>">
            <p>
                <span> <?php _e('My Earning', 'tutor'); ?> </span>
                <span class="tutor-dashboard-info-val"><?php echo tutor_utils()->tutor_price($earning_sum->user_amount); ?></span>
            </p>
        </div>
        <div class="tutor-dashboard-info-card" title="<?php _e('Based on course price', 'tutor'); ?>">
            <p>
                <span> <?php _e('All time sales', 'tutor'); ?> </span>
                <span class="tutor-dashboard-info-val"><?php echo tutor_utils()->tutor_price($earning_sum->product_price_total); ?></span>
            </p>
        </div>
        <div class="tutor-dashboard-info-card">
            <p>
                <span> <?php _e('Deducted Commissions', 'tutor'); ?> </span>
                <span class="tutor-dashboard-info-val"><?php echo tutor_utils()->tutor_price($earning_sum->admin_amount); ?></span>
            </p>
        </div>


        <?php if ($earning_sum->deduct_fees_amount > 0){ ?>
            <div class="tutor-dashboard-info-card" title="<?php _e('Deducted Fees', 'tutor'); ?>">
                <p>
                    <span> <?php _e('Deducted Fees', 'tutor'); ?> </span>
                    <span class="tutor-dashboard-info-val"><?php echo tutor_utils()->tutor_price($earning_sum->deduct_fees_amount); ?></span>
                </p>
            </div>
        <?php } ?>
    </div>

<div class="tutor-dashboard-item-group">
<?php if($sub_page == "this_month"){ ?>
    <h4><?php echo sprintf(__("Earning Data for the month of %s", 'tutor'), date("F, Y", strtotime($start_date)));?></h4>
<?php } 
if($sub_page == "last_year"){ ?>
	<h4><?php echo sprintf(__("Earning Data for the year of %s", 'tutor'), $year);?></h4>
<?php } 
if($sub_page == "this_year"){ ?>
	<h4><?php echo sprintf(__("Earning Data for the year of %s", 'tutor'), $year);?></h4>
<?php } 
if($sub_page == "last_month"){ ?>
    <h4><?php echo sprintf(__("Earning Data for the month of %s", 'tutor'), date("F, Y", strtotime($start_date)));?></h4>
<?php }
if($sub_page == "last_week"){  ?>
  <h4><?php echo sprintf(__("Showing Result from %s to %s", 'tutor'), $begin->format('d F, Y'), $end->format('d F, Y')); ?></h4>
<?php } 
if(!empty($date_range_from) || !empty($date_range_to)){ ?>

 <h4><?php echo sprintf(__("Showing Result from %s to %s", 'tutor'), $begin->format('d F, Y'), $end->format('d F, Y')); ?></h4>
<?php } ?>
<canvas id="tutorChart" style="width: 100%; height: 400px;"></canvas>
<script>
    var ctx = document.getElementById("tutorChart").getContext('2d');
    var tutorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_keys($chartData)); ?>,
            datasets: [{
                label: 'Earning',
                backgroundColor: '#3057D5',
                borderColor: '#3057D5',
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
</div>