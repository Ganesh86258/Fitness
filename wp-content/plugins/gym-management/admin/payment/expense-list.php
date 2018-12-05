<?php 
	//This is Dashboard at admin side
	$obj_payment= new MJ_Gmgtpayment();
	if($active_tab == 'expenselist')
	{?>
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
						foreach ($obj_payment->get_all_expense_data() as $retrieved_data){ 
							$all_entry=json_decode($retrieved_data->entry);
							$total_amount=0;
							foreach($all_entry as $entry){
								$total_amount+=$entry->amount;
							}
						 ?>
						<tr>
							<td class="party_name"><?php echo $retrieved_data->supplier_name;?></td>
							<td class="income_amount"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo $total_amount;?></td>
							<td class="status"><?php echo getdate_in_input_box($retrieved_data->invoice_date);?></td>
							<td class="action">
							<a  href="#" class="show-invoice-popup btn btn-default" idtest="<?php echo $retrieved_data->invoice_id; ?>" invoice_type="expense">
							<i class="fa fa-eye"></i> <?php _e('View Expense', 'gym_mgt');?></a>
							<a href="?page=gmgt_payment&tab=addexpense&action=edit&expense_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
							<a href="?page=gmgt_payment&tab=expenselist&action=delete&expense_id=<?php echo $retrieved_data->invoice_id;?>" class="btn btn-danger" 
							onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
							<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
							</td>
						</tr>
						<?php } 
					   ?>
					</tbody>
				</table>
            </div>
        </div>
	 <?php  
	} ?>