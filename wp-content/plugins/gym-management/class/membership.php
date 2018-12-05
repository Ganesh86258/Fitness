<?php   
class MJ_Gmgtmembership
{	
	public function gmgt_add_membership($data,$member_image_url)
	{		
		global $wpdb;
		$obj_activity=new MJ_Gmgtactivity;
		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';
		//-------usersmeta table data--------------
		$membershipdata['membership_label']=remove_tags_and_special_characters($data['membership_name']);
		$membershipdata['membership_cat_id']=$data['membership_category'];
		$membershipdata['membership_length_id']=$data['membership_period'];		
		$membershipdata['membership_class_limit']=$data['member_limit'];
		
		if(isset($data['on_of_member']))
			$membershipdata['on_of_member']=$data['on_of_member'];
		else
			$membershipdata['on_of_member']=0;
		
		$membershipdata['classis_limit']=$data['classis_limit'];		
		if(isset($data['on_of_classis']))
			$membershipdata['on_of_classis']=$data['on_of_classis'];
		else
			$membershipdata['on_of_classis']=0;
		
		$membershipdata['install_plan_id']=$data['installment_plan'];
		$membershipdata['membership_amount']=$data['membership_amount'];
		$membershipdata['installment_amount']=$data['installment_amount'];
		$membershipdata['signup_fee']=$data['signup_fee'];
		$membershipdata['membership_description']=$data['description'];
		$membershipdata['gmgt_membershipimage']=$member_image_url;
		$membershipdata['created_date']=date("Y-m-d");
		$membershipdata['created_by_id']=get_current_user_id();			
		
		if($data['action']=='edit')
		{
			$membershipid['membership_id']=$data['membership_id'];
			$result=$wpdb->update( $table_membership, $membershipdata ,$membershipid);
			
			$obj_activity->add_membership_activities($data);
			return $result;
		}
		else
		{
			$result=$wpdb->insert( $table_membership, $membershipdata );
			if($result)
				$result=$wpdb->insert_id;
			$data['membership_id']=$result;
			$obj_activity->add_membership_activities($data);
			return $result;
		}	
	}
	//get all membership
	public function get_all_membership()
	{
		global $wpdb;
		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';
	
		$result = $wpdb->get_results("SELECT * FROM $table_membership");
		return $result;	
	}
	//get member own membership
	public function get_member_own_membership($membership_id)
	{
		global $wpdb;
		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';
	
		$result = $wpdb->get_results("SELECT * FROM $table_membership where membership_id=$membership_id");
		return $result;	
	}
	//get  membership by created by
	public function get_membership_by_created_by($user_id)
	{
		global $wpdb;
		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';
	
		$result = $wpdb->get_results("SELECT * FROM $table_membership where created_by_id=$user_id");
		return $result;	
	}
	//get single membership
	public function get_single_membership($id)
	{
		if($id == '')
		return '';
		global $wpdb;
		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';
		$result = $wpdb->get_row("SELECT * FROM $table_membership where membership_id= ".$id);
		return $result;
	}
	//delete membership
	public function delete_membership($id)
	{
		global $wpdb;
		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';
		$result = $wpdb->query("DELETE FROM $table_membership where membership_id= ".$id);
		return $result;
	}
	//update membership  image
	public function update_membershipimage($id,$imagepath)
	{
		global $wpdb;
		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';
		$image['gmgt_membershipimage']=$imagepath;
		$membershipid['membership_id']=$id;
		return $result=$wpdb->update( $table_membership, $image, $membershipid);
	}
	//get membership activities
	public function get_membership_activities($id)
	{
		global $wpdb;
		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';
	
		$result = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_activities where membership_id= ".$id);
		return $result;	
	}	
}
?>