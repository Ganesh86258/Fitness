<?php   
class MJ_Gmgtmember
{
	public function gmgt_add_user($data)
	{	

		global $wpdb;
		$table_members = $wpdb->prefix. 'usermeta';
		$table_gmgt_groupmember = $wpdb->prefix.'gmgt_groupmember';
		$table_income=$wpdb->prefix.'gmgt_income_expense';
		
		//-------usersmeta table data--------------
		if(isset($data['middle_name']))
		$usermetadata['middle_name']=remove_tags_and_special_characters($data['middle_name']);
		if(isset($data['gender']))
		$usermetadata['gender']=$data['gender'];
		if(isset($data['birth_date']))
		$usermetadata['birth_date']=$data['birth_date'];
		if(isset($data['address']))
		$usermetadata['address']=strip_tags($data['address']);
		
		if(isset($data['city']))
		$usermetadata['city']=remove_tags_and_special_characters($data['city']);
		
		if(isset($data['State']))
		$usermetadata['State']=remove_tags_and_special_characters($data['State']);

	    if(isset($data['Country']))
		$usermetadata['Country']=remove_tags_and_special_characters($data['Country']);

	   


        if(isset($data['current_status']))
		$usermetadata['current_status']=remove_tags_and_special_characters($data['current_status']);

	    if(isset($data['Phone_number']))
		//$usermetadata['Phone_number']=remove_tags_and_special_characters($data['Phone_number']);
	    $usermetadata['Phone_number'] = $data['Phone_number'];


	    if(isset($data['Sport']))
		$usermetadata['Sport']=remove_tags_and_special_characters($data['Sport']);


	          

        if(isset($data['Gym_name']))
		$usermetadata['Gym_name']=remove_tags_and_special_characters($data['Gym_name']);

	    if(isset($data['time_zone']))
		$usermetadata['time_zone']=remove_tags_and_special_characters($data['time_zone']);


        if(isset($data['Location']))
		$usermetadata['Location']=remove_tags_and_special_characters($data['Location']);



        if(isset($data['Training_specialties']))
		$usermetadata['Training_specialties']=remove_tags_and_special_characters($data['Training_specialties']);


		
		if(isset($data['zip_code']))
		$usermetadata['zip_code']=remove_tags_and_special_characters($data['zip_code']);
		
		if(isset($data['mobile']))
		$usermetadata['mobile']=remove_tags_and_special_characters($data['mobile']);
		if(isset($data['phone']))
		$usermetadata['phone']=remove_tags_and_special_characters($data['phone']);
		if(isset($data['gmgt_user_avatar']))
		$usermetadata['gmgt_user_avatar']=strip_tags($data['gmgt_user_avatar']);
		if($data['role']=='staff_member')
		{
			if(isset($data['role_type']))
			$usermetadata['role_type']=remove_tags_and_special_characters($data['role_type']);
			if(isset($data['specialization']))
			$usermetadata['specialization']=json_encode($data['specialization']);
		}
		
		if($data['role']=='member')
		{
			if(isset($data['member_id']))
			$usermetadata['member_id']=$data['member_id'];
		
			if(isset($data['member_type']))
				$usermetadata['member_type']=remove_tags_and_special_characters($data['member_type']);
			// if(isset($data['class_id']))
				// $usermetadata['class_id']=$data['class_id'];
			if(isset($data['height']))
				$usermetadata['height']=remove_tags_and_special_characters($data['height']);
			if(isset($data['weight']))
				$usermetadata['weight']=remove_tags_and_special_characters($data['weight']);
			if(isset($data['chest']))
				$usermetadata['chest']=remove_tags_and_special_characters($data['chest']);
			if(isset($data['waist']))
				$usermetadata['waist']=remove_tags_and_special_characters($data['waist']);
			if(isset($data['thigh']))
				$usermetadata['thigh']=remove_tags_and_special_characters($data['thigh']);
			if(isset($data['arms']))
				$usermetadata['arms']=remove_tags_and_special_characters($data['arms']);
			if(isset($data['fat']))
				$usermetadata['fat']=remove_tags_and_special_characters($data['fat']);
			
			if(isset($data['staff_id']))
				$usermetadata['staff_id']=$data['staff_id'];
			if(isset($data['intrest_area']))
				$usermetadata['intrest_area']=remove_tags_and_special_characters($data['intrest_area']);
			if(isset($data['source']))
				$usermetadata['source']=remove_tags_and_special_characters($data['source']);
			if(isset($data['reference_id']))
				$usermetadata['reference_id']=$data['reference_id'];
			if(isset($data['inqiury_date']))
				$usermetadata['inqiury_date']=$data['inqiury_date'];
			if(isset($data['triel_date']))
				$usermetadata['triel_date']=$data['triel_date'];
			if(isset($data['membership_id']))
				$usermetadata['membership_id']=$data['membership_id'];
			if(isset($data['membership_status']))
				$usermetadata['membership_status']=$data['membership_status'];
			if(isset($data['auto_renew']))
				$usermetadata['auto_renew']=$data['auto_renew'];
			if(isset($data['begin_date']))
				$usermetadata['begin_date']=$data['begin_date'];
			if(isset($data['end_date']))
				$usermetadata['end_date']=$data['end_date'];
				
			if(isset($data['first_payment_date']))
				$usermetadata['first_payment_date']=$data['first_payment_date'];
			if(isset($data['member_convert']))
				$roledata['role']=$data['member_convert'];			

		}
		
		if(isset($data['username']))
		$userdata['user_login']=strip_tags($data['username']);
		if(isset($data['email']))
		$userdata['user_email']=strip_tags($data['email']);
	
		$userdata['user_nicename']=NULL;
		$userdata['user_url']=NULL;
		if(isset($data['first_name']))
			$userdata['display_name']=remove_tags_and_special_characters($data['first_name'])." ".remove_tags_and_special_characters($data['last_name']);
		
		if($data['password'] != "")
			$userdata['user_pass']=strip_tags($data['password']);
	
		
		if($data['action']=='edit')
		{			
			$userdata['ID']=$data['user_id'];
			$memberclass = get_current_user_classis($data['user_id']);
			$tbl_class = $wpdb->prefix .'gmgt_member_class';
			if(!empty($memberclass))
			{
				$wheredataa['member_id']=$data['user_id'];
				foreach($memberclass as $class_id)
				{
					$where['class_id']=$class_id;
					$wpdb->delete( $tbl_class, $wheredataa ); 
				}
			}
			foreach($data['class_id'] as $key=>$newclass){
				$wpdb->insert($tbl_class,array('member_id'=>$data['user_id'],'class_id'=>$newclass));
			}
		
			$user_id =$data['user_id'];
			wp_update_user($userdata);
			
			if(!empty($roledata))
			{
				$u = new WP_User($user_id);
				$u->remove_role( 'member' );
				$u->add_role( 'staff_member');				
			}
			$returnans=update_user_meta( $user_id, 'first_name', remove_tags_and_special_characters($data['first_name']) );
			$returnans=update_user_meta( $user_id, 'last_name', remove_tags_and_special_characters($data['last_name']) );
			
			
			        $gymname=get_option( 'gmgt_system_name' );
					$to[] = strip_tags($data['email']);         
					$subject = get_option('registration_title'); 
					$sub_arr['[GMGT_GYM_NAME]']=$gymname;
			        $subject1 = gmgt_subject_string_replacemnet($sub_arr,$subject);
					$search=array('[GMGT_MEMBERNAME]','[GMGT_MEMBERID]','[GMGT_STARTDATE]','[GMGT_ENDDATE]','[GMGT_MEMBERSHIP]','[GMGT_GYM_NAME]');
					$membership_name=get_membership_name($data['membership_id']);
					$replace = array($userdata['display_name'],$data['member_id'],$data['begin_date'],$data['end_date'],$membership_name,get_option( 'gmgt_system_name' ));
					$message_replacement = str_replace($search, $replace,get_option('registration_mailtemplate'));
                    gmgt_send_mail($to,$subject1,$message_replacement); 
			
			//under registration mail start
			 $role=remove_tags_and_special_characters($data['role']);
			 $gymname=get_option( 'gmgt_system_name' );
			$login_link=home_url();
		
			$arr['[GMGT_USERNAME]']=$userdata['display_name'];	
			$arr['[GMGT_GYM_NAME]']=$gymname;
			$arr['[GMGT_ROLE_NAME]']=$role;
			$arr['[GMGT_Username]']=strip_tags($data['username']);
			$arr['[GMGT_PASSWORD]']=strip_tags($data['password']);
			$arr['[GMGT_LOGIN_LINK]']=$login_link;
			$subject =get_option('Add_Other_User_in_System_Subject');
			$sub_arr['[GMGT_ROLE_NAME]']=$role;
			$sub_arr['[GMGT_GYM_NAME]']=$gymname;
			$subject = gmgt_subject_string_replacemnet($sub_arr,$subject);
			$message = get_option('Add_Other_User_in_System_Template');	
			$message_replacement = gmgt_string_replacemnet($arr,$message);
				$to[]=strip_tags($data['email']);
					gmgt_send_mail($to,$subject,$message_replacement);
			//under registration mail end
				
				//echo "<pre>";
				//print_r($usermetadata);

				//echo "hi";
				//exit;

				foreach($usermetadata as $key=>$val)
				{
					$returnans=update_user_meta( $user_id, $key,$val );
				}
				if(isset($data['group_id']))
					if(!empty($data['group_id']))
					{						
						if($this->member_exist_ingrouptable($user_id))
							$this->delete_member_from_grouptable($user_id);
						foreach($data['group_id'] as $id)
						{								
							$group_data['group_id']=$id;
							$group_data['member_id']=$user_id;
							$group_data['created_date']=date("Y-m-d");
							$group_data['created_by']=get_current_user_id();
                            							
							$wpdb->insert( $table_gmgt_groupmember, $group_data );
							
							$gymname=get_option( 'gmgt_system_name' );
							$obj_group=new MJ_Gmgtgroup;
							$groupdata=$obj_group->get_single_group($id);
							$groupname=$groupdata->group_name;
							//$login_link=home_url();
							$arr['[GMGT_USERNAME]']=$userdata['display_name'];	
							$arr['[GMGT_GROUPNAME]']=$groupname;	
							$arr['[GMGT_GYM_NAME]']=$gymname;
							//$arr['[GMGT_ROLE_NAME]']=$role;
							//$arr['[GMGT_Username]']=$data['username'];
							//$arr['[GMGT_PASSWORD]']=$data['password'];
							//$arr['[GMGT_LOGIN_LINK]']=$login_link;
							$subject =get_option('Member_Added_In_Group_subject');
							$sub_arr['[GMGT_GROUPNAME]']=$groupname;
							$sub_arr['[GMGT_GYM_NAME]']=$gymname;
							$subject = gmgt_subject_string_replacemnet($sub_arr,$subject);
							$message = get_option('Member_Added_In_Group_Template');	
							$message_replacement = gmgt_string_replacemnet($arr,$message);
							$to[]=strip_tags($data['email']);
							gmgt_send_mail($to,$subject,$message_replacement);							
							
						}
					}					
				return $user_id;
		}
		else
		{			
			$user_id = wp_insert_user( $userdata );
			$gymname=get_option( 'gmgt_system_name' );
			$to[] = strip_tags($data['email']);         
			$subject = get_option('registration_title'); 
			$sub_arr['[GMGT_GYM_NAME]']=$gymname;
			$subject1 = gmgt_subject_string_replacemnet($sub_arr,$subject);
			$search=array('[GMGT_MEMBERNAME]','[GMGT_MEMBERID]','[GMGT_STARTDATE]','[GMGT_ENDDATE]','[GMGT_MEMBERSHIP]','[GMGT_GYM_NAME]');
			$membership_name=get_membership_name($data['membership_id']);
			$replace = array($userdata['display_name'],$data['member_id'],$data['begin_date'],$data['end_date'],$membership_name,get_option( 'gmgt_system_name' ));
			$message_replacement = str_replace($search, $replace,get_option('registration_mailtemplate'));
			gmgt_send_mail($to,$subject1,$message_replacement); 
		
			//userragistation mail start
			$role=strip_tags($data['role']);
			$gymname=get_option( 'gmgt_system_name' );
			$login_link=home_url();
		
			$arr['[GMGT_USERNAME]']=$userdata['display_name'];	
			$arr['[GMGT_GYM_NAME]']=$gymname;
			$arr['[GMGT_ROLE_NAME]']=$role;
			$arr['[GMGT_Username]']=strip_tags($data['username']);
			$arr['[GMGT_PASSWORD]']=strip_tags($data['password']);
			$arr['[GMGT_LOGIN_LINK]']=$login_link;
			$subject =get_option('Add_Other_User_in_System_Subject');
			$sub_arr['[GMGT_ROLE_NAME]']=$role;
			$sub_arr['[GMGT_GYM_NAME]']=$gymname;
			$subject = gmgt_subject_string_replacemnet($sub_arr,$subject);
			$message = get_option('Add_Other_User_in_System_Template');	
			$message_replacement = gmgt_string_replacemnet($arr,$message);
			$to[]=strip_tags($data['email']);
			gmgt_send_mail($to,$subject,$message_replacement);
			//userragistation mail end
			
			$user = new WP_User($user_id);
			$user->set_role(strip_tags($data['role']));
			if($data['role']=='member')
			{
				$usermetadata['membership_status']="Continue";

				if(isset($data['class_id']))
				{
					$MemberClassData = array();
					$MemberClassData['member_id']=$user_id;
					$tbl_MemberClass = $wpdb->prefix . 'gmgt_member_class';
					foreach($data['class_id'] as $key=>$class_id){
						$MemberClassData['class_id']=$class_id; 
						$wpdb->insert($tbl_MemberClass,$MemberClassData);
					}
				}
			}
			
			foreach($usermetadata as $key=>$val)
			{
				$returnans=add_user_meta( $user_id, $key,$val, true );
			}
			if(isset($data['first_name']))
			$returnans=update_user_meta( $user_id, 'first_name', remove_tags_and_special_characters($data['first_name']));
			if(isset($data['last_name']))
			$returnans=update_user_meta( $user_id, 'last_name', remove_tags_and_special_characters($data['last_name']));
			
			if(isset($data['group_id']))
				if(!empty($data['group_id']))
				{			
					foreach($data['group_id'] as $id)
					{							
						$group_data['group_id']=$id;
						$group_data['member_id']=$user_id;						
						$group_data['created_date']=date("Y-m-d");
						$group_data['created_by']=get_current_user_id();
						$wpdb->insert( $table_gmgt_groupmember, $group_data );
						$gymname=get_option( 'gmgt_system_name' );
						$obj_group=new MJ_Gmgtgroup;
						$groupdata=$obj_group->get_single_group($id);
						$groupname=$groupdata->group_name;				
						
						$arr['[GMGT_USERNAME]']=$userdata['display_name'];	
						$arr['[GMGT_GROUPNAME]']=$groupname;	
						$arr['[GMGT_GYM_NAME]']=$gymname;
						
						$subject =get_option('Member_Added_In_Group_subject');
						$sub_arr['[GMGT_GROUPNAME]']=$groupname;
						$sub_arr['[GMGT_GYM_NAME]']=$gymname;
						$subject = gmgt_subject_string_replacemnet($sub_arr,$subject);
						$message = get_option('Member_Added_In_Group_Template');	
						$message_replacement = gmgt_string_replacemnet($arr,$message);
						$to[]=strip_tags($data['email']);
						gmgt_send_mail($to,$subject,$message_replacement);
						
						$to[]= strip_tags($data['email']);
						$login_link=home_url();
										
						$subject =get_option( 'Member_Approved_Template_Subject' ); 
						$gymname=get_option( 'gmgt_system_name' );
						$sub_arr['[GMGT_GYM_NAME]']=$gymname;
						$subject = gmgt_subject_string_replacemnet($sub_arr,$subject);
						$search=array('[GMGT_GYM_NAME]','[GMGT_LOGIN_LINK]');
						$membership_name=get_membership_name($membership_id);
						$replace = array($gymname,$login_link);
						$message_replacement = str_replace($search, $replace,get_option('Member_Approved_Template'));	
						 gmgt_send_mail($to,$subject,$message_replacement);							
					}
				}
				if($data['role']=='member')
				{
					//invoice number generate
					$result_invoice_no=$wpdb->get_results("SELECT * FROM $table_income");						
					
					if(empty($result_invoice_no))
					{							
						$invoice_no='00001';
					}
					else
					{							
						$result_no=$wpdb->get_row("SELECT invoice_no FROM $table_income where invoice_id=(SELECT max(invoice_id) FROM $table_income)");
						$last_invoice_number=$result_no->invoice_no;
						$invoice_number_length=strlen($last_invoice_number);
						
						if($invoice_number_length=='5')
						{
							$invoice_no = str_pad($last_invoice_number+1, 5, 0, STR_PAD_LEFT);
						}
						else	
						{
							$invoice_no='00001';
						}				
					}
					
					$membership_status = 'continue';
					$payment_data = array();
					$payment_data['invoice_no']=$invoice_no;
					$payment_data['member_id'] = $user_id;
					$payment_data['membership_id'] = $data['membership_id'];
					$payment_data['membership_amount'] = get_membership_price($data['membership_id']);
					$payment_data['start_date'] = date('Y-m-d',strtotime($data['begin_date']));
					$payment_data['end_date'] = date('Y-m-d',strtotime($data['end_date']));
					$payment_data['membership_status'] = $membership_status;
					$payment_data['payment_status']='Unpaid';
					$payment_data['created_date'] = date("Y-m-d");
					$payment_data['created_by'] = get_current_user_id();
				
					$plan_id = $this->add_membership_payment_detail($payment_data);
					
					//membership invoice mail send
					$insert_id=$plan_id;
					$paymentlink=home_url().'?dashboard=user&page=membership_payment';
					$gymname=get_option( 'gmgt_system_name' );
					$userdata=get_userdata($data['member_id']);
					$arr['[GMGT_USERNAME]']=$userdata->display_name;	
					$arr['[GMGT_GYM_NAME]']=$gymname;
					$arr['[GMGT_PAYMENT_LINK]']=$paymentlink;
					$subject =get_option('generate_invoice_subject');
					$sub_arr['[GMGT_GYM_NAME]']=$gymname;
					$subject = gmgt_subject_string_replacemnet($sub_arr,$subject);
					$message = get_option('generate_invoice_template');	
					$message_replacement = gmgt_string_replacemnet($arr,$message);
					$to[]=$userdata->user_email;
					//$message_replacement.=gmgt_member_view_paymenthistory_mailhtml($insert_id);
					//gmgt_send_mail_text_html($to,$subject,$message_replacement);
					$type='membership_invoice';
					gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$insert_id,$type);
			
					//save membership payment data into income table			
					$table_income=$wpdb->prefix.'gmgt_income_expense';
					$membership_name=get_membership_name($data['membership_id']);
					$entry_array[]=array('entry'=>$membership_name,'amount'=>get_membership_price($data['membership_id']));	
					$incomedata['entry']=json_encode($entry_array);	
					
					$incomedata['invoice_type']='income';
					$incomedata['invoice_label']=__("Fees Payment","gym_mgt");
					$incomedata['supplier_name']=$user_id;
					$incomedata['invoice_date']=date('Y-m-d');
					$incomedata['receiver_id']=get_current_user_id();
					$incomedata['amount']=get_membership_price($data['membership_id']);
					$incomedata['total_amount']=get_membership_price($data['membership_id']);
					$incomedata['invoice_no']=$invoice_no;
					$incomedata['paid_amount']=0;
					$incomedata['payment_status']='Unpaid';
					$result_income=$wpdb->insert( $table_income,$incomedata); 
				}
			return $user_id;
		}
	}
	//add membership payment details
	public function add_membership_payment_detail($data)
	{
		global $wpdb;
		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';

		$result = $wpdb->insert($table_gmgt_membership_payment,$data);
		 $lastid = $wpdb->insert_id;
		return $lastid;

	}
	//get all groups
	public function get_all_groups()
	{
		global $wpdb;
		$table_members = $wpdb->prefix. 'gmgt_groups';
	
		$result = $wpdb->get_results("SELECT * FROM $table_members");
		return $result;	
	}
	//get single group
	public function get_single_group($id)
	{
		global $wpdb;
		$table_members = $wpdb->prefix. 'gmgt_groups';
		$result = $wpdb->get_row("SELECT * FROM $table_members where id=".$id);
		return $result;
	}
	//delete userdata
	public function delete_usedata($record_id)
	{
		global $wpdb;
		
		$table_name = $wpdb->prefix . 'usermeta';
		$table_gmgt_groupmember = $wpdb->prefix. 'gmgt_groupmember';
		$result1=$wpdb->query($wpdb->prepare("DELETE FROM $table_gmgt_groupmember WHERE member_id= %d",$record_id));
		$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE user_id= %d",$record_id));
		$retuenval=wp_delete_user( $record_id );
		return $retuenval;
	}
	//member exits in group table
	public function member_exist_ingrouptable($member_id)
	{		
		global $wpdb;	
		$table_gmgt_groupmember = $wpdb->prefix. 'gmgt_groupmember';
		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_groupmember where member_id=".$member_id);
		if(!empty($result))
			return true;
		return false;
	}
	//delete member from group table
	public function delete_member_from_grouptable($member_id)
	{
		global $wpdb;
		$table_gmgt_groupmember = $wpdb->prefix. 'gmgt_groupmember';
		$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_gmgt_groupmember WHERE member_id= %d",$member_id));
	}
	//get all join group
	public function get_all_joingroup($member_id)
	{
		global $wpdb;
		$table_gmgt_groupmember = $wpdb->prefix. 'gmgt_groupmember';
		$result = $wpdb->get_results("SELECT group_id FROM $table_gmgt_groupmember where member_id=".$member_id,ARRAY_A);
		return $result;
	}
	//convert group array
	public function convert_grouparray($join_group)
	{
		$groups = array();
		foreach($join_group as $group)
			$groups[] = $group['group_id'];
		return $groups;
	}
}
?>