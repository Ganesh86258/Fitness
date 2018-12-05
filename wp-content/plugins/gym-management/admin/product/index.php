<?php 
$obj_product=new MJ_Gmgtproduct;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'productlist';
?>
<div class="page-inner" style="min-height:1631px !important">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>
</div>
	<?php 
	if(isset($_POST['save_product']))
	{
		
			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
			{
					
				$result=$obj_product->gmgt_add_product($_POST);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_product&tab=productlist&message=2');
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
							wp_redirect ( admin_url().'admin.php?page=gmgt_product&tab=productlist&message=1');
						}
				}
				
			}
	}
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			$result=$obj_product->delete_product($_REQUEST['product_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=gmgt_product&tab=productlist&message=3');
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
							<a href="?page=gmgt_product&tab=productlist" class="nav-tab 
							<?php echo $active_tab == 'productlist' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Product List', 'gym_mgt'); ?></a>
							
							<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
							{?>
							<a href="?page=gmgt_product&tab=addproduct&action=edit&product_id=<?php echo $_REQUEST['product_id'];?>" class="nav-tab <?php echo $active_tab == 'addproduct' ? 'nav-tab-active' : ''; ?>">
							<?php _e('Edit Product', 'gym_mgt'); ?></a>  
							<?php 
							}
							else
							{?>
								<a href="?page=gmgt_product&tab=addproduct" class="nav-tab <?php echo $active_tab == 'addproduct' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Product', 'gym_mgt'); ?></a>
								
							<?php  }?>
						   
						</h2>
						 <?php 
						//Report 1 
						if($active_tab == 'productlist')
						{ 
						?>	
					<script type="text/javascript">
						$(document).ready(function() {
							jQuery('#product_list').DataTable({
								"responsive": true,
								"order": [[ 0, "asc" ]],
								"aoColumns":[
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
												<th><?php  _e( 'Product Name', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Product Price', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Product Quantity', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
											</tr>
									    </thead>
										<tfoot>
											<tr>
												<th><?php  _e( 'Product Name', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Product Price', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Product Quantity', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
										    </tr>
										</tfoot>
										<tbody>
										<?php 
											$productdata=$obj_product->get_all_product();
											if(!empty($productdata))
											{
												foreach ($productdata as $retrieved_data){
											 ?>
												<tr>
													<td class="productname"><a href="?page=gmgt_product&tab=addproduct&action=edit&product_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->product_name;?></a></td>
													<td class="productprice"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo $retrieved_data->price;?></td>
													<td class="productquentity"><?php echo $retrieved_data->quentity;?></td>
													<td class="action"> <a href="?page=gmgt_product&tab=addproduct&action=edit&product_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
													<a href="?page=gmgt_product&tab=productlist&action=delete&product_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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
						if($active_tab == 'addproduct')
						 {
						require_once GMS_PLUGIN_DIR. '/admin/product/add_product.php';
						 }
						 ?>
					</div>
								
				</div>
			</div>
		</div>
	</div>
</div>
<?php //} ?>