<?php   
class MJ_Gmgtclassschedule extends  MJ_Gmgtmembership
{	
	public function gmgt_add_class($data)
	{
		global $wpdb;
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
		$tbl_membership_class = $wpdb->prefix. 'gmgt_membership_class';
		$classdata['class_name']=remove_tags_and_special_characters($data['class_name']);
		$classdata['staff_id']=$data['staff_id'];
		$classdata['asst_staff_id']=$data['asst_staff_id'];
		$classdata['day']=json_encode($data['day']);
		$classdata['start_time']=$data['start_time'].':'.$data['start_min'].':'.$data['start_ampm'];
		$classdata['end_time']=$data['end_time'].':'.$data['end_min'].':'.$data['end_ampm'];
		$classdata['staff_id']=$data['staff_id'];
		$classdata['class_creat_date']=date("Y-m-d");
		$classdata['class_created_id']=get_current_user_id();		
	
		if($data['action']=='edit')
		{
			$classid['class_id']=$data['class_id'];
			
			$result=$wpdb->update( $table_class, $classdata ,$classid);
			
			$new_membership =isset($data['membership_id'])?$data['membership_id']:array();
			$old_membership = $this->old_membership($data['class_id']);
			
			$different_insert = array_diff($new_membership,$old_membership);
			$different_delete = array_diff($old_membership,$new_membership);
			
			if(!empty($different_insert))	
			{
				$membershipdata['class_id']=$data['class_id'];
				foreach($different_insert as $membership_id)
				{
					$membershipdata['membership_id']=$membership_id;
					$wpdb->insert($tbl_membership_class,$membershipdata);
				}
			}	
			if(!empty($different_delete))
			{
				foreach($different_delete as $membership_id)
				{	
					$wpdb->delete( $tbl_membership_class, array( 'membership_id' => $membership_id ) );
				}
			}	
			return $result;
		}
		else
		{
			$classmeta=array();
			$result=$wpdb->insert($table_class,$classdata);			
			
			$classmeta['class_id'] = $wpdb->insert_id;
			if(!empty($data['membership_id']))
			{
				foreach($data['membership_id'] as $membership_id)
				{
					$classmeta['membership_id']=$membership_id;
					$result=$wpdb->insert( $tbl_membership_class, $classmeta );	
				}
			}
			return $result;
		}
	}
	//get all classes
	public function get_all_classes()
	{
		global $wpdb;
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
	
		$result = $wpdb->get_results("SELECT * FROM $table_class");
		return $result;
	
	}
	//get all classes by created by
	public function get_all_classes_by_class_created_id($user_id)
	{
		global $wpdb;
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
	
		$result = $wpdb->get_results("SELECT * FROM $table_class where class_created_id=$user_id");
		return $result;
	
	}
	//get all classes by staffmember
	public function get_all_classes_by_staffmember($user_id)
	{
		global $wpdb;
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
	
		$result = $wpdb->get_results("SELECT * FROM $table_class where staff_id=$user_id And asst_staff_id=$user_id");
		return $result;
	
	}
	//get all classes by member
	public function get_all_classes_by_member($cur_user_class_id)
	{
		global $wpdb;
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
		$newarray = implode(", ", $cur_user_class_id);
		$result = $wpdb->get_results("SELECT * FROM $table_class where class_id IN ($newarray)");
		return $result;
	
	}
	// get class by staff member
	public function getClassesByStaffmeber($id)
	{
		global $wpdb;
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
	
		$ClassData = $wpdb->get_results("SELECT * FROM $table_class where staff_id=$id");
		
		if(!empty($ClassData))
		{
			foreach($ClassData as $key=>$class_id)
			{
				$classids[]= $class_id->class_id;
			}
			return $classids;
		}	
	}	
	//get single class
	public function get_single_class($id)
	{
		global $wpdb;
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
		$result = $wpdb->get_row("SELECT * FROM $table_class where class_id=".$id);
		return $result;
	}
	//get class name
	public function get_class_name($id)
	{
		global $wpdb;
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
		$result = $wpdb->get_row("SELECT class_name FROM $table_class where class_id=".$id);
		return $result->class_name;
	}
	//delete class
	public function delete_class($id)
	{
		global $wpdb;
		$tbl_membership_class = $wpdb->prefix. 'gmgt_membership_class';
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
		$result = $wpdb->query("DELETE FROM $table_class where class_id= ".$id);
		//$wpdb->delete( $tbl_membership_class, array( 'membership_id' => $membership_id ) );
		$result = $wpdb->query("DELETE FROM $tbl_membership_class where class_id= ".$id);
		return $result;
	}
	//get sedule by day
	public function get_schedule_byday($day)
	{
		global $wpdb;
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
		$resultdata = $wpdb->get_results("SELECT * FROM $table_class ORDER BY start_time  ASC");		
		$day_array[]=array();
		foreach($resultdata as  $result)
		{				
			$class_days=json_decode($result->day);
			$class_days = isset($class_days)?$class_days:array();
			if(in_array($day,$class_days))
			{
				$day_array[]=array('dayname'=>$day,'start_time'=>$result->start_time,'end_time'=>$result->end_time,'class_id'=>$result->class_id,'staff_id'=>$result->staff_id,'asst_staff_id'=>$result->asst_staff_id,'class_created_id'=>$result->class_created_id);
			}
		}
		return $day_array;
	}
	//get class member
	function get_class_members($class_id)
	{
		global $wpdb;		
		$tbl_membership_class = $wpdb->prefix. 'gmgt_membership_class';
		return $wpdb->get_results("SELECT * FROM $tbl_membership_class WHERE class_id=$class_id");
	}
	//get old membership
	function old_membership($class_id)
	{
		global $wpdb;		
		$tbl_membership_class = $wpdb->prefix. 'gmgt_membership_class';
		$reesult = $wpdb->get_results("SELECT * FROM $tbl_membership_class WHERE class_id=$class_id");
		$data=array();
		if(!empty($reesult))
		{
			foreach($reesult as $key=>$val)
			{
				$data[]=$val->membership_id;
			}
		}
		return $data;
	}
	//member book class
	public function get_member_book_class($member_id)
	{		
		global $wpdb;
		$table_booking_class = $wpdb->prefix. 'gmgt_booking_class';	
		$membership_id = get_user_meta($member_id,'membership_id',true);
		 $sql ="SELECT * FROM $table_booking_class WHERE member_id=$member_id AND membership_id=$membership_id";
		return $wpdb->get_results($sql);
	}
	//book class
	public function booking_class($class_id,$dayname)
	{	
		global $wpdb;
		$result = array();
		$bookingdata = array();
		$bookingdata['member_id']=get_current_user_id();	
		$bookingdata['class_id']=$class_id;	
		$bookingdata['booking_date']=date('Y-m-d');
	
		$userdata = get_userdata(get_current_user_id());		
		$membership_id = get_user_meta($userdata->ID,'membership_id',true);
		$membershipdata = $this->get_single_membership($membership_id);	
		$bookingdata['membership_id']=$membership_id;
		$bookingdata['booking_day']=$dayname;
		
		$userd_class = get_user_used_membership_class($membership_id,get_current_user_id());
		$date = date('Y-m-d',strtotime(get_user_meta(get_current_user_id(),'end_date',true)));
		$begin_date = date('Y-m-d',strtotime(get_user_meta(get_current_user_id(),'begin_date',true)));		
		
		if ((date('Y-m-d') > $begin_date) && (date('Y-m-d') < $date))
		{
			if(date('Y-m-d') < $date )
			{
				if($userd_class < $membershipdata->on_of_classis)
				{
					$table_booking_class = $wpdb->prefix. 'gmgt_booking_class';		
					$insert = $wpdb->insert($table_booking_class,$bookingdata);
					if($insert)
					{
						$result =__('Class book successfully','gym_mgt');
					}
				} 
				else
				{			
					$result = __('Class Limit is over','gym_mgt');			
				}
			} 
			else
			{
				$result=__('Your Membership is expire','gym_mgt');
			}
		} 
		else
		{
			$result=__('Your Booking day is not between membership period','gym_mgt');
		}
		return $result;
	}
}
?>