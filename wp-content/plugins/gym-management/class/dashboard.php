<?php   
class MJ_Gmgtdashboard
{	
	//count membership
	public function count_member_ship()
	{
		global $wpdb;
		$table_gmgt_membershiptype = $wpdb->prefix . "gmgt_membershiptype";
		$results=$wpdb->get_var("SELECT count(*) FROM $table_gmgt_membershiptype");
		return $results;	
	}
	//get membership list
	public function get_membership_list($limit = 5)
	{
		global $wpdb;
		$table_gmgt_membershiptype = $wpdb->prefix . "gmgt_membershiptype";
		$results=$wpdb->get_results("SELECT * FROM $table_gmgt_membershiptype limit 0,$limit");
		return $results;	
	}
	//count group
	public function count_group()
	{
		global $wpdb;
		$table_gmgt_groups = $wpdb->prefix . "gmgt_groups";
		$results=$wpdb->get_var("SELECT count(*) FROM $table_gmgt_groups");
		return $results;	
	}
	//get group list
	public function get_grouplist($limit = 5)
	{
		global $wpdb;
		$table_gmgt_groups = $wpdb->prefix . "gmgt_groups";
		$results=$wpdb->get_results("SELECT * FROM $table_gmgt_groups limit 0,$limit");
		return $results;	
	}	
}
?>