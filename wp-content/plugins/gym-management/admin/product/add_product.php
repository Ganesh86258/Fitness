<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#product_form').validationEngine();
} );
</script>
    <?php 	
	if($active_tab == 'addproduct')
	{
        	$product_id=0;
			if(isset($_REQUEST['product_id']))
				$product_id=$_REQUEST['product_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					$edit=1;
					$result = $obj_product->get_single_product($product_id);
				}?>
        <div class="panel-body">
		    <form name="product_form" action="" method="post" class="form-horizontal" id="product_form">
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="product_id" value="<?php echo $product_id;?>"  />
				<div class="form-group">
					<label class="col-sm-2 control-label" for="product_name"><?php _e('Product Name','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="product_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $result->product_name;}elseif(isset($_POST['product_name'])) echo $_POST['product_name'];?>" name="product_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="product_price"><?php _e('Product Price','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="product_price" class="form-control validate[required] text-input" min="0"  onkeypress="if(this.value.length==6) return false;" type="number" value="<?php if($edit){ echo $result->price;}elseif(isset($_POST['product_price'])) echo $_POST['product_price'];?>" name="product_price">
					</div>
					<div class="col-sm-1">
						<span class="currency_symbole"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="quentity"><?php _e('Product Quantity','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="group_name" class="form-control validate[required] text-input" min="0" onkeypress="if(this.value.length==4) return false;" type="number" value="<?php if($edit){ echo $result->quentity;}elseif(isset($_POST['quentity'])) echo $_POST['quentity'];?>" name="quentity">
					</div>
				</div>
			
				<div class="col-sm-offset-2 col-sm-8">
				<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Save','gym_mgt');}?>" name="save_product" class="btn btn-success"/>
				</div>
		    </form>
        </div>
     <?php 
	}
	?>