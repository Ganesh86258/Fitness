<?php 
//$user = new WP_User($user_id);
class MJ_Gmgtworkouttype
{	
    //ADD WORKOUT FUNCTION
	public function gmgt_add_workouttype($data)
	{
		global $wpdb;
		$table_workout = $wpdb->prefix. 'gmgt_assign_workout';
		$workoutdata['user_id']=$data['member_id'];
		$workoutdata['level_id']=$data['level_id'];
		$workoutdata['description']=strip_tags($data['description']);
		//$workoutdata['start_date']=date('Y-m-d',strtotime($data['start_date']));
		$workoutdata['start_date']=get_format_for_db($data['start_date']);
		//$workoutdata['end_date']= date('Y-m-d',strtotime($data['last_date']));
		$workoutdata['end_date']= get_format_for_db($data['last_date']);
		$workoutdata['created_date']=date("Y-m-d");
		$workoutdata['created_by']=get_current_user_id();
		$new_array = array();
		$i = 0;
		$phpobj = array();
		if(!empty($data['activity_list']))
		{
			foreach($data['activity_list'] as $val)
			{
				$data_value = json_decode($val);
				$phpobj[] = json_decode(stripslashes($val),true);
			}
		}
		$j=0;
		$final_array = array();
		$resultarray =array();
		foreach($phpobj as $key => $val)
		{
			//var_dump($val);
			$day = array();
			$activity = array();
			foreach($val as $key=>$key_val)
			{
				//$activity =array();
				if($key == "days")
				foreach($key_val as $val1)
				{
					$day['day'][] =$val1['day_name'] ;
				}
				if($key == "activity")
					foreach($key_val as $val2)
					{
						//var_dump($val2);
						echo $val2['activity']['activity'];
						$activity['activity'][] =array('activity'=>$val2['activity']['activity'],
													'reps'=>$val2['activity']['reps'],
													'sets'=>$val2['activity']['sets'],
													'kg'=>$val2['activity']['kg'],
													'time'=>$val2['activity']['time'],
						) ;
					}
			}
			$resultarray[] = array_merge($day, $activity);
		}
		if($data['action']=='edit')
		{
			$workoutid['id']=$data['assign_workout_id'];	
			$result=$wpdb->update( $table_workout, $workoutdata ,$workoutid);
			return $result;
		}
		else
		{
			
			$result=0;
			if(!empty($phpobj)){
				$result=$wpdb->insert( $table_workout, $workoutdata );
				$assign_workout_id = $wpdb->insert_id;
				$this->assign_workout_detail($assign_workout_id,$resultarray);
				
				
			//SEND WORKOUT MAIL NOTIFICATION
			$userdata=get_userdata($data['member_id']);
			$username=$userdata->display_name;
			$useremail=$userdata->user_email;
			// $role=$data['role'];
			 $gymname=get_option( 'gmgt_system_name' );
		    $page_link='<a href='.home_url().'?gym-management/?dashboard=user&page=assign-workout>View Workout</a>';
			$arr['[GMGT_MEMBERNAME]']=$username;	
			$arr['[GMGT_GYM_NAME]']=$gymname;
			$arr['[GMGT_STARTDATE]']=$workoutdata['start_date'];
			$arr['[GMGT_ENDDATE]']=$workoutdata['end_date'];
			$arr['[GMGT_PAGE_LINK]']=$page_link;
			$subject =get_option('Assign_Workouts_Subject');
			//$sub_arr['[GMGT_ROLE_NAME]']=$role;
			$sub_arr['[GMGT_GYM_NAME]']=$gymname;
			$subject = gmgt_subject_string_replacemnet($sub_arr,$subject);
			$message = get_option('Assign_Workouts_Template');
			$message_replacement = gmgt_string_replacemnet($arr,$message);
            $invoice=Assign_Workouts_Add_Html_Content($assign_workout_id);
            $invoic_concat=$message_replacement. $invoice;			
			$to[]=$useremail;
		    gmgt_send_mail_text_html($to,$subject,$invoic_concat);
			//SEND WORKOUT MAIL NOTIFICATION END
			}
			return $result;
		}
	
	}
	//ASIGN WORKOUT DETAILS FUNCTION
	public function assign_workout_detail($workout_id,$work_outdata)
	{
		 //get_userdata
		if(!empty($work_outdata))
		{
			global $wpdb;
			$table_workout = $wpdb->prefix. 'gmgt_workout_data';
			$workout_data = array();
			foreach($work_outdata as  $value)
			{
				//var_dump($value);
				foreach($value['day'] as $day)
				{
					echo "day".$day;
					foreach($value['activity']  as $actname)
					{
						//var_dump($actname);
						$workout_data['day_name'] = $day;
						$workout_data['workout_name'] = $actname['activity'];
						$workout_data['sets'] = $actname['sets'];
						$workout_data['reps'] = $actname['reps'];
						$workout_data['kg'] = $actname['kg'];
						$workout_data['time'] = $actname['time'];
						$workout_data['workout_id'] = $workout_id;
						$workout_data['created_date'] = date("Y-m-d");
						$workout_data['create_by'] = get_current_user_id();
						$result=$wpdb->insert( $table_workout, $workout_data );
					}
				}
				
			}
			
		}
	}
	//GET ALL ASIGN WORKOUT  FUNCTION
	public function get_all_assignworkout()
	{
		global $wpdb;
		$table_workout = $wpdb->prefix. 'gmgt_assign_workout';
	
		$result = $wpdb->get_results("SELECT * FROM $table_workout");
		return $result;
	
	}
	
	//GET ALL ASIGN WORKOUT TYPE  FUNCTION
	public function get_all_workouttype()
	{
		global $wpdb;
		$table_workout = $wpdb->prefix. 'gmgt_workouts';
	
		$result = $wpdb->get_results("SELECT * FROM $table_workout");
		return $result;
	
	}
	//GET OWN ASIGN WORKOUT   FUNCTION
	public function get_own_assigned_workout($role,$id)
	{
		global $wpdb;
		$table_workout = $wpdb->prefix. 'gmgt_workouts';
		if($role=='member')
			$result = $wpdb->get_results("SELECT * FROM $table_workout where member_id=".$id);
		else
			$result = $wpdb->get_results("SELECT * FROM $table_workout where created_by=".$id);
		return $result;
	}
	
	//GET SINGE  ASIGN WORKOUT  TYPE  FUNCTION
	public function get_single_workouttype($id)
	{
		global $wpdb;
		$table_workout = $wpdb->prefix. 'gmgt_workouts';
		$result = $wpdb->get_row("SELECT * FROM $table_workout where id=".$id);
		return $result;
	}
	public function get_assigned_workout($id)
	{
		global $wpdb;
		$table_workout = $wpdb->prefix. 'gmgt_workouts';
		$result = $wpdb->get_results("SELECT * FROM $table_workout where member_id=".$id);
		return $result;
	}
	//DELETE WORKOUT TYPE FUNCTION
	public function delete_workouttype($id)
	{
		global $wpdb;
		$table_workout = $wpdb->prefix. 'gmgt_workouts';
		$result = $wpdb->query("DELETE FROM $table_workout where id= ".$id);
		return $result;
	}
	//GET SINGLE WORKOUT DATA 
	public function get_single_workoutdata($id)
	{
		global $wpdb;
		$table_workout = $wpdb->prefix.'gmgt_workout_data';
		$result = $wpdb->get_row("SELECT *FROM $table_workout where id=".$id);
		
		return $result;
	}
}
//END CLASS 
?>