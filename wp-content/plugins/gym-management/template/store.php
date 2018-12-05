<?php 
$curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_product=new MJ_Gmgtproduct;
$obj_store=new MJ_Gmgtstore;
$obj_class=new MJ_Gmgtclassschedule;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'store';
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
	    
		$saledata['member_id']=get_current_user_id();
		$custom_array = explode("_",$_POST['custom']);
		$saledata['sell_id']=$custom_array[1];
		$saledata['amount']=$_POST['mc_gross_1'];
		$saledata['payment_method']='paypal';
	    $saledata['trasaction_id']=$_POST["txn_id"];
		$saledata['paid_by_date']=date("Y-m-d");
		$saledata['created_by']=get_current_user_id();
		$result = $obj_store->add_sellpayment_history($saledata);
		
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=store&action=success');
		}
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
			$result=$obj_store->gmgt_sell_payment($_POST);
	
			if($result)
			{
				wp_redirect ( home_url().'?dashboard=user&page=store&tab=store&action=success');
			}	
		}	
	}

	if(isset($_POST['save_selling']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
				
			$result=$obj_store->gmgt_sell_product($_POST);
			if($result)
			{
				wp_redirect ( home_url().'?dashboard=user&page=store&tab=store&message=2');
			}
			
		}
		else
		{			
			$result=$obj_store->gmgt_sell_product($_POST);
				
			if($result)
			{	
				wp_redirect ( home_url().'?dashboard=user&page=store&tab=store&message=1');
			}			
		}
	}
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			
			$result=$obj_store->delete_selling($_REQUEST['sell_id']);
			if($result)
			{
				wp_redirect ( home_url().'?dashboard=user&page=store&tab=store&message=3');
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
		elseif($message == 4) 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php 
			_e('Out of Stock product','gym_mgt');
		?></div></p><?php
				
		}
		elseif($message == 5) 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php 
			_e('Payment successfully','gym_mgt');
		?></div></p><?php
				
		}
	}
	?>
	
<script type="text/javascript">
$(document).ready(function()
{
	var date = new Date();
            date.setDate(date.getDate()-0);
	        $.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format'); ?>";
            $('#sell_date').datepicker({
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
	jQuery('#selling_list').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
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
		$('#store_form').validationEngine();
		$(".display-members").select2();
	
} );
</script>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
		    <div class="invoice_data"></div>
        </div>
    </div> 
</div>
<!-- End POP-UP Code -->
<div class="panel-body panel-white">
	<ul class="nav nav-tabs panel_tabs" role="tablist">		   
			<li class="<?php if($active_tab=='store'){?>active<?php }?>">
				<a href="?dashboard=user&page=store&tab=store" class="nav-tab <?php echo $active_tab == 'store' ? 'nav-tab-active' : ''; ?>">
			 <i class="fa fa-align-justify"></i> <?php _e('Sells Record', 'gym_mgt'); ?></a>
		  </li>
		   <li class="<?php if($active_tab=='sellproduct'){?>active<?php }?>">
			  <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['sell_id']))
				{?>
				<a href="?dashboard=user&page=store&tab=sellproduct&action=edit&sell_id=<?php echo $_REQUEST['sell_id'];?>" class="nav-tab <?php echo $active_tab == 'sellproduct' ? 'nav-tab-active' : ''; ?>">
				 <i class="fa fa"></i> <?php _e('Edit Sell Product', 'gym_mgt'); ?></a>
				 <?php }
				else
				{
					if($user_access['add']=='1')
					{
					?>
						<a href="?dashboard=user&page=store&tab=sellproduct&&action=insert" class="nav-tab <?php 	echo $active_tab == 'sellproduct' ? 'nav-tab-active' : ''; ?>">
						<i class="fa fa-plus-circle"></i> <?php _e('Add Sell Product', 'gym_mgt'); ?></a>
					<?php 
					}
				}
				?>
		    </li>		 
	</ul>
	<div class="tab-content">
	<?php
	if($active_tab == 'store')
	{ ?>	
        <div class="panel-body">
            <div class="table-responsive">
                <table id="selling_list" class="display" cellspacing="0" width="100%">
					<thead>
					   <tr>
							<th><?php  _e( 'Invoice No', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Member Name', 'gym_mgt' ) ;?></th>		
							<th><?php  _e( 'Product Name=>Product Quantity', 'gym_mgt' ) ;?></th>					
							<th><?php  _e( 'Total Amount', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Paid Amount', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Due Amount', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Payment Status', 'gym_mgt' ) ;?></th>
						
							 <th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
							
						</tr>
				    </thead>
					<tfoot>
						<tr>
						<th><?php  _e( 'Invoice No', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Member Name', 'gym_mgt' ) ;?></th>		
						<th><?php  _e( 'Product Name=>Product Quantity', 'gym_mgt' ) ;?></th>					
						<th><?php  _e( 'Total Amount', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Paid Amount', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Due Amount', 'gym_mgt' ) ;?></th>
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
								$user_id=get_current_user_id();
								$storedata=$obj_store->get_all_selling_by_member($user_id);		
							}
							else
							{
								$storedata=$obj_store->get_all_selling();
							}	
						}
						else
						{	
							if($user_access['own_data']=='1')
							{
								$user_id=get_current_user_id();							
								$storedata=$obj_store->get_all_selling_by_sell_by($user_id);
							}
							else
							{
								$storedata=$obj_store->get_all_selling();
							}	
						}
						
						if(!empty($storedata))
						{
						foreach ($storedata as $retrieved_data)
						{
							$obj_product=new MJ_Gmgtproduct;
							$product = $obj_product->get_single_product($retrieved_data->product_id); 				
							
							$price=$product->price;	
							$quentity=$retrieved_data->quentity;	
							
							if(empty($retrieved_data->invoice_no))
							{
								$invoice_no='-';					
								$total_amount=$price*$quentity;
								$paid_amount=$price*$quentity;
								
								$due_amount='0';
							}
							else
							{
								$invoice_no=$retrieved_data->invoice_no;
								$total_amount=$retrieved_data->total_amount;
								$paid_amount=$retrieved_data->paid_amount;
								$due_amount=$total_amount-$paid_amount;
							}		
						?>
							<tr><td class="productquentity">
							<?php echo $invoice_no; ?>
							</td>	
								<td class="membername"><?php $userdata=get_userdata($retrieved_data->member_id);
								echo $userdata->display_name;?></td>				
								<td class="productname">
								<?php 
								$entry_valuea=json_decode($retrieved_data->entry);
								if(!empty($entry_valuea))
								{
									foreach($entry_valuea as $entry_valueb)
									{
										$product = $obj_product->get_single_product($entry_valueb->entry);
														
										$product_name=$product->product_name;					
										$quentity=$entry_valueb->quentity;	
										
										echo  $product_name . " => " . $quentity . ",<br>";
									}
								}
								else
								{
									$obj_product=new MJ_Gmgtproduct;
									$product = $obj_product->get_single_product($retrieved_data->product_id); 
									
									$product_name=$product->product_name;					
									$quentity=$retrieved_data->quentity;	
									echo  $product_name . " => " . $quentity;
								}									
								?>
								</td>
								<td class="productquentity"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo round($total_amount);?></td>
								<td class="productquentity"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo round($paid_amount);?></td>
								<td class="totalamount"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); 
								echo round($due_amount);?></td>
								<td class="paymentdate">
								<?php 
								if(!empty($retrieved_data->payment_status))
								{
									echo "<span class='btn btn-success btn-xs'>";									
									echo  __("$retrieved_data->payment_status","gym_mgt");
									echo "</span>";
								}								
								else
								{
									echo "<span class='btn btn-success btn-xs'>";				
									echo  __("Fully Paid","gym_mgt");
									echo "</span>";
								}	
								?>
								</td>
								<?php 
								if($obj_gym->role == 'member')
								{
									if ($retrieved_data->payment_status == 'Unpaid' || $retrieved_data->payment_status == 'Partially Paid')
									{ $due_amount=$retrieved_data->total_amount-$retrieved_data->paid_amount;?>
									<td class="action">
								   <a href="#" class="show-payment-popup btn btn-default" idtest="<?php echo $retrieved_data->id; ?>" member_id="<?php echo $retrieved_data->member_id; ?>" due_amount="<?php echo round($due_amount); ?>"  view_type="sale_payment" ><?php _e('Pay','gym_mgt');?></a>				 
									<a  href="#" class="show-invoice-popup btn btn-default" idtest="<?php echo $retrieved_data->id; ?>" invoice_type="sell_invoice">
									<i class="fa fa-eye"></i> <?php _e('View Invoice', 'gym_mgt');?></a>
									<?php
									if(!empty($retrieved_data->invoice_no))
									{									
										if($user_access['edit']=='1')
										{
										?>
								
										<a href="?dashboard=user&page=store&tab=sellproduct&action=edit&sell_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
									<?php
										}
									}
									if($user_access['delete']=='1')
									{
									?>
										<a href="?dashboard=user&page=store&tab=store&action=delete&sell_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
										onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
										<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
									<?php
									}
									?>
									</td>
									<?php 
									} elseif($retrieved_data->payment_status == 'Fully Paid' || $retrieved_data->payment_status == '' )
									{ ?>
										<td class="action">
										<a  href="#" class="show-invoice-popup btn btn-default" idtest="<?php echo $retrieved_data->id; ?>" invoice_type="sell_invoice">
										<i class="fa fa-eye"></i> <?php _e('View Invoice', 'gym_mgt');?></a>
										<?php
											if(!empty($retrieved_data->invoice_no))
											{
												if($user_access['edit']=='1')
												{
											?>
												<a href="?dashboard=user&page=store&tab=sellproduct&action=edit&sell_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
											<?php
												}
											}
											if($user_access['delete']=='1')
											{												
											?>
												<a href="?dashboard=user&page=store&tab=store&action=delete&sell_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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
									if ($retrieved_data->payment_status == 'Unpaid' || $retrieved_data->payment_status == 'Partially Paid')
									{ 
										$due_amount=$retrieved_data->total_amount-$retrieved_data->paid_amount;
										?>
										<td class="action">
											<a href="#" class="show-payment-popup btn btn-default" idtest="<?php echo $retrieved_data->id; ?>" member_id="<?php echo $retrieved_data->member_id; ?>" due_amount="<?php echo round($due_amount); ?>"  view_type="sale_payment" ><?php _e('Pay','gym_mgt');?></a>				 
											<a  href="#" class="show-invoice-popup btn btn-default" idtest="<?php echo $retrieved_data->id; ?>" invoice_type="sell_invoice">
											<i class="fa fa-eye"></i> <?php _e('View Invoice', 'gym_mgt');?></a>
											<?php
											if(!empty($retrieved_data->invoice_no))
											{
												if($user_access['edit']=='1')
												{
											?>
												<a href="?dashboard=user&page=store&tab=sellproduct&action=edit&sell_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
											<?php
												}
											}
											if($user_access['delete']=='1')
											{											
											?>
												<a href="?dashboard=user&page=store&tab=store&action=delete&sell_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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
											<a  href="#" class="show-invoice-popup btn btn-default" idtest="<?php echo $retrieved_data->id; ?>" invoice_type="sell_invoice">
											<i class="fa fa-eye"></i> <?php _e('View Invoice', 'gym_mgt');?></a>
											<?php
											if(!empty($retrieved_data->invoice_no))
											{
												if($user_access['edit']=='1')
												{
												?>
												<a href="?dashboard=user&page=store&tab=sellproduct&action=edit&sell_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
												<?php
												}
											}
											if($user_access['delete']=='1')
											{											
											?>
												<a href=	"?dashboard=user&page=store&tab=store&action=delete&sell_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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
											<a  href="#" class="show-invoice-popup btn btn-default" idtest="<?php echo $retrieved_data->id; ?>" invoice_type="sell_invoice">
											<i class="fa fa-eye"></i> <?php _e('View Invoice', 'gym_mgt');?></a>
											<?php
											if(!empty($retrieved_data->invoice_no))
											{
												if($user_access['edit']=='1')
												{
												?>
												<a href="?dashboard=user&page=store&tab=sellproduct&action=edit&sell_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
												<?php
												}
											}
											if($user_access['delete']=='1')
											{											
											?>
												<a href=	"?dashboard=user&page=store&tab=store&action=delete&sell_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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
						}?>
					</tbody>
			    </table>

 		    </div>
		</div>
	<?php 
	}
	if($active_tab == 'sellproduct')
	{
        	$sell_id=0;
			if(isset($_REQUEST['sell_id']))
				$sell_id=$_REQUEST['sell_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{					
					$edit=1;
					$result = $obj_store->get_single_selling($sell_id);					
				}
				?>
		
    <div class="panel-body">
        <form name="store_form" action="" method="post" class="form-horizontal" id="store_form">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="invoice_number" value="<?php echo $result->invoice_no; ?>">
			<input type="hidden" name="sell_id" value="<?php echo $sell_id;?>"  />
			<input type="hidden" name="paid_amount" value="<?php echo $result->paid_amount;?>"  />	
			
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="day"><?php _e('Member','gym_mgt');?><span class="require-field">*</span></label>	
				<div class="col-sm-8">
					<?php if($edit){ $member_id=$result->member_id; }elseif(isset($_POST['member_id'])){$member_id=$_POST['member_id'];}else{$member_id='';}?>
					<select id="member_list" class="display-members" required="true" name="member_id">
					
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
				<label class="col-sm-2 control-label" for="sell_date"><?php _e('Date','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="sell_date" class="form-control" type="text" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" name="sell_date" 
					value="<?php if($edit){ echo getdate_in_input_box($result->sell_date);}elseif(isset($_POST['sell_date'])){ echo $_POST['sell_date'];}else{ echo getdate_in_input_box(date("Y-m-d")); }?>">
				</div>
			</div>
			<hr>		
			<?php 
				if($edit)
				{
					$all_entry=json_decode($result->entry);
				}
				
				if(!empty($all_entry))
				{
						foreach($all_entry as $entry)
						{
						?>
						<!--old product data-->
						<div style="display:none">								
							<select id="product_id" class="form-control validate[required]"  name="old_product_id[]">
							<option value=""><?php _e('Select Product','gym_mgt');?></option>
								<?php 
								$productdata=$obj_product->get_all_product();
								if(!empty($productdata))
								{
									foreach ($productdata as $product)
									{	
									?>
										<option value="<?php echo $product->id;?>" <?php selected($entry->entry,$product->id);  ?>><?php echo $product->product_name; ?> </option>
									<?php 	
									} 
								} 
							?>
						</select>
					  </div>				  
					 <div style="display:none">
						 <input id="group_name" class="form-control validate[required] text-input decimal_number quantity" maxlength="6" placeholder="Product Quantity" type="text" 
						 value="<?php echo $entry->quentity;?>" name="old_quentity[]" >
					 </div>
						<!--end old product data-->	 
						<div id="expense_entry">
							<div class="form-group">
							<label class="col-sm-2 control-label" for="income_entry"><?php _e('Product Entry','gym_mgt');?><span class="require-field"> *</span></label>
							<div class="col-sm-4">								
									<select id="product_id" class="form-control validate[required] product_id<?php echo $i; ?>" row="<?php echo $i; ?>" name="product_id[]">
									<option value=""><?php _e('Select Product','gym_mgt');?></option>
										<?php 
										$productdata=$obj_product->get_all_product();
										if(!empty($productdata))
										{
											foreach ($productdata as $product)
											{	
											?>
												<option value="<?php echo $product->id;?>" <?php selected($entry->entry,$product->id);  ?>><?php echo $product->product_name; ?> </option>
											<?php 	
											} 
										} 
									?>
								</select>
							  </div>
							 <div class="col-sm-2">
								 <input id="group_name" class="form-control validate[required] text-input decimal_number quantity quantity<?php echo $i; ?>" row="<?php echo $i; ?>" onkeypress="if(this.value.length==4) return false;" placeholder="Product Quantity" type="number" min="1" 
								 value="<?php echo $entry->quentity;?>" name="quentity[]" >
							 </div>
							<div class="col-sm-2">
							<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','gym_mgt');?></i>
							</button>
							</div>
							</div>	
						</div>
						<?php
						}				
				}
				else
				{?>
						<div id="expense_entry">
							<div class="form-group">
							<label class="col-sm-2 control-label" for="income_entry"><?php _e('Product Entry','gym_mgt');?><span class="require-field"> *</span></label>
							<div class="col-sm-4">								
									<select id="product_id" class="form-control validate[required] product_id1" row="1" value="<?php echo $entry->product_id;?>" name="product_id[]">
									<option value=""><?php _e('Select Product','gym_mgt');?></option>
									<?php 
										$productdata=$obj_product->get_all_product();
										 if(!empty($productdata))
										 {
											foreach ($productdata as $product)
											{?>
											<option value="<?php echo $product->id;?>"><?php echo $product->product_name; ?> </option>
										<?php
											} 
										} 
									?>
								</select>
							  </div>
							 <div class="col-sm-2">
								 <input id="group_name" class="form-control validate[required] text-input decimal_number quantity quantity1" row="1" onkeypress="if(this.value.length==4) return false;" placeholder="Product Quantity" type="number" min="1" 
								 value="" name="quentity[]" >
							 </div>
							<div class="col-sm-2">
							<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','gym_mgt');?></i>
							</button>
							</div>
							</div>	
						</div>
						
			 <?php 
			    } ?>	
			<div class="form-group">
				<label class="col-sm-2 control-label" for="expense_entry"></label>
				<div class="col-sm-3">				
					<button id="add_new_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_entry" onclick="add_entry()"><?php _e('Add Product Entry','gym_mgt'); ?>
					</button>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="quentity"><?php _e('Discount Amount ','gym_mgt');?><span class="require-field"></span></label>
				<div class="col-sm-8">
					<input id="group_name" min="0" class="form-control text-input decimal_number discount_amount"  type="number" onKeyPress="if(this.value.length==4) return false;"  value="<?php if($edit){ echo $result->discount;}elseif(isset($_POST['discount'])) echo $_POST['discount'];?>"  placeholder="Discount must be Amount Like 100 <?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?>"  name="discount">
				</div>
			 <div class="col-sm-1">
					<span style="font-size: 18px;"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span>
			</div>
			
			</div>
			
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tax"><?php _e('Tax','gym_mgt');?><span class="require-field"></span></label>
				<div class="col-sm-8">
					<input id="group_name" class="form-control text-input Tax decimal_number" maxlength="4"  type="text" value="<?php if($edit){ echo $result->tax;}elseif(isset($_POST['tax'])) echo $_POST['tax'];?>" placeholder="Tax must be percentage Like 18%" name="tax">
				</div>
				<div class="col-sm-1">
					<span style="font-size: 18px;"><?php echo "%";?></span>
			</div>
				
			</div>
			<div class="col-sm-offset-2 col-sm-8">
				
				<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Sell Product','gym_mgt');}?>" name="save_selling" class="btn btn-success"/>
			</div>
        </form>
    </div>
     <?php 
	}
	?>

	</div>
</div>
<script>
	var value = 1;
   	function add_entry()
   	{
   		value++;
   		$("#expense_entry").append('<div id="expense_entry"><div class="form-group"><label class="col-sm-2 control-label" for="income_entry"><?php _e('Product Entry','gym_mgt');?><span class="require-field"> *</span></label><div class="col-sm-4"><select id="product_id" class="form-control validate[required] product_id'+value+'" row="'+value+'" value="<?php echo $entry->product_id;?>" name="product_id[]"><option value=""><?php _e('Select Product','gym_mgt');?></option><?php $productdata=$obj_product->get_all_product();if(!empty($productdata)){foreach ($productdata as $product){?><option value="<?php echo $product->id;?>"><?php echo $product->product_name; ?> </option>	<?php } } ?>  </select></div><div class="col-sm-2"><input id="group_name" class="form-control validate[required] text-input decimal_number quantity quantity'+value+'" row="'+value+'" onkeypress="if(this.value.length==4) return false;" placeholder="Product Quantity" type="number" value="" min="1" name="quentity[]" ></div><div class="col-sm-2"><button type="button" class="btn btn-default" onclick="deleteParentElement(this)"><i class="entypo-trash"><?php _e('Delete','gym_mgt');?></i></button></div></div></div>');
   	}
   	
   	// REMOVING INVOICE ENTRY
   	function deleteParentElement(n){
		 alert(' Do you really want to delete this record');
   		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
   	}
</script> 
<?php ?>