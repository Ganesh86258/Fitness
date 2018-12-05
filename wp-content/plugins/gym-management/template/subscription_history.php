<?php $curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_membership_payment=new MJ_Gmgt_membership_payment;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'subscription_historylist';
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
$(document).ready(function() 
{
	jQuery('#notice_list').DataTable({
		"responsive": true
		});
		$('#notice_form').validationEngine();
} );
</script>
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#subscription_list').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
					  {"bSortable": true},
					  {"bSortable": true},
					  {"bSortable": true}]
		});
} );
</script>	
<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">
     <li class="<?php if($active_tab=='subscription_historylist'){?>active<?php }?>">
			<a href="?dashboard=user&page=subscription_history&tab=subscription_historylist" class="tab <?php echo $active_tab == 'subscription_historylist' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Subscription History', 'gym_mgt'); ?></a>
          </a>
      </li>
</ul>
	<div class="tab-content">
	<?php 
	if($active_tab == 'subscription_historylist')
	{ ?>	
    	<div class="panel-body">
        <div class="table-responsive">
        <table id="subscription_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			<th><?php  _e( 'Title', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Amount', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Due Amount', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership <BR>Start Date', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership <BR>End Date', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Payment Status', 'gym_mgt' ) ;?></th>
			</tr>
        </thead>
		<tfoot>
            <tr>
			<th><?php  _e( 'Title', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Amount', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Due Amount', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership <BR>Start Date', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership <BR>End Date', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Payment Status', 'gym_mgt' ) ;?></th>
			</tr>
        </tfoot>
		<tbody>
        <?php 
		
		if($obj_gym->role == 'member')
		{	
			if($user_access['own_data']=='1')
			{
				$paymentdata=$obj_membership_payment->get_member_subscription_history($curr_user_id);
			}
			else
			{
				$paymentdata=$obj_membership_payment->get_all_member_subscription_history();
			}	
		}
		else
		{
			$paymentdata=$obj_membership_payment->get_all_member_subscription_history();
		}		
		 if(!empty($paymentdata))
		 {
		 	foreach ($paymentdata as $retrieved_data)
			{ 
			?>
            <tr>
				<td class="productname"><?php echo get_membership_name($retrieved_data->membership_id);?></td>
				
				<td class="totalamount"><?php  echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo $retrieved_data->membership_amount;?></td>
				<td class="totalamount"><?php  echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo $retrieved_data->membership_amount-$retrieved_data->paid_amount;?></td>
				<td class="paymentdate"><?php echo getdate_in_input_box($retrieved_data->start_date);?></td>
				<td class="paymentdate"><?php echo getdate_in_input_box($retrieved_data->end_date);?></td>
				<td class="paymentdate">
				<?php 
				echo "<span class='btn btn-success btn-xs'>";
				//echo get_membership_paymentstatus($retrieved_data->mp_id);
			   echo  __(get_membership_paymentstatus($retrieved_data->mp_id), 'gym_mgt' );
				echo "</span>";
				?>
				</td>
                
               	
               
            </tr>
            <?php } 
			
		}?>
     
        </tbody>
        
        </table>

 		</div>
		</div>
		<?php 
	} ?>
	</div>
</div>
<?php ?>