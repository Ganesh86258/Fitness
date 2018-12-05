<?php 
class MJ_Gmgtactivity
{	
	public function gmgt_add_activity($data)
	{		
		global $wpdb;
		
		$table_activity = $wpdb->prefix. 'gmgt_activity';
		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';
		
		$activitydata['activity_cat_id']=$data['activity_cat_id'];
		$activitydata['activity_title']=strip_tags($data['activity_title']);
		$activitydata['activity_assigned_to']=$data['staff_id'];
		$activitydata['activity_added_date']=date("Y-m-d");
		$activitydata['activity_added_by']=get_current_user_id();	
		
		if($data['action']=='edit')
		{
			$activityid['activity_id']=$data['activity_id'];
			$result=$wpdb->update( $table_activity, $activitydata ,$activityid);
			if(!empty($data['membership_id']))
			{
				$this->delete_activity_membership($data['activity_id']);
				foreach($data['membership_id'] as $val){
					
					$assignactivitydata['activity_id']=$data['activity_id'];
					$assignactivitydata['membership_id']=$val;
					$assignactivitydata['created_date']=date("Y-m-d");
					$assignactivitydata['created_by']=get_current_user_id();
					
					$wpdb->insert( $table_gmgt_membership_activities, $assignactivitydata );
				}
			}
			return $result;
		}
		else
		{
			$result=$wpdb->insert( $table_activity, $activitydata );
			$activity_id=$wpdb->insert_id;
			if(!empty($data['membership_id']))
			{
				foreach($data['membership_id'] as $val)
				{
					$assignactivitydata['activity_id']=$activity_id;
					$assignactivitydata['membership_id']=$val;
					$assignactivitydata['created_date']=date("Y-m-d");
					$assignactivitydata['created_by']=get_current_user_id();
					
					$wpdb->insert( $table_gmgt_membership_activities, $assignactivitydata );
				}
			}
			return $result;
		}
	}
	//get all activity
	public function get_all_activity()
	{
		global $wpdb;
		$table_activity = $wpdb->prefix. 'gmgt_activity';
	
		$result = $wpdb->get_results("SELECT * FROM $table_activity");
		return $result;	
	}
	//get all activity by Activity added by
	public function get_all_activity_by_activity_added_by($user_id)
	{
		global $wpdb;
		$table_activity = $wpdb->prefix. 'gmgt_activity';
	
		$result = $wpdb->get_results("SELECT * FROM $table_activity where activity_added_by=$user_id");
		return $result;	
	}
	//get single activity
	public function get_single_activity($id)
	{
		global $wpdb;
		$table_activity = $wpdb->prefix. 'gmgt_activity';
		$result = $wpdb->get_row("SELECT * FROM $table_activity where activity_id=".$id);
		return $result;
	}
	//delete activity
	public function delete_activity($id)
	{
		global $wpdb;
		$table_activity = $wpdb->prefix. 'gmgt_activity';
		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';
		$result = $wpdb->query("DELETE FROM $table_activity where activity_id= ".$id);
		$wpdb->query("DELETE FROM $table_gmgt_membership_activities where activity_id= ".$id);
		
		return $result;
	}
	//check activity membership
	public function check_activity_membership($data)
	{
		global $wpdb;
		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';
		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_membership_activities where activity_id= ".$data['activity_id']." AND membership_id=".$data['membership_id']);
		
		if(!empty($result))
			return $result->id;
		else
			return false;
	}
	//get activity membership
	public function get_activity_membership($id)
	{
		global $wpdb;
		$result=array();
		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';
		$memberships = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_activities where activity_id= ".$id);
		if(!empty($memberships))
		{
			foreach($memberships as $row)
			{
				$result[]=$row->membership_id;
			}
			return $result;
		}
		else
			return $result;
	}
	//get membership activity
	public function get_membership_activity($id)
	{
		global $wpdb;
		$result=array();
		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';
		$activities = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_activities where membership_id= ".$id);
		if(!empty($activities)){
			foreach($activities as $row)
			{
				$result[]=$row->activity_id;
			}
			return $result;
		}
		else
			return $result;
	}
	//delete  activity membership
	public function delete_activity_membership($id)
	{
		global $wpdb;
		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';
		$wpdb->query("DELETE FROM $table_gmgt_membership_activities where activity_id= ".$id);
	}
	//delete membership activities
	public function delete_membership_activities($id)
	{
		global $wpdb;
		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';
		$wpdb->query("DELETE FROM $table_gmgt_membership_activities where membership_id= ".$id);
	}
	//add membership activity
	public function add_membership_activities($data)
	{
		global $wpdb;
		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';
		if(!empty($data['activity_id']))
		{
			$this->delete_membership_activities($data['membership_id']);
			foreach($data['activity_id'] as $val){
				
				$assignactivitydata['activity_id']=$val;
				$assignactivitydata['membership_id']=$data['membership_id'];
				$assignactivitydata['created_date']=date("Y-m-d");
				$assignactivitydata['created_by']=get_current_user_id();
				$result=$wpdb->insert( $table_gmgt_membership_activities, $assignactivitydata );
			}
			return $result;
			
		}
	}
	//delete membership activity
	public function delete_membership_activity($id)
	{
		global $wpdb;
		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';
		$result=$wpdb->query("DELETE FROM $table_gmgt_membership_activities where id= ".$id);
		return $result;
	}	
}
?>