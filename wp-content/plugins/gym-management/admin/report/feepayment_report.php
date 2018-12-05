<?php 
$month =array('1'=>__('January','apartment_mgt'),'2'=>__('February','apartment_mgt'),'3'=>__('March','apartment_mgt'),'4'=>__('April','apartment_mgt'),
		'5'=>__('May','apartment_mgt'),'6'=>__('June','apartment_mgt'),'7'=>__('July','apartment_mgt'),'8'=>__('August','apartment_mgt'),
		'9'=>__('September','apartment_mgt'),'10'=>"__('Octomber','apartment_mgt')",'11'=>__('November','apartment_mgt'),'12'=>__('December','apartment_mgt'),);
$year =isset($_POST['year'])?$_POST['year']:date('Y');
global $wpdb;

$table_name = $wpdb->prefix."gmgt_membership_payment_history";
$q="SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM ".$table_name." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC";

$result=$wpdb->get_results($q);
$chart_array = array();
$chart_array[] = array(__('Month','apartment_mgt'),__('Fee Payment','apartment_mgt'));
foreach($result as $r)
{
$chart_array[]=array( $month[$r->date],(int)$r->count);
}
$options = Array(
			'title' => __('Fee Payment Report By Month','gym_mgt'),
			'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
			'legend' =>Array('position' => 'right',
						'textStyle'=> Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),

			'hAxis' => Array(
				'title' => __('Month','gym_mgt'),
				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
				'textStyle' => Array('color' => '#66707e','fontSize' => 11),
				'maxAlternation' => 2

				),
			'vAxis' => Array(
				'title' => __('Fee Payment','gym_mgt'),
				 'minValue' => 0,
				'maxValue' => 6,
				 'format' => '#',
				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
				'textStyle' => Array('color' => '#66707e','fontSize' => 12)
				),
 		'colors' => array('#22BAA0')
			);
require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
$GoogleCharts = new GoogleCharts;
$chart = $GoogleCharts->load( 'column' , 'chart_div' )->get( $chart_array , $options );
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.sdate').datepicker({dateFormat: "yy-mm-dd"}); 
	$('.edate').datepicker({dateFormat: "yy-mm-dd"}); 
} );
</script>
<div id="chart_div" class="chart_div"></div>
  <!-- Javascript --> 
  <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
  <script type="text/javascript">
			<?php if(!empty($result))
						echo $chart;?>
  </script>