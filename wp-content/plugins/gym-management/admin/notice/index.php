<?php 
$obj_class=new MJ_Gmgtclassschedule;
$obj_notice=new MJ_Gmgtnotice;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'noticelist';
?>
<!-- View Popup Code -->	
<div class="popup-bg">
    <div class="overlay-content">
		<div class="notice_content"></div>    
	</div> 
</div>	
<!-- End Popup -->
<div class="page-inner" style="min-height:1631px !important">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>
	</div>
	<?php 
	if(isset($_POST['save_notice']))
	{
		
			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
			{
					
				$result=$obj_notice->gmgt_add_notice($_POST);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_notice&tab=noticelist&message=2');
				}
			}
			else
			{
				$result=$obj_notice->gmgt_add_notice($_POST);
					if($result)
					{
						wp_redirect ( admin_url().'admin.php?page=gmgt_notice&tab=noticelist&message=1');
					}
			} 
	}

	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			$result=$obj_notice->delete_notice($_REQUEST['notice_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=gmgt_notice&tab=noticelist&message=3');
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
							<a href="?page=gmgt_notice&tab=noticelist" class="nav-tab <?php echo $active_tab == 'noticelist' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Notice List', 'gym_mgt'); ?></a>
							
							<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
							{?>
							<a href="?page=gmgt_notice&tab=addnotice&&action=edit&notice_id=<?php echo $_REQUEST['notice_id'];?>" class="nav-tab <?php echo $active_tab == 'addnotice' ? 'nav-tab-active' : ''; ?>">
							<?php _e('Edit Notice', 'gym_mgt'); ?></a>  
							<?php 
							}
							else
							{?>
								<a href="?page=gmgt_notice&tab=addnotice" class="nav-tab <?php echo $active_tab == 'addnotice' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Notice', 'gym_mgt'); ?></a>
								
							<?php  }?>
						   
						</h2>
						 <?php 
						//Report 1 
						if($active_tab == 'noticelist')
						{ 
						?>	
						<script type="text/javascript">
						   $(document).ready(function() 
						   {
							jQuery('#product_list').DataTable({
								"responsive": true,
								"order": [[ 0, "asc" ]],
								"aoColumns":[
											  {"bSortable": true},
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
									<table id="product_list" class="display" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th><?php  _e( 'Notice Title', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Notice Comment', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Notice For', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Class', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Start Date', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'End Date', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
											</tr>
									    </thead>
										<tfoot>
											<tr>
												<th><?php  _e( 'Notice Title', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Notice Comment', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Notice For', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Class', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Start Date', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'End Date', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
											</tr>
										</tfoot>
										<tbody>
										 <?php $args['post_type'] = 'gmgt_notice';
										  $args['posts_per_page'] = -1;
										  $args['post_status'] = 'public';
										  $q = new WP_Query();
										   $noticedata = $q->query( $args );
										 if(!empty($noticedata))
										 {
											foreach ($noticedata as $retrieved_data){
										 ?>
											<tr>
												<td class="noticetitle"><a href="?page=gmgt_notice&tab=addnotice&action=edit&notice_id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->post_title;?></a></td>
												<td class="noticecontent"><?php $strlength= strlen($retrieved_data->post_content);
													if($strlength > 60)
														echo substr($retrieved_data->post_content, 0,60).'...';
													else
														echo $retrieved_data->post_content;?></td>
												<td class="productquentity"><?php echo ucwords(str_replace("_"," ",get_post_meta( $retrieved_data->ID, 'notice_for',true)));?></td>
												<td>
												 <?php 
												 if(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) =="all")
												 {
													 _e('All','gym_mgt');
												 }
												 elseif(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !=""){
												 echo gmgt_get_class_name(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true));}?></td>
												 <td><?php echo get_post_meta($retrieved_data->ID,'gmgt_start_date',true);?></td>
												 <td><?php echo get_post_meta($retrieved_data->ID,'gmgt_end_date',true);?></td>
												
												<td class="action"> 
												<a href="#" class="btn btn-success view-notice" id="<?php echo $retrieved_data->ID;?>"> <?php _e('View', 'gym_mgt' ) ;?></a>
												<a href="?page=gmgt_notice&tab=addnotice&action=edit&notice_id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
												<a href="?page=gmgt_notice&tab=noticelist&action=delete&notice_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
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
						if($active_tab == 'addnotice')
						{	
						require_once GMS_PLUGIN_DIR. '/admin/notice/add_notice.php';
					    }
						?>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<?php ?>