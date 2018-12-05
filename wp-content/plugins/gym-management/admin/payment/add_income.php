<?php 
//This is Dashboard at admin side
$obj_payment= new MJ_Gmgtpayment();
?>
<script type="text/javascript">
$(document).ready(function()
{
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
	$(".display-members").select2();
	$('.decimal_number').keyup(function(){
    var val = $(this).val();
    if(isNaN(val)){
         val = val.replace(/[^0-9\.]/g,'');
         if(val.split('.').length>2) 
             val =val.replace(/\.+$/,"");
    }
    $(this).val(val); 
      });
} );
</script>
    <?php 	
	if($active_tab == 'addincome')
	{
        $income_id=0;
			if(isset($_REQUEST['income_id']))
				$income_id=$_REQUEST['income_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					
					$edit=1;
					$result = $obj_payment->gmgt_get_income_data($income_id);
					//var_dump($result);
				}?>
        <div class="panel-body">
			<form name="income_form" action="" method="post" class="form-horizontal" id="income_form">
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="income_id" value="<?php echo $income_id;?>">
				<input type="hidden" name="invoice_type" value="income">
				<input type="hidden" name="invoice_no" value="<?php echo $result->invoice_no;?>">
				<input type="hidden" name="paid_amount" value="<?php echo $result->paid_amount;?>">
				
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
						
				<!-- <div class="form-group">
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
				-->
				<div class="form-group">
					<label class="col-sm-2 control-label" for="invoice_date"><?php _e('Date','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="invoice_date" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" class="form-control " type="text"  
						value="<?php if($edit){ echo getdate_in_input_box($result->invoice_date);}
						elseif(isset($_POST['invoice_date'])){ echo $_POST['invoice_date'];}
						else{ echo getdate_in_input_box(date("Y-m-d"));}?>" name="invoice_date">
					</div>
				</div>
				<hr>
				
				<?php 
					
					if($edit){
						$all_entry=json_decode($result->entry);
					}
					else
					{
						if(isset($_POST['income_entry'])){
							
							$all_data=$obj_invoice->get_entry_records($_POST);
							$all_entry=json_decode($all_data);
						}
						
							
					}
					if(!empty($all_entry))
					{
							foreach($all_entry as $entry){
							?>
							<div class="income_entry_div">
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
								<label class="col-sm-2 control-label" for="income_entry"><?php _e('Income Entry','gym_mgt');?><span class="require-field"> * </span></label>
								<div class="col-sm-2">
									<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==6) return false;" value="<?php echo $entry->amount;?>" name="income_amount[]">
								</div>
								<div class="col-sm-4">
									<input id="income_entry" class="form-control validate[required,custom[onlyLetterSp]] text-input onlyletter_space_validation1" type="text" maxlength="50" value="<?php echo $entry->entry;?>" name="income_entry[]">
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
							<div class="income_entry_div">
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
									<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==6) return false;" value="" name="income_amount[]" placeholder="<?php _e('Income Amount','gym_mgt');?>" >
								</div>
								<div class="col-sm-4">
									<input id="income_entry" class="form-control validate[required,custom[onlyLetterSp]] text-input onlyletter_space_validation1"   maxlength="50" type="text" value="" name="income_entry[]" placeholder="<?php _e('Income Entry Label','gym_mgt');?>">
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
						<input id="group_name" class="form-control text-input decimal_number"  type="number" onKeyPress="if(this.value.length==6) return false;"  min="0" value="<?php if($edit){ echo $result->discount;}elseif(isset($_POST['discount'])) echo $_POST['discount'];?>" name="discount">
					</div>
				 <div class="col-sm-1">
						<span style="font-size: 18px;"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span>
				</div>
				
				</div>		
				<div class="col-sm-offset-2 col-sm-8">
					<input type="submit" value="<?php if($edit){ _e('Save Income','gym_mgt'); }else{ _e('Add Income','gym_mgt');}?>" name="save_income" class="btn btn-success"/>
				</div>
			</form>
        </div>
    <script>
		// CREATING BLANK INVOICE ENTRY
		var blank_income_entry ='';
		$(document).ready(function() { 
			blank_income_entry = $('.income_entry_div').html();
			//alert("hello" + blank_invoice_entry);
		}); 

		function add_entry()
		{
			$(".income_entry_div").append(blank_income_entry);
			//alert("hellooo");
		}
		
		// REMOVING INVOICE ENTRY
		function deleteParentElement(n)
		{
			 alert(' Do you really want to delete this record');
				n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
		}
     </script> 
     <?php 
	}
?>