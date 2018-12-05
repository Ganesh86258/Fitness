<?php
session_start();
/*
Template Name:Success 
 
*/


//echo"pay key is =".$_SESSION['pay_key'];

//echo"user id is=".$_SESSION['usrid'];

//echo"email id is=".$_SESSION['email'];

   $userdata = $_SESSION['userdata'];
   $user_meta = $_SESSION['usermeta'];

  

	$amount   = $_SESSION['amount'];
	$receiver = $_SESSION['receiver'];
	//$user_id  = $_SESSION['usrid'];
	$email =    $_SESSION['email'];
	
	
	
	define('BASE_PATH', get_site_url());
  
		
	$paypalUser		 = 'sharad.kolhe-facilitator_api1.gmail.com';
	$paypalPassword  = 'LGBWZ77ANP8HRZMK';
	$paypalSignature = 'AiPC9BjkCyDFQXbSkoZcgqH3hpacAr.VjudkRZkFqLBT8s.fbQk04iZo';
	$paypalAppId     = 'APP-80W284485P519543T';
	$paypalAccount['mode'] == 'SANDBOX';
	
	$url = 'https://svcs.sandbox.paypal.com/AdaptivePayments/PaymentDetails';
	
	
	$fields = array(
				'payKey'							=> $_SESSION['pay_key'],
				'requestEnvelope.errorLanguage' 	=> 'en_US',
			    );
	
	$fields_string = '';
	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	
	$headers = array('X-PAYPAL-SECURITY-USERID: '.$paypalUser.'',
					 'X-PAYPAL-SECURITY-PASSWORD: '.$paypalPassword.'',
					 'X-PAYPAL-SECURITY-SIGNATURE: '.$paypalSignature.'', 
					 'X-PAYPAL-REQUEST-DATA-FORMAT: NV',
					 'X-PAYPAL-RESPONSE-DATA-FORMAT: NV',
					 'X-PAYPAL-APPLICATION-ID: '.$paypalAppId.'');
					 
	//open connection
	$ch = curl_init();
	
	//set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	//curl_setopt($ch, CURLOPT_SSLVERSION,2.1);
	
	//execute post
	$res = curl_exec($ch);
	
	$res_arr = explode("&",$res); //echo "<pre>"; //print_r($res_arr); exit;	
	
	$ack = explode("=",$res_arr[19]);
	
	if($ack[1] == 'COMPLETED')
	{


         $user_id = wp_insert_user($userdata); 


         foreach($user_meta as $key => $value) {
             update_user_meta( $user_id, $key, $value );
          }




	     $code = sha1( $user_id . time() );    
         global $wpdb;  
         
        $wpdb->update( 
			'cp_users', 
			array( 
				'user_activation_key' => $code	// string
				
			), 
			array( 'ID' => $user_id ), 
			array( 
				'%s'	// value1
				
			) 
        );
        
        $activation_link = add_query_arg( array( 'key' => $code, 'user' => $user_id ), get_permalink(16093)); 

           wp_mail( $email, 'User Activation', 'Activation link : ' . $activation_link );
           
       
       $msg ='User Register successfully.';

       $date = date('Y-m-d');

       $mem_id = $user_meta['membership_id'];

       $get_no_of_days = $wpdb->get_results("select * from cp_gmgt_membershiptype where membership_id=".$mem_id);

       $days = $get_no_of_days[0]->membership_length_id;

       //echo date('Y-m-d', strtotime($Date. ' + 1 days'));

       $end_date = date('Y-m-d', strtotime($Date. ' + '.$days.'days'));




       //insert data in payment cp_Gmgt_membership_payment table

		    $wpdb->insert('cp_Gmgt_membership_payment', array(
		    'member_id' => $user_id,
		    'membership_id' => $mem_id,
		    'membership_amount' => $amount, 
		    'paid_amount' => $amount,
		    'payment_status' =>'Paid',
		    'membership_status' =>'continue',
		    'created_date' => $date,
		    'created_by' => $user_id,
		    'start_date' =>	$date,
		    'end_date' => $end_date  // ... and so on
		));
           
        if($wpdb->insert_id){
			$_SESSION ['success'] = "User registered successfully. You will receive the activation link and once you activate it you will able to login on website."; 
			header("Location: ".BASE_PATH."/registration/?id=".$user_id."#tabs-3");
			die();
		}

	 
	}
	else
	{
        // $msg ='User Not Register Error in payment.';
		$_SESSION ['error'] = "User Not Register Error in payment.";
	}

 
?>
  
<?php get_header(); ?>
<?php //topfit_mikado_get_title(); ?>
<div class="mkd-full-width">
		<div class="mkd-full-width-inner">
			  
         <div id="msg" class="alignleft1"><?php echo $msg; ?></div>
       </div>
 </div>
  
<?php get_footer(); ?>