<?php
//access right
$user_access=get_userrole_wise_page_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		access_right_page_not_access_message();
		die;
	}
}
?>
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#accountant_list').DataTable({
		"responsive": true,
		 "order": [[ 1, "asc" ]],
		 "aoColumns":[
	                  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true}]	
		});
} );
</script>
<div class="panel-body panel-white">
    <ul class="nav nav-tabs panel_tabs" role="tablist">
      <li class="active">
          <a href="#staffmemberlist" role="tab" data-toggle="tab">
             <i class="fa fa-align-justify"></i> <?php _e('Accountant List', 'gym_mgt'); ?></a>
          </a>
      </li>
    </ul>
	<div class="tab-content">
		<div class="panel-body">
			<div class="table-responsive">
			    <table id="accountant_list" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
							<th><?php _e( 'Staff Member Name', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Staff Member Email', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Mobile No', 'gym_mgt' ) ;?></th>
						</tr>
				    </thead>
					<tfoot>
						<tr>
							<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
							<th><?php _e( 'Staff Member Name', 'gym_mgt' ) ;?></th>
						    <th> <?php _e( 'Staff Member Email', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Mobile No', 'gym_mgt' ) ;?></th>
						</tr>
					</tfoot>
					<tbody>
						<?php 
						$get_staff = array('role' => 'accountant');
						$staffdata=get_users($get_staff);
						if(!empty($staffdata))
						{
							foreach ($staffdata as $retrieved_data)
							{
						 ?>
							<tr>
								<td class="user_image"><?php $uid=$retrieved_data->ID;
											$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);
										if(empty($userimage))
										{
														echo '<img src='.get_option( 'gmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
										}
										else
											echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';
								?>
								</td>
								<td class="name"><a href="#"><?php echo $retrieved_data->display_name;?></a></td>
								<td class="email"><?php echo $retrieved_data->user_email;?></td>
								<td class="mobile"><?php echo $retrieved_data->mobile;?></td>
							</tr>
							<?php } 
						}?>
					</tbody>
				</table>
			</div>
			</div>
	</div>
</div>
<?php ?>