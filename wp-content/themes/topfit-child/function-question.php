<?php 
	global $wpdb;
    $results=$wpdb->get_results("select * from cp_questions ORDER BY ques_display_order ASC"); 

    define('DESCRIPTIVE', '1');   
    define('TRUE_FALSE', '2');   
    define('MULTIPLE', '3');   
    define('YES_NO', '4');  
	define('SMALL_TEXT', '5'); 

?>

<?php 
/* 
 * For Questionnaire frontend 
 */
class Questionnaire {

	//return Question type
	public function getQuestionType($qtype_id){
		$type = '';
		switch($qtype_id){

		    case SMALL_TEXT:
				$type = 'text';
				break;
			case DESCRIPTIVE:
				$type = 'textarea';
				break;
			case TRUE_FALSE:
				$type = 'radio';
				break;
			case MULTIPLE:
				$type = 'checkbox';
				break;
			case YES_NO:
				$type = 'radio';
				break;
			default :
				$type = 'textarea';
		}
		return $type;
	}

	//return answers options html element
	public function _answerHtml($qtype_id, $ans_id, $label,$qid,$user_ques_answer){
      
		$type = $this->getQuestionType($qtype_id, $ans_id);
		
	    if($type == 'text'){
			
			echo "<input type=$type name='ques_$qid' id='ques_$qid' value='$user_ques_answer' >";

		}elseif($type == 'radio'){
		
			echo "<input type=$type name='ques_$qid' id='ques_$qid' value='$label' >$label</input>";
		
		}elseif($type == 'checkbox')
			echo "<input type=$type name='default_ans_$ans_id' id='default_ans_$ans_id' >$label</input>";
		else
			echo "<textarea cols=100 rows=5>$user_ques_answer</textarea>";	
	}
}

//Object for Questionnaire 
$obj = new Questionnaire; 
?>
<!-- Tab-3 content i.e. Questionnaire in frontend registration -->
<div id="tabs-3">
	
	<!-- first group of question start  -->	
	
	<div class="each-que" style="display:block;" id="first_ques_group" >
		<?php 
		
		  global $user_ID;

		  if(!empty($results)) :?>
			<?php foreach($results as $result) :?>
			<?php 
			
			$answers=$wpdb->get_results("SELECT * FROM cp_question_answers WHERE ques_id=$result->qid"); 

			// Fetching user's answer cp_ques_user_ans

			$user_ques_ans=$wpdb->get_results("SELECT * FROM cp_ques_user_ans WHERE ques_id=$result->qid AND user_id =$user_ID"); 

			$user_ques_answer = $user_ques_ans[0]->ques_ans; 

		 
						
			?>
			
			<div class="next-border-b" id="qid_"<?php echo $result->qid; ?> >
				<div class="question"><?php echo "$result->ques_display_order"; ?>.<?php echo "$result->question"; ?> </div>

				<?php if(!empty($answers)) : ?>
				<div class="answers">					
					<?php foreach($answers as $answer) :?>
						<div id="ans_"<?php echo $answer->id; ?> >
							<?php $obj->_answerHtml($result->qtype_id, $answer->id, $answer->ques_answer,$result->qid,$user_ques_answer); ?>
						</div>
					<?php endforeach; ?>
				</div>
				<?php else: ?>
					<div class="no-answers" style="border:0px solid red; margin-top:10; padding:0;">		<input type="textarea" cols="80" rows="1" name="input_ques_<?php echo $result->qid; ?>"  id="input_ques_<?php echo $result->qid; ?>" value="<?php echo $user_ques_answer; ?>"></textarea>
						<!-- <input type="button" name="btn_ques_<?php echo $result->qid; ?>" id="btn_ques_<?php echo $result->qid; ?>" value="Add" class="btnAdd"> -->
						<label id="label_input_ques_<?php echo $result->qid; ?>" ></label>
					</div>
					 
				<?php endif; ?>
				
			</div>
			</hr>
				
			<?php 
			
			if($result->ques_display_order==4){ break;  }
			
			endforeach; ?>




		<?php else: ?>
			<div class="next-border-b" id="no-questions" ?> >
				<?php _e('No Questions Found'); ?>
			</div>
		<?php endif; ?>

		<input type="button" id="next" name="next" class="nexttab btn btn-primary" value="Next1">

	</div>

	<!-- first group of questions ends  -->

	<!-- Second group of question start  -->

		<div class="each-que" id="second_ques_group" style="display:none;">
		<?php if(!empty($results)) :?>
			<?php foreach($results as $result) :
			
			if($result->ques_display_order > 4 && $result->ques_display_order <= 6){
			
			?>

			<?php $answers=$wpdb->get_results("SELECT * FROM cp_question_answers WHERE ques_id=$result->qid"); ?>
			
			<div class="next-border-b" id="qid_"<?php echo $result->qid; ?> >
				<div class="question"><?php echo "$result->ques_display_order"; ?>.<?php echo "$result->question"; ?> </div>

				<?php if(!empty($answers)) : ?>
				<div class="answers">					
					<?php foreach($answers as $answer) :?>
						<div id="ans_"<?php echo $answer->id; ?> >
							<?php $obj->_answerHtml($result->qtype_id, $answer->id, $answer->ques_answer,$result->qid,$user_ques_answer); ?>
						</div>
					<?php endforeach; ?>
				</div>
				<?php else: ?>
					<div class="no-answers" style="border:0px solid red; margin-top:10; padding:0;">		<input type="textarea" cols="80" rows="1" name="input_ques_<?php echo $result->qid; ?>"  id="input_ques_<?php echo $result->qid; ?>" ></textarea>
						<!-- <input type="button" name="btn_ques_<?php echo $result->qid; ?>" id="btn_ques_<?php echo $result->qid; ?>" value="Add" class="btnAdd"> -->
						<label id="label_input_ques_<?php echo $result->qid; ?>" ></label>
					</div>
					 
				<?php endif; ?>
				
			</div>
			</hr>
				
			<?php 
			
		    }
			
			endforeach; ?>




		<?php else: ?>
			<div class="next-border-b" id="no-questions" ?> >
				<?php _e('No Questions Found'); ?>
			</div>
		<?php endif; ?>
		<input type="button" id="back1" name="back1" class="nexttab btn btn-primary" value="Back-1">
		<input type="button" id="next2" name="next2" class="nexttab btn btn-primary" value="Next-2">

	</div>

	<!-- Second group of question ends  -->

	<!-- third group of question start  -->

	<div class="each-que" id="third_ques_group" style="display:none;">
		<?php if(!empty($results)) :?>
			<?php foreach($results as $result) :
			
			if($result->ques_display_order > 6 && $result->ques_display_order <= 16){
			
			?>

			<?php $answers=$wpdb->get_results("SELECT * FROM cp_question_answers WHERE ques_id=$result->qid"); ?>
			
			<div class="next-border-b" id="qid_<?php echo $result->qid; ?>" 
			
			<?php if($result->ques_display_order==7){ ?> style="display:block;" <?php } else { ?>   
			 style="display:none;"
			 <?php }?> 
			   			   
			   >
				<div class="question"><?php echo "$result->ques_display_order"; ?>.<?php echo "$result->question"; ?> </div>

				<?php if(!empty($answers)) : ?>
				<div class="answers">					
					<?php foreach($answers as $answer) :?>
						<div id="ans_"<?php echo $answer->id; ?> >
							<?php $obj->_answerHtml($result->qtype_id, $answer->id, $answer->ques_answer,$result->qid,$user_ques_answer); ?>
						</div>
					<?php endforeach; ?>
				</div>
				<?php else: ?>
					<div class="no-answers" style="border:0px solid red; margin-top:10; padding:0;">		<input type="textarea" cols="80" rows="1" name="input_ques_<?php echo $result->qid; ?>"  id="input_ques_<?php echo $result->qid; ?>" ></textarea>
						<!-- <input type="button" name="btn_ques_<?php echo $result->qid; ?>" id="btn_ques_<?php echo $result->qid; ?>" value="Add" class="btnAdd"> -->
						<label id="label_input_ques_<?php echo $result->qid; ?>" ></label>
					</div>
					 
				<?php endif; ?>
				
			</div>

			</hr>
				
			<?php 
			
		    }
			
			endforeach; ?>




		<?php else: ?>
			<div class="next-border-b" id="no-questions" ?> >
				<?php _e('No Questions Found'); ?>
			</div>
		<?php endif; ?>
		<input type="button" id="back2" name="back2" class="nexttab btn btn-primary" value="Back2">
		<input type="button" id="next3" name="next3" class="nexttab btn btn-primary" value="Next3">

	</div>

	<!-- third group of question ends  -->

	<!-- <div class="navigation-n-p">
		<a id="prev" href="#" >Prev</a>  
		<a id="next" href="#" onclick="next()">Next</a>  
	</div> -->
	<!-- <input type="button" id="next" name="next" class="nexttab btn btn-primary" value="Next"> -->
</div>

<!-- End of Tab-3 content -->
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";


	// 26th Nov

	jQuery(document).ready(function() { 

		jQuery(".btnAdd").click(function(){

			var btn_id = this.id; 
			var ques_id  = btn_id.slice(-2);
			var input_id =  'input_ques_'+ques_id;		
			
			var input_ques_answer = jQuery("#"+input_id).val();

			//user registration form validation
			if (!questionnaire_validation(input_id))	
				return;	
			
			if(ques_id){

				jQuery.ajax({ 
					type:'POST', 
					url:ajaxurl,
					data:'input_ques_answer='+input_ques_answer+'&ques_id='+ques_id+"&action=add_ques_answ",
					success:function(html){
                        
						alert('Inside success');

						jQuery("#first_ques_group").css({"display":"none"});
						jQuery("#second_ques_group").css({"display":"block"});

						//jQuery("#label_"+input_id).html(html);
						//jQuery("#label_"+input_id).css({"color": "green"});

						//jQuery('#City').html(html); gree

					}
				}); 

			}else{ 
		
			} 
		});

		// 27th Nov 2018 

		// step -1 process

		jQuery("#next").click(function(){

			var btn_id = this.id; 
			var ques_id  = btn_id.slice(-2);
			var input_id =  'input_ques_'+ques_id;		
			
			//var input_ques_answer = jQuery("#"+input_id).val();

			var ques_16_ans = jQuery("#input_ques_16").val();
			var ques_17_ans = jQuery("#input_ques_17").val();
			var ques_18_ans = jQuery("#input_ques_18").val();
			var ques_19_ans = jQuery("#input_ques_19").val();

			var frmData ='ques_16_ans='+ques_16_ans+'&ques_17_ans='+ques_17_ans+'&ques_18_ans='+ques_18_ans+'&ques_19_ans='+ques_19_ans+'&ques_id='+ques_id+'&action=add_ques_answ';

			//user registration form validation
			if(!questionnaire_validation('input_ques_16') || !questionnaire_validation('input_ques_17') || !questionnaire_validation('input_ques_18'))	
				return;	


		
				jQuery.ajax({ 
					type:'POST', 
					url:ajaxurl,
					data:frmData,
					success:function(html){ 
					
					alert(html);

					jQuery("#first_ques_group").css({"display":"none"});
					jQuery("#second_ques_group").css({"display":"block"});
					
					  //alert('success html');

					// jQuery("#label_"+input_id).html(html);
					 //jQuery("#label_"+input_id).css({"color": "green"});

					 //jQuery('#City').html(html); gree

					}
				}); 




		});

		// step 2 process


		jQuery("#back1").click(function(){

			jQuery("#first_ques_group").css({"display":"block"});
			jQuery("#second_ques_group").css({"display":"none"});

		});

		jQuery("#next2").click(function(){

			//var input_ques_answer = jQuery("#"+input_id).val();
			
			//alert(jQuery("#default_ans_38").val());
			//alert(jQuery("#default_ans_39").val());

			var ques_20_38_ans = jQuery("#default_ans_38").prop('checked')?'yes':'no';
			var ques_20_39_ans = jQuery("#default_ans_39").prop('checked')?'yes':'no';
			var ques_20_55_ans = jQuery("#default_ans_55").prop('checked')?'yes':'no';
			var ques_20_56_ans = jQuery("#default_ans_56").prop('checked')?'yes':'no';
			var ques_20_57_ans = jQuery("#default_ans_57").prop('checked')?'yes':'no';
			var ques_20_58_ans = jQuery("#default_ans_58").prop('checked')?'yes':'no';
			var ques_20_59_ans = jQuery("#default_ans_59").prop('checked')?'yes':'no';
			var ques_20_60_ans = jQuery("#default_ans_60").prop('checked')?'yes':'no';
			

			var ques_20_ans = '38='+ques_20_38_ans+',39='+ques_20_39_ans+',55='+ques_20_55_ans+',56='+ques_20_56_ans+',57='+ques_20_57_ans+',58='+ques_20_58_ans+',59='+ques_20_59_ans+',60='+ques_20_60_ans;

			var ques_21_ans = jQuery("#default_ans_40").prop('checked')?'yes':'no';

			var frmData ='ques_20_ans='+ques_20_ans+'&ques_21_ans='+ques_21_ans+'&action=add_ques_answ_2';

			//user registration form validation
			//if(!questionnaire_validation('input_ques_20') || !questionnaire_validation('input_ques_21'))	
			//	return;	
			
			jQuery.ajax({ 
				type:'POST', 
				url:ajaxurl,
				data:frmData,
				success:function(html){ 					 
					jQuery("#second_ques_group").css({"display":"none"});
					jQuery("#third_ques_group").css({"display":"block"});
				
				}
			}); 


			

		});

		jQuery('input[type=radio][name=ques_22]').change(function() {

			var p_trainer = jQuery('input[name=ques_22]:checked').val();

			if(p_trainer=='Yes'){
				jQuery("#qid_23").css({"display":"block"});
				jQuery("#qid_24").css({"display":"none"});
			}

			if(p_trainer=='No'){
				jQuery("#qid_24").css({"display":"block"});
				jQuery("#qid_23").css({"display":"none"});
			}

		});


		jQuery('input[type=radio][name=ques_24]').change(function() {

			var past_trainer = jQuery('input[name=ques_24]:checked').val();

			if(past_trainer=='Yes'){

				jQuery("#qid_25").css({"display":"block"});
				jQuery("#qid_26").css({"display":"none"});
			}

			if(past_trainer=='No'){
				jQuery("#qid_26").css({"display":"block"});
				jQuery("#qid_25").css({"display":"none"});
			}

		});


		// 27 th Nov 2018 

		// 28 th Nov 2018

		jQuery('input[type=radio][name=ques_26]').change(function() {

			var is_injured = jQuery('input[name=ques_26]:checked').val();

			if(is_injured=='Yes'){
				jQuery("#qid_27").css({"display":"block"});
			}

			if(is_injured=='No'){
				jQuery("#qid_27").css({"display":"none"});
			}

		});


		jQuery( function(){
		
			jQuery("#ques_27").datepicker({
				dateFormat: "mm-dd-yyyy"
			});

		});

		// 28th Nov 2018

	});



	function questionnaire_validation(input_id){

		//var input_ques_answer =jQuery("#input_ques_16").val();

		var input_ques_answer = jQuery("#"+input_id).val();

		if(input_ques_answer.length < 1){
		
			jQuery("#"+input_id).css({"border": "1px solid red"});
			jQuery("#"+input_id).css({"border": "1px solid red"});
			jQuery("#label_"+input_id).html("Please fill data in textbox") 
			jQuery("#label_"+input_id).css({"color": "red"});

			return false;

		}else{
			
			jQuery("#"+input_id).css({"border": "1px solid #dddddd"});
			jQuery("#label_"+input_id).empty();
			return true;
		}	
	
	}

</script>

<?php


function add_ques_ans(){
   
   /*
   global $wpdb; 

   $first_name = $wpdb->escape(trim($_POST['first_name']));
   $Phone_number = $wpdb->escape(trim($_POST['Phone_number']));
   $email = $wpdb->escape(trim($_POST['email']));
   $password1 = $wpdb->escape(trim($_POST['password1']));
   $password2 = $wpdb->escape(trim($_POST['password2']));
   $Country = $wpdb->escape(trim($_POST['Country']));
   $State = $wpdb->escape(trim($_POST['State']));
   $City = $wpdb->escape(trim($_POST['City']));
   $Sport = $wpdb->escape(trim($_POST['Sport']));
   $cstatus = $wpdb->escape(trim($_POST['cstatus']));
   $username = $wpdb->escape(trim($_POST['member_name']));
   $membership_id = $wpdb->escape(trim($_POST['membership_id']));
   // $time_slot = $wpdb->escape(trim($_POST['time_slot']));
   // $trainer_type = $wpdb->escape(trim($_POST['trainer_type']));

  // echo $password1;

   $userdata = array(
	 'user_login' => $first_name,
	 'user_pass' => sanitize_text_field($_POST['password1']), 
	 'user_email' => $email,
	 'role' => 'member'
	 );

   $metas = array( 
		'Phone_number'   => $Phone_number,
		'Country' => $Country, 
		'State'  => $State ,
		'city'       => $City ,
		'Sport'     => $Sport,
		'cstatus'       => $cstatus, 
		'membership_id' => $membership_id
	);

    if($membership_id == FREE_MEMBERSHIP) { // For Free Trial Membership

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
			array( '%s') 
		);

		$activation_link = add_query_arg( array( 'key' => $code, 'user' => $user_id ), get_permalink(16093)); 

		$mail_sent = wp_mail( $email, 'User Activation', 'Activation link : ' . $activation_link );
		
		if($mail_sent){

			if($user_id){
				$result['error'] = false;
				$result['message'] = "User registered successfully You will receive the activation link and once you activate it you will able log in on website";
				$result['user_id'] = $user_id;
				
			} else {
				$result['error'] = true;
				$result['message'] = "Problem in adding user in system.";
			}

		}else{
		
			$result['error'] = true;
			$result['message'] = "Problem in Mail sending..";
		}
		//$result['redirect_to'] = get_home_url().'/registration';
		$result['membership'] = $membership_id;
		echo json_encode($result);
		die();
		   
    } else {
     

	}

	*/

	echo "Inside add ques ans"; 

    die();

}

add_action('wp_ajax_add_ques_ans', 'add_ques_ans');
add_action('wp_ajax_nopriv_add_ques_ans', 'add_ques_ans');

