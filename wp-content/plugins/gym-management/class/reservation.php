<?php  
class MJ_Gmgtreservation
{	
	public function gmgt_add_reservation($data)
	{		
		global $wpdb;
		$table_reservation = $wpdb->prefix. 'gmgt_reservation';
		
		$reservationdata['event_name']=remove_tags_and_special_characters($data['event_name']);
		$reservationdata['event_date']=get_format_for_db($data['event_date']);
		$reservationdata['start_time']=$data['start_time'].':'.$data['start_min'].':'.$data['start_ampm'];
		$reservationdata['end_time']=$data['end_time'].':'.$data['end_min'].':'.$data['end_ampm'];
		
		$reservationdata['place_id']=$data['event_place'];
		$reservationdata['staff_id']=$data['staff_id'];
		$reservationdata['created_date']=date("Y-m-d");
		$reservationdata['created_by']=get_current_user_id();
		
		$reserv_datedata=$this->get_all_reservation();
		$same_date="";
		foreach($reserv_datedata as $retrieved_data)
		{
			if($retrieved_data->event_date == $data['event_date'] && $retrieved_data->id!=$data['reservation_id'])
			{
				$same_date=$retrieved_data->event_date;				
			}
		}
		
		if($data['action']=='edit')
		{
			$reservationid['id']=$data['reservation_id'];
			if($same_date=="")
				$result=$wpdb->update( $table_reservation, $reservationdata ,$reservationid);
			else
				$result=array('id'=>$data['reservation_id'],'msg'=>'reserved');
			return $result;
		}
		else
		{			
			global $wpdb;
			$table_reservation = $wpdb->prefix. 'gmgt_reservation';
			
			$getresult = $wpdb->get_row("SELECT * FROM $table_reservation where event_date ='".$reservationdata['event_date']."' and place_id ='".$reservationdata['place_id']."'");
			
			if(!empty($getresult))
			{
				$result="reserved";
			}
			else
			{				
				if($same_date=="")
				{
					$result=$wpdb->insert( $table_reservation, $reservationdata );
				}				
				
				$titlename=get_the_title($data['event_place']);
			
				//add resrvation 
				
				 $gymname=get_option( 'gmgt_system_name' );
				
				$page_link=home_url().'/?dashboard=user&page=reservation&tab=reservationlist';
				 $staffdata=get_userdata($data['staff_id']);
				 $staffemail=$staffdata->user_email;
				 $staff_name=$staffdata->display_name;
				 
				$arr['[GMGT_STAFF_MEMBERNAME]']=$staff_name;	
				$arr['[GMGT_EVENT_NAME]']=remove_tags_and_special_characters($data['event_name']);	
				$arr['[GMGT_GYM_NAME]']=$gymname;
				$arr['[GMGT_EVENT_DATE]']=$reservationdata['event_date'];
				$arr['[GMGT_EVENT_PLACE]']=$titlename;
				$arr['[GMGT_START_TIME]']=$reservationdata['start_time'];
				$arr['[GMGT_END_TIME]']=$reservationdata['end_time'];
				$arr['[GMGT_PAGE_LINK]']=$page_link;
				$subject =get_option('Add_Reservation_Subject');
				$sub_arr['[GMGT_EVENT_NAME]']=remove_tags_and_special_characters($data['event_name']);
				$sub_arr['[GMGT_EVENT_PLACE]']=$titlename;
				$sub_arr['[GMGT_GYM_NAME]']=$gymname;
				$sub_arr['[GMGT_EVENT_DATE]']=$reservationdata['event_date'];
				$sub_arr['[GMGT_START_TIME]']=$reservationdata['start_time'];
				$subject = gmgt_subject_string_replacemnet($sub_arr,$subject);
				$message = get_option('Add_Reservation_Template');	
				$message_replacement = gmgt_string_replacemnet($arr,$message);
				$to[]=$staffemail;
				gmgt_send_mail($to,$subject,$message_replacement);				
			}
			return $result;
		}
	}
	//get all reservation
	public function get_all_reservation()
	{
		global $wpdb;
		$table_reservation = $wpdb->prefix. 'gmgt_reservation';
	
		$result = $wpdb->get_results("SELECT * FROM $table_reservation");
		return $result;	
	}
	//get reservation by created_by
	public function get_reservation_by_created_by()
	{
		global $wpdb;
		$table_reservation = $wpdb->prefix. 'gmgt_reservation';
		$user_id=get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_reservation where created_by=$user_id");
		return $result;	
	}
	//get single reservation
	public function get_single_reservation($id)
	{
		global $wpdb;
		$table_reservation = $wpdb->prefix. 'gmgt_reservation';
		$result = $wpdb->get_row("SELECT * FROM $table_reservation where id=".$id);
		return $result;
	}
	//delete reservation
	public function delete_reservation($id)
	{
		global $wpdb;
		$table_reservation = $wpdb->prefix. 'gmgt_reservation';
		$result = $wpdb->query("DELETE FROM $table_reservation where id= ".$id);
		return $result;
	}
}
?>