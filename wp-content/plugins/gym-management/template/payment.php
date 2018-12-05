<?php $curr_user_id=get_current_user_id();
$obj_class=new MJ_Gmgtclassschedule;
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_payment=new MJ_Gmgtpayment;
global $wpdb;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'incomelist';
//access right
$user_access=get_userrole_wise_page_access_right_array();

if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		access_right_page_not_access_message();
		die;
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
	{
		if($user_access['edit']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}			
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
	{
		if($user_access['delete']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}	
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
	{
		if($user_access['add']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}	
	}
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='success')
{ ?>
	<div id="message" class="updated below-h2 "><p>	<?php _e('Payment successfully','gym_mgt');	?></p></div>
<?php
}	
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='cancel')	
{ ?>
		<div id="message" class="updated below-h2 "><p>	<?php 	_e('Payment Cancel','gym_mgt');	?></p></div>
	<?php
}	
if(isset($_POST['payer_status']) && $_POST['payer_status'] == 'VERIFIED' && (isset($_POST['payment_status'])) && $_POST['payment_status']=='Completed' && isset($_REQUEST['half']) && $_REQUEST['half']=='yes' )
{	
	//$gmgt_sales_payment_history = $wpdb->prefix. 'gmgt_sales_payment_history';
	$trasaction_id  = $_POST["txn_id"];
	$incomedata['member_id']=get_current_user_id();
	$custom_array = explode("_",$_POST['custom']);
	$incomedata['income_id']=$custom_array[1];
	$incomedata['amount']=$_POST['mc_gross_1'];
	$incomedata['trasaction_id']=$trasaction_id ;
	$incomedata['payment_method']='paypal';
	$incomedata['created_by']=get_current_user_id();
	$result = $obj_payment->add_income_payment_history($incomedata);
	wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&action=success');
}
if(isset($_POST['add_fee_payment']))
{
	//POP up data save in payment history
	if($_POST['payment_method'] == 'Paypal')
	{				
		require_once GMS_PLUGIN_DIR. '/lib/paypal/paypal_process.php';				
	}
	else
	{
		$result=$obj_payment->add_income_payment($_POST);
			
		wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&action=success');
	}	
}

if(isset($_POST['save_product']))
{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_payment->gmgt_add_payment($_POST);
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=paymentlist&message=2');
		}
			
	}
	else
	{
		$result=$obj_payment->gmgt_add_payment($_POST);

			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=paymentlist&message=1');
			}
		
		}
		
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	if(isset($_REQUEST['payment_id'])){
	$result=$obj_payment->delete_payment($_REQUEST['payment_id']);
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=paymentlist&message=3');
		}
	}
	if(isset($_REQUEST['income_id'])){
	$result=$obj_payment->delete_income($_REQUEST['income_id']);
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&message=3');
		}
	}
	if(isset($_REQUEST['expense_id'])){
		$result=$obj_payment->delete_expense($_REQUEST['expense_id']);
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=expenselist&message=3');
		}
	}
}
	//--------save income-------------
	if(isset($_POST['save_income']))
	{
			
		if($_REQUEST['action']=='edit')
		{
				
			$result=$obj_payment->add_income($_POST);
			if($result)
			{
				wp_redirect (  home_url() . '?dashboard=user&page=payment&tab=incomelist&message=2');
			}
		}
		else
		{
			$result=$obj_payment->add_income($_POST);
			if($result)
			{
				wp_redirect (  home_url() . '?dashboard=user&page=payment&tab=incomelist&message=1');
			}
		}
			
	}		
	//--------save Expense-------------
	if(isset($_POST['save_expense']))
	{
			
		if($_REQUEST['action']=='edit')
		{
				
			$result=$obj_payment->add_expense($_POST);
			if($result)
			{
				wp_redirect (  home_url() . '?dashboard=user&page=payment&tab=expenselist&message=2');
			}
		}
		else
		{
			$result=$obj_payment->add_expense($_POST);
			if($result)
			{
				wp_redirect (  home_url() . '?dashboard=user&page=payment&tab=expenselist&message=1');
			}
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
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
		   <div class="invoice_data"> </div>
		</div>
    </div> 
</div>
<!-- End POP-UP Code -->
<script type="text/javascript">
$(document).ready(function() 
{
   var date = new Date();
	date.setDate(date.getDate()-0);
	$.fn.datepicker.defaults.format =" <?php  echo get_option('gmgt_datepicker_format'); ?>";
	 $('.date_field').datepicker({
	<?php
	if(get_option('gym_enable_datepicker_privious_date')=='no')
	{
	?>
		startDate: date,
	<?php
	}
	?>	
	 autoclose: true
   }); 
	jQuery('#members_list').DataTable({
		"responsive": true,
		 "order": [[ 1, "asc" ]],
		 "aoColumns":[
	                  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true}]
		});
		$('#member_form').validationEngine();
		$(".display-members").select2();
		
} );
</script>
<div class="panel-body panel-white">
    <ul class="nav nav-tabs panel_tabs" role="tablist">
		<li class="<?php if($active_tab=='incomelist'){?>active<?php }?>">
			<a href="?dashboard=user&page=payment&tab=incomelist" class="tab <?php echo $active_tab == 'incomelist' ? 'active' : ''; ?>">
			 <i class="fa fa-align-justify"></i> <?php _e('Income List', 'gym_mgt'); ?></a>
			 </a>
		</li>
		<li class="<?php if($active_tab=='addincome'){?>active<?php }?>">
			  <?php 
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['income_id']))
				{
				?>
				<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php if(isset($_REQUEST['income_id'])) echo $_REQUEST['income_id'];?>"" class="tab <?php echo $active_tab == 'addincome' ? 'active' : ''; ?>">
				 <i class="fa fa"></i> <?php _e('Edit Income', 'gym_mgt'); ?></a>
				 <?php 
				}
				else
				{
					if($user_access['add']=='1')
					{
					?>
						<a href="?dashboard=user&page=payment&tab=addincome&&action=insert" class="tab <?php echo $active_tab == 'addincome' ? 'active' : ''; ?>">
						<i class="fa fa-plus-circle"></i> <?php _e('Add Income', 'gym_mgt'); ?></a>
					<?php 	
					}
				}		
				?>
		</li>
	<?php
	if($obj_gym->role=='staff_member' || $obj_gym->role=='accountant')
	{
	?>
		<li class="<?php if($active_tab=='expenselist'){?>active<?php }?>">
				<a href="?dashboard=user&page=payment&tab=expenselist" class="tab <?php echo $active_tab == 'expenselist' ? 'active' : ''; ?>">
				 <i class="fa fa-align-justify"></i> <?php _e('Expense List', 'gym_mgt'); ?></a>
			  </a>
		</li>
		<li class="<?php if($active_tab=='addexpense'){?>active<?php }?>">
			  <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['income_id']))
				{?>
				<a href="?dashboard=user&page=payment&tab=addexpense&action=edit&expense_id=<?php if(isset($_REQUEST['income_id'])) echo $_REQUEST['income_id'];?>"" class="tab <?php echo $active_tab == 'addexpense' ? 'active' : ''; ?>">
				 <i class="fa fa"></i> <?php _e('Edit Expense', 'gym_mgt'); ?></a>
				 <?php }
				else
				{
					if($user_access['add']=='1')
					{
					?>
						<a href="?dashboard=user&page=payment&tab=addexpense&&action=insert" class="tab <?php echo $active_tab == 'addexpense' ? 'active' : ''; ?>">
						<i class="fa fa-plus-circle"></i> <?php _e('Add Expense', 'gym_mgt'); ?></a>
		  <?php		} 
				}
		  ?>	
		 </li>
	<?php 
	}
    ?>
    </ul>
	<div class="tab-content">
	<?php  	
	if($active_tab == 'incomelist')
	{
	?>
	<!--Income information-->
	<script type="text/javascript">
	$(document).ready(function() {
		jQuery('#tblincome').DataTable({
			"responsive": true,
			 "order": [[ 1, "Desc" ]],
			 "aoColumns":[
						  {"bSortable": true},
						  {"bSortable": true},
						  {"bSortable": true}, 
						  {"bSortable": true}, 
						  {"bSortable": true}, 
						  {"bSortable": true}, 
						  {"bSortable": true}, 
						  {"bSortable": true}, 
						  
						{"bSortable": false}
					   ]
			});
	} );
	</script>
    <div class="panel-body">
        	<div class="table-responsive">
				<table id="tblincome" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th> <?php _e( 'Member Name', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Income Name', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Invoice No', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Amount', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Paid Amount', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Due Amount', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Date', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Payment Status', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>				   
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th> <?php _e( 'Member Name', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Income Name', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Invoice No', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Amount', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Paid Amount', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Due Amount', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Date', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Payment Status', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
						   
						</tr>
					</tfoot>
					<tbody>
					 <?php 
						 if($obj_gym->role == 'member')
						{
							if($user_access['own_data']=='1')
							{
								$paymentdata=$obj_payment->get_all_income_data_by_member();		
							}
							else
							{
								$paymentdata=$obj_payment->get_all_income_data();
							}							
						}
						else
						{
							if($user_access['own_data']=='1')
							{
								$user_id=get_current_user_id();
								$paymentdata=$obj_payment->get_all_income_data_by_created_by($user_id);		
							}
							else
							{
								$paymentdata=$obj_payment->get_all_income_data();
							}							
						}	
						foreach ($paymentdata as $retrieved_data)
						{ 
							if(empty($retrieved_data->invoice_no))
							{
								$invoice_no='-';
								if($retrieved_data->invoice_label=='Sell Product')
								{	
									$entry=json_decode($retrieved_data->entry);
								
									if(!empty($entry))
									{
										foreach($entry as $data)
										{
											 $amount=$data->amount;
										}
									}							
									
									$total_amount=$amount;
									$paid_amount=$amount;
									
									$due_amount='0';
									
								}
								else
								{
									$entry=json_decode($retrieved_data->entry);
									$amount_value='0';
									if(!empty($entry))
									{
										foreach($entry as $data)
										{
											 $amount_value+=$data->amount;											 
										}
									}								
									
									if($retrieved_data->payment_status=='Paid')
									{
										$total_amount=$amount_value;
										$paid_amount=$amount_value;
										$due_amount='0';
									}
									else
									{
										$total_amount=$amount_value;
										$paid_amount='0';
										$due_amount=$amount_value;
									}
								}	
							}
							else
							{								
								$invoice_no=$retrieved_data->invoice_no;
								$total_amount=$retrieved_data->total_amount;
								$paid_amount=$retrieved_data->paid_amount;
								$due_amount=$total_amount-$paid_amount;
							}	
						?>
						<tr>
							<td class="member_name"><?php $user=get_userdata($retrieved_data->supplier_name);
								$memberid=get_user_meta($retrieved_data->supplier_name,'member_id',true);
								$display_label=$user->display_name;
								if($memberid)
									$display_label.=" (".$memberid.")";
								echo $display_label;?></td>
							<td class="income_amount"><?php echo $retrieved_data->invoice_label;?></td>
							<td class="income_amount">
							<?php
							echo $invoice_no;	
							?>
							</td>
							<td class="income_amount"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo round($total_amount);?></td>
							<td class="income_amount"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo round($paid_amount);?></td>
							<td class="income_amount"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo round(abs($due_amount));?></td>
							<td class="status"><?php echo getdate_in_input_box($retrieved_data->invoice_date);?></td>
							<td class="paymentdate">
							<?php 
							echo "<span class='btn btn-success btn-xs'>";
							//echo get_membership_paymentstatus($retrieved_data->mp_id);
							echo  __("$retrieved_data->payment_status","gym_mgt");
							echo "</span>";
							?>
							</td>
							<?php 
							if($obj_gym->role == 'member')
							{ 
								if ($retrieved_data->payment_status == 'Unpaid' || $retrieved_data->payment_status == 'Partially Paid' || $retrieved_data->payment_status == 'Part Paid' || $retrieved_data->payment_status == 'Not Paid')
								{  ?>
									 <td class="action">								
									<a href="#" class="show-payment-popup btn btn-default" idtest="<?php echo $retrieved_data->invoice_id; ?>" member_id="<?php echo $retrieved_data->supplier_name; ?>"  view_type="income" due_amount="<?php echo round($due_amount); ?>"
									view_type="income_payment" ><?php _e('Pay','gym_mgt');?></a>
									<a  href="#" class="show-invoice-popup btn btn-default" <?php if($retrieved_data->invoice_label=='Sell Product'){ ?> idtest="<?php $id=$obj_payment->gmgt_get_sell_id_by_income_id($retrieved_data->invoice_id);  echo $id;?>"  invoice_type="sell_invoice" <?php }elseif($retrieved_data->invoice_label=='Fees Payment'){ ?> idtest="<?php $id=$obj_payment->gmgt_get_fees_id_by_income_id($retrieved_data->invoice_id);  echo $id;?>"  invoice_type="membership_invoice" <?php }else{?> idtest="<?php echo $retrieved_data->invoice_id; ?>" invoice_type="income" <?php } ?> >
									<i class="fa fa-eye"></i> <?php _e('View Invoice', 'gym_mgt');?></a>
									<?php
									if($user_access['edit']=='1')
									{
										if(!empty($retrieved_data->invoice_no))
										{
											if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))
											{
											?>	
											<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
										<?php
											}
										}
									}
									if($user_access['delete']=='1')
									{									
										?>
										<a href="?dashboard=user&page=payment&tab=incomelist&action=delete&income_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-danger" 
										onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
										<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
									<?php
									}
									?>									
									</td>
									  <?php 
								}
								if ($retrieved_data->payment_status == 'Fully Paid' || $retrieved_data->payment_status == 'Paid') 
								{ 
								?>					  
									<td class="action">
										<a  href="#" class="show-invoice-popup btn btn-default" <?php if($retrieved_data->invoice_label=='Sell Product'){ ?> idtest="<?php $id=$obj_payment->gmgt_get_sell_id_by_income_id($retrieved_data->invoice_id);  echo $id;?>"  invoice_type="sell_invoice" <?php }elseif($retrieved_data->invoice_label=='Fees Payment'){ ?> idtest="<?php $id=$obj_payment->gmgt_get_fees_id_by_income_id($retrieved_data->invoice_id);  echo $id;?>"  invoice_type="membership_invoice" <?php }else{?> idtest="<?php echo $retrieved_data->invoice_id; ?>" invoice_type="income" <?php } ?> >
											<i class="fa fa-eye"></i> <?php _e('View Invoice', 'gym_mgt');?></a>
										<?php
									if($user_access['edit']=='1')
									{	
										if(!empty($retrieved_data->invoice_no))
										{
											if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))
											{
										?>	
											<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
										<?php
											}
										}
									}
									if($user_access['delete']=='1')
									{	
										?>
										<a href="?dashboard=user&page=payment&tab=incomelist&action=delete&income_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-danger" 
										onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
										<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>	
									<?php	
									}
									?>											
									</td>
								   <?php 
								} 
							} 
							if($obj_gym->role == 'accountant')				
							{ 
								if ($retrieved_data->payment_status == 'Unpaid' || $retrieved_data->payment_status == 'Partially Paid' || $retrieved_data->payment_status == 'Part Paid' || $retrieved_data->payment_status == 'Not Paid')
								{  ?>									
									<td class="action">
									
										<a href="#" class="show-payment-popup btn btn-default" idtest="<?php echo $retrieved_data->invoice_id; ?>" member_id="<?php echo $retrieved_data->supplier_name; ?>"  view_type="income" due_amount="<?php echo round($due_amount); ?>"
										view_type="income_payment" ><?php _e('Pay','gym_mgt');?></a>
										<a  href="#" class="show-invoice-popup btn btn-default" <?php if($retrieved_data->invoice_label=='Sell Product'){ ?> idtest="<?php $id=$obj_payment->gmgt_get_sell_id_by_income_id($retrieved_data->invoice_id);  echo $id;?>"  invoice_type="sell_invoice" <?php }elseif($retrieved_data->invoice_label=='Fees Payment'){ ?> idtest="<?php $id=$obj_payment->gmgt_get_fees_id_by_income_id($retrieved_data->invoice_id);  echo $id;?>"  invoice_type="membership_invoice" <?php }else{?> idtest="<?php echo $retrieved_data->invoice_id; ?>" invoice_type="income" <?php } ?> >
										<i class="fa fa-eye"></i> <?php _e('View Invoice', 'gym_mgt');?></a>
										<?php
										if($user_access['edit']=='1')
										{
											if(!empty($retrieved_data->invoice_no))
											{
												if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))
												{
											?>	
												<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
											<?php
												}
											}
										}
										if($user_access['delete']=='1')
										{								
										?>
										<a href="?dashboard=user&page=payment&tab=incomelist&action=delete&income_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-danger" 
										onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
										<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
										<?php
										}
										?>
									</td>
									  <?php 
								}
								else
								{	
								?>
									<td class="action">
										<a  href="#" class="show-invoice-popup btn btn-default" <?php if($retrieved_data->invoice_label=='Sell Product'){ ?> idtest="<?php $id=$obj_payment->gmgt_get_sell_id_by_income_id($retrieved_data->invoice_id);  echo $id;?>"  invoice_type="sell_invoice" <?php }elseif($retrieved_data->invoice_label=='Fees Payment'){ ?> idtest="<?php $id=$obj_payment->gmgt_get_fees_id_by_income_id($retrieved_data->invoice_id);  echo $id;?>"  invoice_type="membership_invoice" <?php }else{?> idtest="<?php echo $retrieved_data->invoice_id; ?>" invoice_type="income" <?php } ?> >
										<i class="fa fa-eye"></i> <?php _e('View Income', 'gym_mgt');?></a>
										<?php
										if($user_access['edit']=='1')
										{
											if(!empty($retrieved_data->invoice_no))
											{
												if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))
												{
												?>	
													<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
												<?php
												}
											}
										}
										if($user_access['delete']=='1')
										{	
										?>
											<a href="?dashboard=user&page=payment&tab=incomelist&action=delete&income_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-danger" 
											onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
											<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
										<?php
										}
										?>
									</td>
								  <?php 
								}  
							} 
							if($obj_gym->role == 'staff_member')				
							{
							?>
								<td class="action">
									<a  href="#" class="show-invoice-popup btn btn-default" <?php if($retrieved_data->invoice_label=='Sell Product'){ ?> idtest="<?php $id=$obj_payment->gmgt_get_sell_id_by_income_id($retrieved_data->invoice_id);  echo $id;?>"  invoice_type="sell_invoice" <?php }elseif($retrieved_data->invoice_label=='Fees Payment'){ ?> idtest="<?php $id=$obj_payment->gmgt_get_fees_id_by_income_id($retrieved_data->invoice_id);  echo $id;?>"  invoice_type="membership_invoice" <?php }else{?> idtest="<?php echo $retrieved_data->invoice_id; ?>" invoice_type="income" <?php } ?> >
									<i class="fa fa-eye"></i> <?php _e('View Income', 'gym_mgt');?></a>
									<?php
									if($user_access['edit']=='1')
									{
										if(!empty($retrieved_data->invoice_no))
										{
											if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))
											{
											?>	
												<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
											<?php
											}
										}
									}
									if($user_access['delete']=='1')
									{	
									?>
										<a href="?dashboard=user&page=payment&tab=incomelist&action=delete&income_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-danger" 
										onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
										<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
									<?php
									}
									?>
								</td>
							<?php	
							}
							?>
						</tr>
						<?php 
						}		
					?>     
					</tbody>
				</table>
            </div>
    </div>
	<?php
	} 
	if($active_tab == 'addincome')
	{?>
	<!--Add Income information-->
	<script type="text/javascript">
	$(document).ready(function() {
		$('#income_form').validationEngine();
		  var date = new Date();
			date.setDate(date.getDate()-0);
			$.fn.datepicker.defaults.format =" <?php  echo get_option('gmgt_datepicker_format'); ?>";
			 $('#invoice_date').datepicker({
			 <?php
			if(get_option('gym_enable_datepicker_privious_date')=='no')
			{
			?>
				startDate: date,
			<?php
			}
			?>	
			 autoclose: true
		   }); 	
			
	} );
	</script>
    <?php 
	$income_id=0;
			if(isset($_REQUEST['income_id']))
				$income_id=$_REQUEST['income_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					$edit=1;
					$result = $obj_payment->gmgt_get_income_data($income_id);
				}?>
        <div class="panel-body">
			<form name="income_form" action="" method="post" class="form-horizontal" id="income_form">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="income_id" value="<?php echo $income_id;?>">
			<input type="hidden" name="invoice_type" value="income">
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="day"><?php _e('Member','gym_mgt');?></label>	
				<div class="col-sm-8">
					<?php if($edit){ $member_id=$result->supplier_name; }elseif(isset($_POST['member_id'])){$member_id=$_POST['member_id'];}else{$member_id='';}?>
					<select id="member_list" class="display-members" required="true" name="supplier_name">
					<option value=""><?php _e('Select Member','gym_mgt');?></option>
						<?php $get_members = array('role' => 'member');
						$membersdata=get_users($get_members);
						 if(!empty($membersdata))
						 {
							foreach ($membersdata as $member){?>
								<option value="<?php echo $member->ID;?>" <?php selected($member_id,$member->ID);?>><?php echo $member->display_name." - ".$member->member_id; ?> </option>
							<?php }
						 }?>
				</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="invoice_label"><?php _e('Income label','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="invoice_label" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $result->invoice_label;}elseif(isset($_POST['invoice_label'])) echo $_POST['payment_title'];?>" name="invoice_label">
				</div>
			</div>
			
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="payment_status"><?php _e('Status','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<select name="payment_status" id="payment_status" class="form-control validate[required]">
						<option value="<?php echo __('Paid','gym_mgt');?>"
							<?php if($edit)selected('Paid',$result->payment_status);?> ><?php _e('Paid','gym_mgt');?></option>
						<option value="<?php echo __('Part Paid','gym_mgt');?>"
							<?php if($edit)selected('Part Paid',$result->payment_status);?>><?php _e('Part Paid','gym_mgt');?></option>
							<option value="<?php echo __('Unpaid','gym_mgt');?>"
							<?php if($edit)selected('Unpaid',$result->payment_status);?>><?php _e('Unpaid','gym_mgt');?></option>
				</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="invoice_date"><?php _e('Date','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="invoice_date" class="form-control " data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" type="text"  value="<?php if($edit)
					{ echo getdate_in_input_box($result->invoice_date);}
				elseif(isset($_POST['invoice_date'])){ echo $_POST['invoice_date'];}
				else{ echo getdate_in_input_box(date("Y-m-d"));}?>" name="invoice_date">
				</div>
			</div>
			<hr>
			
			<?php 
			
				if($edit){
					$all_income_entry=json_decode($result->entry);
				
				}
				else
				{
					if(isset($_POST['income_entry']))
					{					
						$all_data=$obj_invoice->get_entry_records($_POST);
						$all_income_entry=json_decode($all_data);
					}	
				}
				
				
				if(!empty($all_income_entry))
				{
						foreach($all_income_entry as $entry){
						?>
						<div id="income_entry_div">
							<script type="text/javascript">
							$('.onlyletter_space_validation1').keypress(function( e ) 
							{     
								var regex = new RegExp("^[a-zA-Z \b]+$");
								var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
								if (!regex.test(key)) 
								{
								  event.preventDefault();
								  alert("Enter Later and Space Only");
								  return false;
								} 
							   return true;
							});
							</script>
							<div class="form-group">
							<label class="col-sm-2 control-label" for="income_entry"><?php _e('Income Entry','gym_mgt');?><span class="require-field">* </span> </label>
							<div class="col-sm-2">
								<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==6) return false;" value="<?php echo $entry->amount;?>" name="income_amount[]">
							</div>
							<div class="col-sm-4">
								<input id="income_entry" class="form-control validate[required,custom[onlyLetterSp]] text-input onlyletter_space_validation1" maxlength="50" type="text" value="<?php echo $entry->entry;?>" name="income_entry[]">
							</div>
							
							<div class="col-sm-2">
							<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','gym_mgt');?></i>
							</button>
							</div>
							</div>	
						</div>
						<?php }
					
				}
				else
				{?>
						<div id="income_entry_div">
							<script type="text/javascript">
							$('.onlyletter_space_validation1').keypress(function( e ) 
							{     
								var regex = new RegExp("^[a-zA-Z \b]+$");
								var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
								if (!regex.test(key)) 
								{
								  event.preventDefault();
								  alert("Enter Later and Space Only");
								  return false;
								} 
							   return true;
							});
							</script>
							<div class="form-group">
							<label class="col-sm-2 control-label" for="income_entry"><?php _e('Income Entry','gym_mgt');?><span class="require-field">* </span> </label>
							<div class="col-sm-2">
								<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==6) return false;" value="" name="income_amount[]" placeholder="Income Amount">
							</div>
							<div class="col-sm-4">
								<input id="income_entry" class="form-control validate[required,custom[onlyLetterSp]] text-input onlyletter_space_validation1" type="text" maxlength="50" value="" name="income_entry[]" placeholder="Income Entry Label">
							</div>						
							<div class="col-sm-2">
							<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','gym_mgt');?></i>
							</button>
							</div>
							</div>	
						</div>
						
			<?php } ?>	
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="income_entry"></label>
				<div class="col-sm-3">					
					<button id="add_new_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_entry" onclick="add_entry()"><?php _e('Add Income Entry','gym_mgt'); ?>
					</button>
				</div>
			</div>
			<div class="form-group">
					<label class="col-sm-2 control-label" for="tax"><?php _e('Tax','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="group_name" class="form-control text-input Tax decimal_number" maxlength="4" type="text" value="<?php if($edit){ echo $result->tax;}elseif(isset($_POST['tax'])) echo $_POST['tax'];?>" name="tax">
					</div>
				<div class="col-sm-1">
						<span style="font-size: 18px;"><?php echo "%";?></span>
				</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="quentity"><?php _e('Discount Amount ','gym_mgt');?><span class="require-field"></span></label>
					<div class="col-sm-8">
						<input id="group_name" class="form-control text-input decimal_number"  type="number" onKeyPress="if(this.value.length==6) return false;" min="0" value="<?php if($edit){ echo $result->discount;}elseif(isset($_POST['discount'])) echo $_POST['discount'];?>" name="discount">
					</div>
				 <div class="col-sm-1">
						<span style="font-size: 18px;"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span>
				</div>
				
				</div>
				<hr>	
			<div class="col-sm-offset-2 col-sm-8">
				<input type="submit" value="<?php if($edit){ _e('Save Income','gym_mgt'); }else{ _e('Add Income','gym_mgt');}?>" name="save_income" class="btn btn-success"/>
			</div>
			</form>
        </div>
       <script>
		// CREATING BLANK INVOICE ENTRY
		var blank_income_entry ='';
		$(document).ready(function() { 
			blank_income_entry = $('#income_entry_div').html();
			//alert("hello" + blank_invoice_entry);
		}); 

		function add_entry()
		{
			$("#income_entry_div").append(blank_income_entry);
			//alert("hellooo");
		}
		
		// REMOVING INVOICE ENTRY
		function deleteParentElement(n){
			 alert(' Do you really want to delete this record');
			n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
		}
       </script> 
	<?php 
	}
	if($active_tab == 'expenselist')
	{ ?>
	<script type="text/javascript">
	$(document).ready(function() {
		jQuery('#tblexpence').DataTable({
			"responsive": true,
			 "order": [[ 2, "Desc" ]],
			 "aoColumns":[
						  {"bSortable": true},
						  {"bSortable": true},
						  {"bSortable": true},
						
						{"bSortable": false} 
					   ]
			});
			
	} );
	</script>
    <div class="panel-body">
        	<div class="table-responsive">
				<table id="tblexpence" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th> <?php _e( 'Supplier Name', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Amount', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Date', 'gym_mgt' ) ;?></th>
							
							<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
							   
						</tr>
				    </thead>
					<tfoot>
						<tr>
							<th> <?php _e( 'Supplier Name', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Amount', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Date', 'gym_mgt' ) ;?></th>
							 
						    <th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
							  
						</tr>
					</tfoot>
		 
					<tbody>
					 <?php 
					 if($user_access['own_data']=='1')
					{
						$user_id=get_current_user_id();
						$expensedata=$obj_payment->get_all_expense_data_by_created_by($user_id);		
					}
					else
					{
						$expensedata=$obj_payment->get_all_expense_data();
					}	
					
						foreach ($expensedata as $retrieved_data)
						{ 
							$all_entry=json_decode($retrieved_data->entry);
							$total_amount=0;
							foreach($all_entry as $entry){
								$total_amount+=$entry->amount;
							} ?>
						<tr>
							<td class="party_name"><?php echo $retrieved_data->supplier_name;?></td>
							<td class="income_amount"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo $total_amount;?></td>
							<td class="status"><?php echo getdate_in_input_box($retrieved_data->invoice_date);?></td>
						
							<td class="action">
							<a  href="#" class="show-invoice-popup btn btn-default" idtest="<?php echo $retrieved_data->invoice_id; ?>" invoice_type="expense">
							<i class="fa fa-eye"></i> <?php _e('View Expense', 'gym_mgt');?></a>
							<?php
							if($user_access['edit']=='1')
							{
							?>
								<a href="?dashboard=user&page=payment&tab=addexpense&action=edit&expense_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
							<?php
							}
							if($user_access['delete']=='1')
							{
							?>		
								<a href="?dashboard=user&page=payment&tab=expenselist&action=delete&expense_id=<?php echo 	$retrieved_data->invoice_id;?>" class="btn btn-danger" 
								onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
								<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
							<?php
							}
							?>		
							</td>						 
						</tr>
						<?php }  ?>
					</tbody>
				</table>
            </div>
    </div>	
	<?php 
	} 
	if($active_tab == 'addexpense')
	{ ?>	
    <?php 
	//This is Dashboard at admin side
	$obj_payment= new MJ_Gmgtpayment();?>
	<script type="text/javascript">   
	$(document).ready(function() {
		$('#expense_form').validationEngine();
		var date = new Date();
				date.setDate(date.getDate()-0);
				$.fn.datepicker.defaults.format =" <?php  echo get_option('gmgt_datepicker_format'); ?>";
				 $('#invoice_date').datepicker({
				 startDate: date,
				 autoclose: true
			   }); 
			
	} );
    </script>
    <?php 	

        	$expense_id=0;
			if(isset($_REQUEST['expense_id']))
				$expense_id=$_REQUEST['expense_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					$edit=1;
					$result = $obj_payment->gmgt_get_income_data($expense_id);
					//var_dump($result);
				}?>
    <div class="panel-body">
        <form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">
        <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="expense_id" value="<?php echo $expense_id;?>">
		<input type="hidden" name="invoice_type" value="expense">
		
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="patient"><?php _e('Supplier Name','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="supplier_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $result->supplier_name;}elseif(isset($_POST['supplier_name'])) echo $_POST['supplier_name'];?>" name="supplier_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="payment_status"><?php _e('Status','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select name="payment_status" id="payment_status" class="form-control validate[required]">
					<option value="<?php echo __('Paid','gym_mgt');?>"
						<?php if($edit)selected('Paid',$result->payment_status);?> ><?php _e('Paid','gym_mgt');?></option>
					<option value="<?php echo __('Part Paid','gym_mgt');?>"
						<?php if($edit)selected('Part Paid',$result->payment_status);?>><?php _e('Part Paid','gym_mgt');?></option>
						<option value="<?php echo __('Unpaid','gym_mgt');?>"
						<?php if($edit)selected('Unpaid',$result->payment_status);?>><?php _e('Unpaid','gym_mgt');?></option>
			</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="invoice_date"><?php _e('Date','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="invoice_date" class="form-control validate[required]" type="text"  
				value="<?php if($edit){ echo getdate_in_input_box($result->invoice_date);}
				elseif(isset($_POST['invoice_date'])){ echo $_POST['invoice_date'];}
				else{ echo getdate_in_input_box(date("Y-m-d"));}?>" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" name="invoice_date">
			</div>
		</div>
		<hr>
		
		<?php 
			
			if($edit){
				$all_expense_entry=json_decode($result->entry);
			}
			else
			{
				if(isset($_POST['income_entry'])){
					
					$all_data=$obj_payment->get_entry_records($_POST);
					$all_expense_entry=json_decode($all_data);
				}
				
					
			}
			if(!empty($all_expense_entry))
			{
					foreach($all_expense_entry as $entry){
					?>
					<div id="expense_entry">
						<script type="text/javascript">
						$('.onlyletter_space_validation1').keypress(function( e ) 
						{     
							var regex = new RegExp("^[a-zA-Z \b]+$");
							var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
							if (!regex.test(key)) 
							{
							  event.preventDefault();
							  alert("Enter Later and Space Only");
							  return false;
							} 
						   return true;
						});
						</script>
						<div class="form-group">
						<label class="col-sm-2 control-label" for="income_entry"><?php _e('Expense Entry','gym_mgt');?><span class="require-field"> *</span> </label>
						<div class="col-sm-2">
							<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==6) return false;" value="<?php echo $entry->amount;?>" name="income_amount[]" >
						</div>
						<div class="col-sm-4">
							<input id="income_entry" class="form-control validate[required,custom[onlyLetterSp]] text-input onlyletter_space_validation1" maxlength="50" type="text" value="<?php echo $entry->entry;?>" name="income_entry[]">
						</div>
						
						<div class="col-sm-2">
						<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
						<i class="entypo-trash"><?php _e('Delete','gym_mgt');?></i>
						</button>
						</div>
						</div>	
					</div>
					<?php }
				
			}
			else
			{?>
					<div id="expense_entry">
						<script type="text/javascript">
						$('.onlyletter_space_validation1').keypress(function( e ) 
						{     
							var regex = new RegExp("^[a-zA-Z \b]+$");
							var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
							if (!regex.test(key)) 
							{
							  event.preventDefault();
							  alert("Enter Later and Space Only");
							  return false;
							} 
						   return true;
						});
						</script>
						<div class="form-group">
						<label class="col-sm-2 control-label" for="income_entry"><?php _e('Expense Entry','gym_mgt');?><span class="require-field">* </span> </label>
						<div class="col-sm-2">
							<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==6) return false;" value="" name="income_amount[]" placeholder="Expense Amount">
						</div>
						<div class="col-sm-4">
							<input id="income_entry" class="form-control validate[required,custom[onlyLetterSp]] text-input onlyletter_space_validation1" type="text" maxlength="50" value="" name="income_entry[]" placeholder="Expense Entry Label">
						</div>
						
						<div class="col-sm-2">
						<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
						<i class="entypo-trash"><?php _e('Delete','gym_mgt');?></i>
						</button>
						</div>
						</div>	
					</div>
					
		<?php }?>	
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="expense_entry"></label>
			<div class="col-sm-3">
				
				<button id="add_new_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_entry" onclick="add_entry()"><?php _e('Add Expense Entry','gym_mgt'); ?>
				</button>
			</div>
		</div>
		<hr>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save Expense','gym_mgt'); }else{ _e('Add Expense','gym_mgt');}?>" name="save_expense" class="btn btn-success"/>
        </div>
        </form>
    </div>
    <script>
		// CREATING BLANK INVOICE ENTRY
		var blank_income_entry ='';
		$(document).ready(function() { 
			blank_expense_entry = $('#expense_entry').html();
			//alert("hello" + blank_invoice_entry);
		}); 

		function add_entry()
		{
			$("#expense_entry").append(blank_expense_entry);
			//alert("hellooo");
		}
		
		// REMOVING INVOICE ENTRY
		function deleteParentElement(n){
			 alert(' Do you really want to delete this record');
			n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
		}
    </script> 

<?php
 }?>
</div>
</div>
<?php ?>