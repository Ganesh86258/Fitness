<?php 	  
class MJ_Gmgtproduct
{	
	public function gmgt_add_product($data)
	{		
		global $wpdb;
		$table_product = $wpdb->prefix. 'gmgt_product';
		
		$productdata['product_name']=remove_tags_and_special_characters($data['product_name']);
		$productdata['price']=$data['product_price'];
		$productdata['quentity']=$data['quentity'];
		$productdata['created_date']=date("Y-m-d");
		$productdata['created_by']=get_current_user_id();	
	
		if($data['action']=='edit')
		{
			$productid['id']=$data['product_id'];
			$result=$wpdb->update( $table_product, $productdata ,$productid);
			return $result;
		}
		else
		{
			$result=$wpdb->insert( $table_product, $productdata );
			if($result)
				$result=$wpdb->insert_id;
			return $result;
		}	
	}
	//get all product
	public function get_all_product()
	{
		global $wpdb;
		$table_product = $wpdb->prefix. 'gmgt_product';
	
		$result = $wpdb->get_results("SELECT * FROM $table_product");
		return $result;	
	}
	//get all product by created by
	public function get_all_product_by_created_by($user_id)
	{
		global $wpdb;
		$table_product = $wpdb->prefix. 'gmgt_product';
	
		$result = $wpdb->get_results("SELECT * FROM $table_product where created_by=$user_id");
		return $result;	
	}
	//get single product
	public function get_single_product($id)
	{
		global $wpdb;
		$table_product = $wpdb->prefix. 'gmgt_product';
		$result = $wpdb->get_row("SELECT * FROM $table_product where id=".$id);
		return $result;
	}
	
	//get all product by product name
	public function get_all_product_by_name($product_name)
	{
		global $wpdb;
		$table_product = $wpdb->prefix. 'gmgt_product';
	
		$result = $wpdb->get_results("SELECT * FROM $table_product where product_name='$product_name'");
		return $result;	
	}
	
	//delete product
	public function delete_product($id)
	{
		global $wpdb;
		$table_product = $wpdb->prefix. 'gmgt_product';
		$result = $wpdb->query("DELETE FROM $table_product where id= ".$id);
		return $result;
	}	
	//get  product by product name
	public function get_product_by_name($product_name)
	{
		global $wpdb;
		$table_product = $wpdb->prefix. 'gmgt_product';
	
		$result = $wpdb->get_row("SELECT * FROM $table_product where product_name='$product_name'");
		return $result;	
	}
}
?>