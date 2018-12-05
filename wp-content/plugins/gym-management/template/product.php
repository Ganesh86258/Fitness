<?php $curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_product=new MJ_Gmgtproduct;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'productlist';
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
	if(isset($_POST['save_product']))
	{
		
			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
			{
				$result=$obj_product->gmgt_add_product($_POST);
				if($result)
				{
					wp_redirect ( home_url().'?dashboard=user&page=product&tab=productlist&message=2');
				}
			}
			else
			{
				$data=$obj_product->get_all_product_by_name($_POST['product_name']);
				if(!empty($data))
				{
					  echo '<script type="text/javascript">alert("This product name already store so please enter another product name.");</script>';
				}
				else
				{
				
				    $result=$obj_product->gmgt_add_product($_POST);
					if($result)
					{
						wp_redirect ( home_url().'?dashboard=user&page=product&tab=productlist&message=1');
					}
				}
			}
	}
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			$result=$obj_product->delete_product($_REQUEST['product_id']);
			if($result)
			{
				wp_redirect ( home_url().'?dashboard=user&page=product&tab=productlist&message=3');
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
	<script type="text/javascript">
	$(document).ready(function() {
		jQuery('#product_list').DataTable({
			responsive: true
			});
			$('#product_form').validationEngine();
	} );
	</script>
<div class="panel-body panel-white">
    <ul class="nav nav-tabs panel_tabs" role="tablist">
	  	<li class="<?php if($active_tab=='productlist'){?>active<?php }?>">
			<a href="?dashboard=user&page=product&tab=productlist" class="tab <?php echo $active_tab == 'productlist' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Product List', 'gym_mgt'); ?></a>
          </a>
        </li>
        <li class="<?php if($active_tab=='addproduct'){?>active<?php }?>">
		  <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['product_id']))
			{?>
			<a href="?dashboard=user&page=product&tab=addproduct&&action=edit&product_id=<?php echo $_REQUEST['product_id'];?>" class="nav-tab <?php echo $active_tab == 'addproduct' ? 'nav-tab-active' : ''; ?>">
             <i class="fa fa"></i> <?php _e('Edit  Product', 'gym_mgt'); ?></a>
			 <?php }
			else
			{
				if($user_access['add']=='1')
				{
				?>
					<a href="?dashboard=user&page=product&tab=addproduct&&action=insert" class="tab <?php echo $active_tab == 'addproduct' ? 'active' : ''; ?>">
				<i class="fa fa-plus-circle"></i> <?php _e('Add Product', 'gym_mgt'); ?></a>
				<?php 	
				} 
			}
		?>	  
	   </li>
	  
   </ul>
	<div class="tab-content">
	<?php if($active_tab == 'productlist')
	{ ?>	
     <div class="panel-body">
        <div class="table-responsive">
		    <table id="product_list" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
					<th><?php  _e( 'Product Name', 'gym_mgt' ) ;?></th>
					<th><?php  _e( 'Product Price', 'gym_mgt' ) ;?></th>
					<th><?php  _e( 'Product Quantity', 'gym_mgt' ) ;?></th>
					<?php
					if($user_access['edit']=='1' || $user_access['delete']=='1')
					{	
					?>	
						<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
					<?php	
					}
					?>
					</tr>
			    </thead>
				<tfoot>
					<tr>
					<th><?php  _e( 'Product Name', 'gym_mgt' ) ;?></th>
					<th><?php  _e( 'Product Price', 'gym_mgt' ) ;?></th>
					<th><?php  _e( 'Product Quantity', 'gym_mgt' ) ;?></th>
					<?php
					if($user_access['edit']=='1' || $user_access['delete']=='1')
					{	
					?>	
						<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
					<?php
					}
					?>	
					</tr>
				</tfoot>
				<tbody>
				<?php 
				if($user_access['own_data']=='1')
				{
					$user_id=get_current_user_id();
					$productdata=$obj_product->get_all_product_by_created_by($user_id);
				}
				else
				{
					$productdata=$obj_product->get_all_product();
				}	
				
				if(!empty($productdata))
				{
					foreach ($productdata as $retrieved_data){?>
					<tr>
					<?php if($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')
						   {?>
						<td class="productname"><a href="?dashboard=user&page=product&tab=addproduct&action=edit&product_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->product_name;?></a></td>
						   <?php }
						   else
						   {?>
							   <td class="productname"><?php echo $retrieved_data->product_name;?></td>
						   <?php } ?>
						<td class="productprice"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo  $retrieved_data->price;?></td>
						<td class="productquentity"><?php echo $retrieved_data->quentity;?></td>
					<?php
					if($user_access['edit']=='1' || $user_access['delete']=='1')
					{	
					?>	
						<td class="action">
						<?php
						if($user_access['edit']=='1')
						{
						?>
							<a href="?dashboard=user&page=product&tab=addproduct&action=edit&product_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
						<?php
						}
						if($user_access['delete']=='1')
						{
						?>		
							<a href="?dashboard=user&page=product&tab=productlist&action=delete&product_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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
				}
				?>
				</tbody>
			</table>
 		</div>
	</div>
	<?php 
	}
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
				<div class="col-sm-7">
					<input id="product_price" class="form-control validate[required] text-input" min="0" onkeypress="if(this.value.length==6) return false;"  type="number" value="<?php if($edit){ echo $result->price;}elseif(isset($_POST['product_price'])) echo $_POST['product_price'];?>" name="product_price">
				</div>
				<div class="col-sm-1">
					<span style="font-size: 20px;"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="quentity"><?php _e('Product Quantity','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="group_name" class="form-control validate[required] text-input" min="0" onkeypress="if(this.value.length==6) return false;" type="number"  value="<?php if($edit){ echo $result->quentity;}elseif(isset($_POST['quentity'])) echo $_POST['quentity'];?>" name="quentity">
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
	</div>
</div>
<?php ?>