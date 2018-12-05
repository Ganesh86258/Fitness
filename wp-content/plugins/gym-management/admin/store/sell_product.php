<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#store_form').validationEngine();
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
		$(".display-members").select2();
		
	$('.product_id').multiselect({
	nonSelectedText :'Select Product',
	includeSelectAllOption: true
	 });
		
	//------ADD GROUP AJAX----------
	
	$('#product_form').on('submit', function(e) {
		e.preventDefault();
		
		var form = $(this).serialize();
		
		var valid = $("#product_form").validationEngine('validate');
		if (valid == true) {
			$('.modal').modal('hide');
		
		$.ajax({
			type:"POST",
			url: $(this).attr('action'),
			data:form,
			success: function(data){
				if(data!=""){ 
					$('#product_form').trigger("reset");
					$('#product_id').append(data);
					
				}
				
			},
			error: function(data){

			}
		})
		}
		
	});
		
} );
</script>
     <?php 	
	if($active_tab == 'sellproduct')
	 {
        	
        	$sell_id=0;
			if(isset($_REQUEST['sell_id']))
				$sell_id=$_REQUEST['sell_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					
					$edit=1;
					$result = $obj_store->get_single_selling($sell_id);
					
				}?>
		
       <div class="panel-body">
        <form name="store_form" action="" method="post" class="form-horizontal" id="store_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="invoice_number" value="<?php echo $result->invoice_no; ?>">
		<input type="hidden" name="sell_id" value="<?php echo $sell_id;?>"  />
		<input type="hidden" name="paid_amount" value="<?php echo $result->paid_amount;?>"  />
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Member"><?php _e('Member','gym_mgt');?><span class="require-field">*</span></label>	
			<div class="col-sm-8">
				<?php if($edit){ $member_id=$result->member_id; }elseif(isset($_POST['member_id'])){$member_id=$_POST['member_id'];}else{$member_id='';}?>
				<select id="member_list" class="display-members" required="true" name="member_id">
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
					$i=0;
					foreach($all_entry as $entry)
					{
						$i--;
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
					 <input id="group_name" class="form-control validate[required] text-input decimal_number quantity" maxlength="6" placeholder="<?php _e('Product Quantity','gym_mgt'); ?>" type="text" 
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
				             <input id="group_name" class="form-control validate[required] text-input decimal_number quantity quantity<?php echo $i; ?>" row="<?php echo $i; ?>" onkeypress="if(this.value.length==4) return false;" placeholder="<?php _e('Product Quantity','gym_mgt'); ?>" type="number" min="1"
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
				             <input id="group_name" class="form-control validate[required] text-input decimal_number quantity quantity1" row="1" onkeypress="if(this.value.length==4) return false;" placeholder="<?php _e('Product Quantity','gym_mgt'); ?>" min="1" type="number" 
							 value="" name="quentity[]" >
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
				<button id="add_new_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_entry" onclick="add_entry()"><?php _e('Add Product Entry','gym_mgt'); ?>
				</button>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="quentity"><?php _e('Discount Amount ','gym_mgt');?><span class="require-field"></span></label>
			<div class="col-sm-8">
				<input id="group_name" class="form-control text-input decimal_number discount_amount"  type="number" min="0" onKeyPress="if(this.value.length==4) return false;"  value="<?php if($edit){ echo $result->discount;}elseif(isset($_POST['discount'])) echo $_POST['discount'];?>"  placeholder="<?php _e('Discount must be Amount Like 100','gym_mgt');?> <?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?>"  name="discount">
			</div>
		 <div class="col-sm-1">
				<span style="font-size: 18px;"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span>
		</div>
		
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="tax"><?php _e('Tax','gym_mgt');?><span class="require-field"></span></label>
			<div class="col-sm-8">
				<input id="group_name" class="form-control text-input Tax decimal_number" maxlength="4" type="text"
				value="<?php if($edit){ echo $result->tax;}elseif(isset($_POST['tax'])) echo $_POST['tax'];?>" placeholder="<?php _e('Tax must be percentage %','gym_mgt');?>"   name="tax">
			</div>
			<div class="col-sm-1">
				<span style="font-size: 18px;"><?php echo "%";?></span>
		</div>
			
		</div>
		
		<!-- <div class="form-group">
			<label class="col-sm-2 control-label" for="quentity"><?php _e('Total Amount ','gym_mgt');?><span class="require-field"></span></label>
			<div class="col-sm-8">
				<input id="group_name" class="form-control text-input total_amount decimal_number" type="Tax" value="<?php if($edit){ echo $result->total_amount;}elseif(isset($_POST['total_amount'])) echo $_POST['total_amount'];?>"  name="total_amount">
			</div>
			 <div class="col-sm-1">
				<span style="font-size: 18px;"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span>
		</div>
		
		</div> -->
		
		
		<div class="col-sm-offset-2 col-sm-8">
        	
        	<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Sell Product','gym_mgt');}?>" name="save_selling" class="btn btn-success"/>
        </div>
		
		
		
        </form>
        </div>
        
     <?php 
	 }
	 ?>
	 <!----------ADD GORUP POPUP------------->
  <div class="modal fade" id="myModal_add_product" role="dialog" style="overflow:scroll;">
    <div class="modal-dialog modal-lg">
		  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h3 class="modal-title"><?php _e('Add Product','gym_mgt');?></h3>
				</div>
				<div class="modal-body">
				  <form name="product_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="product_form">
					
					<input type="hidden" name="action" value="gmgt_add_ajax_product">
					<input type="hidden" name="product_id" value=""  />
					<div class="form-group">
						<label class="col-sm-2 control-label" for="product_name"><?php _e('Product Name','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="product_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text" value="<?php if($edit){ echo $result->product_name;}elseif(isset($_POST['product_name'])) echo $_POST['product_name'];?>" name="product_name">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="product_price"><?php _e('Product Price','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="product_price" class="form-control validate[required,custom[number]] text-input" type="text" value="<?php if($edit){ echo $result->price;}elseif(isset($_POST['product_price'])) echo $_POST['product_price'];?>" name="product_price">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="quentity"><?php _e('Product Quantity','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="group_name" class="form-control validate[required,custom[number]] text-input" type="text" value="<?php if($edit){ echo $result->quentity;}elseif(isset($_POST['quentity'])) echo $_POST['quentity'];?>" name="quentity">
						</div>
					</div>
					
					
					
					<div class="col-sm-offset-2 col-sm-8">
						
						<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Save','gym_mgt');}?>" name="save_product" class="btn btn-success"/>
					</div>
					
					
					
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>	
	
	<script>
	var value = 1;
   	function add_entry()
   	{
		value++;
   		$("#expense_entry").append('<div id="expense_entry"><div class="form-group"><label class="col-sm-2 control-label" for="income_entry"><?php _e('Product Entry','gym_mgt');?><span class="require-field"> *</span></label><div class="col-sm-4"><select id="product_id" class="form-control validate[required] product_id'+value+'" row="'+value+'" value="<?php echo $entry->product_id;?>" name="product_id[]"><option value=""><?php _e('Select Product','gym_mgt');?></option><?php $productdata=$obj_product->get_all_product();if(!empty($productdata)){foreach ($productdata as $product){?><option value="<?php echo $product->id;?>"><?php echo $product->product_name; ?> </option>	<?php } } ?>  </select></div><div class="col-sm-2"><input id="group_name" class="form-control validate[required] text-input decimal_number quantity quantity'+value+'" row="'+value+'" onkeypress="if(this.value.length==4) return false;"  placeholder="<?php _e('Product Quantity','gym_mgt');?>" type="number" min="1" value="" name="quentity[]" ></div><div class="col-sm-2"><button type="button" class="btn btn-default" onclick="deleteParentElement(this)"><i class="entypo-trash"><?php _e('Delete','gym_mgt');?></i></button></div></div></div>');
   	}
   	
   
   	function deleteParentElement(n){
		 alert(' Do you really want to delete this record');
   		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
   	}
       </script> 