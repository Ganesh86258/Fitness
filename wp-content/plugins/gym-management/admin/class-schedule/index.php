<?php 
$obj_class=new MJ_Gmgtclassschedule;
$obj_membership=new MJ_Gmgtmembership;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'classlist';
?>

<!-- POP up code -->
<div class="popup-bg" style="z-index:100000 !important;">
    <div class="overlay-content">
		<div class="modal-content">
		   <div class="category_list"></div>
		</div>
    </div> 
</div>

<!-- End POP-UP Code -->
<div class="page-inner" style="min-height:1631px !important">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>
	</div>
	<?php 
	
	if(isset($_POST['save_class']))
	{
		
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			if($_POST['start_ampm'] == $_POST['end_ampm'] )
			{				
				if($_POST['end_time'] < $_POST['start_time'])
				{
					$time_validation='1';				
				
				}
				elseif($_POST['end_time'] ==  $_POST['start_time'] && $_POST['start_min'] > $_POST['end_min'] )
				{
					$time_validation='1';
				}
				elseif($_POST['end_time'] ==  $_POST['start_time'] && $_POST['start_min'] == $_POST['end_min'] )
				{
					$time_validation='1';
				}					
			}
			else
			{
				if($_POST['start_ampm']!='am')
				{
					$time_validation='1';
				}	
			}	
			if($time_validation=='1')
			{
				?>
				<div id="message" class="updated below-h2 ">
				<p>
				<?php 
					_e('End Time should be greater than Start Time','gym_mgt');
				?></p>
				</div>
				<?php 
			}
			else
			{	
				$result=$obj_class->gmgt_add_class($_POST);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_class&tab=classlist&message=2');
				}
			}	
				
		}
		else
		{
			if($_POST['start_ampm'] == $_POST['end_ampm'] )
			{				
				if($_POST['end_time'] < $_POST['start_time'])
				{
					$time_validation='1';					
				
				}
				elseif($_POST['end_time'] ==  $_POST['start_time'] && $_POST['start_min'] > $_POST['end_min'] )
				{
					$time_validation='1';
				}	
				elseif($_POST['end_time'] ==  $_POST['start_time'] && $_POST['start_min'] == $_POST['end_min'] )
				{
					$time_validation='1';
				}		
			}
			else
			{
				if($_POST['start_ampm']!='am')
				{
					$time_validation='1';
				}	
			}	
			if($time_validation=='1')
			{
				?>
				<div id="message" class="updated below-h2 ">
				<p>
				<?php 
					_e('End Time should be greater than Start Time','gym_mgt');
				?></p>
				</div>
				<?php 
			}
			else
			{			
				$result=$obj_class->gmgt_add_class($_POST);
	
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_class&tab=classlist&message=1');
				}
			}
		}
	}
	
		
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
			{
				
				$result=$obj_class->delete_class($_REQUEST['class_id']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_class&tab=classlist&message=3');
				}
			}
		if(isset($_REQUEST['message']))
	{
		$message =$_REQUEST['message'];
		if($message == 1)
		{?>
				<div id="message" class="updated below-h2 ">
				<p>
				<?php 
					_e('Record inserted successfully','gym_mgt');
				?></p></div>
				<?php 
			
		}
		elseif($message == 2)
		{?><div id="message" class="updated below-h2 "><p><?php
					_e("Record updated successfully.",'gym_mgt');
					?></p>
					</div>
				<?php 
			
		}
		elseif($message == 3) 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php 
			_e('Record deleted successfully','gym_mgt');
		?></div></p><?php
				
		}
	}
	?>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=gmgt_class&tab=classlist" class="nav-tab <?php echo $active_tab == 'classlist' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Class List', 'gym_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
        <a href="?page=gmgt_class&tab=addclass&action=edit&class_id=<?php echo $_REQUEST['class_id'];?>" class="nav-tab <?php echo $active_tab == 'addclass' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Class', 'gym_mgt'); ?></a>  
		<?php 
		}
		else
		{?>
			<a href="?page=gmgt_class&tab=addclass" class="nav-tab <?php echo $active_tab == 'addclass' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Class', 'gym_mgt'); ?></a>
			
		<?php  }?>
		<a href="?page=gmgt_class&tab=schedulelist" class="nav-tab <?php echo $active_tab == 'schedulelist' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Schedule List', 'gym_mgt'); ?></a>
		
       
    </h2>
     <?php 
	//Report 1 
	
	if($active_tab == 'classlist')
	{ 
	
	?>	
    <script type="text/javascript">
$(document).ready(function() {
	jQuery('#class_list').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": false}]
		});
} );
</script>
    <form name="wcwm_report" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="class_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			<th><?php  _e( 'Class Name', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Staff Name', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Starting Time', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Ending Time', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Day', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			<th><?php  _e( 'Class Name', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Staff Name', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Starting Time', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Ending Time', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Day', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
            </tr>
        </tfoot>
 
        <tbody>
         <?php 
		
		
			$classdata=$obj_class->get_all_classes();
		 if(!empty($classdata))
		 {
		 	foreach ($classdata as $retrieved_data){

		 ?>
            <tr>
				<td class="classname"><a href="?page=gmgt_class&tab=addclass&action=edit&class_id=<?php echo $retrieved_data->class_id;?>"><?php echo $retrieved_data->class_name;?></a></td>
                <td class="staff"><?php $userdata=get_userdata( $retrieved_data->staff_id );
				echo $userdata->display_name;?></td>
				<td class="starttime"><?php echo $retrieved_data->start_time;?></td>
				<td class="endtime"><?php echo $retrieved_data->end_time;?></td>
				<td class="day"><?php $days_array=json_decode($retrieved_data->day); 
				$days_string=array();
				if(!empty($days_array)){
					foreach($days_array as $day)
					{
						$days_string[]=substr($day,0,3);
					}
				}
				echo implode(", ",$days_string);?></td>
				
               	<td class="action"> <a href="?page=gmgt_class&tab=addclass&action=edit&class_id=<?php echo $retrieved_data->class_id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
                <a href="?page=gmgt_class&tab=classlist&action=delete&class_id=<?php echo $retrieved_data->class_id;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
                <?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
                
                </td>
               
            </tr>
            <?php } 
			
		}?>
     
        </tbody>
        
        </table>
        </div>
        </div>
       
</form>
     <?php 
	 }
	
	if($active_tab == 'addclass')
	 {
	require_once GMS_PLUGIN_DIR. '/admin/class-schedule/add_class.php';
	 }
	 if($active_tab == 'schedulelist')
	 {
	require_once GMS_PLUGIN_DIR. '/admin/class-schedule/schedule_list.php';
	 }

	 ?>
</div>
			
	</div>
	</div>
</div>

<?php ?>