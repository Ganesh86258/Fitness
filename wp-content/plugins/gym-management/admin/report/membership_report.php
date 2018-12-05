<?php 
 //$mebmer = get_users(array('role'=>'student','meta_key' => 'class_name', 'meta_value' => $class_id));
 global $wpdb;
 $table_name = $wpdb->prefix."gmgt_membershiptype";
 $q="SELECT * From $table_name";
 $member_ship_array = array();
 $result=$wpdb->get_results($q);
	foreach($result as $retrive)
	{
		$membership_id = $retrive->membership_id;
		//echo "<BR>".get_membership_name($membership_id);
		$member_ship_count =  count(get_users(array('role'=>'member','meta_key' => 'membership_id', 'meta_value' => $retrive->membership_id)));
		$member_ship_array[] = array('member_ship_id'=>$membership_id,
									 'member_ship_count'=>	$member_ship_count							
									);
		//echo $member_ship.",";
	}
$chart_array = array();
$chart_array[] = array(__('Membership','apartment_mgt'),__('Number Of Member','apartment_mgt'));	
foreach($member_ship_array as $r)
{
	$chart_array[]=array( get_membership_name($r['member_ship_id']),$r['member_ship_count']);
}
$options = Array(
		'title' => __('Membership Report','gym_mgt'),
		'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
		'legend' =>Array('position' => 'right',
				'textStyle'=> Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),

		'hAxis' => Array(
				'title' =>  __('Membership Name','gym_mgt'),
				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
				'textStyle' => Array('color' => '#66707e','fontSize' => 10),
				'maxAlternation' => 2


		),
		'vAxis' => Array(
				'title' =>  __('No of Member','gym_mgt'),
				'minValue' => 0,
				'maxValue' => 6,
				'format' => '#',
				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
				'textStyle' => Array('color' => '#66707e','fontSize' => 12),
				
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