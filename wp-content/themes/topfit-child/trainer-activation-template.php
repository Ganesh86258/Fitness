<?php
/*
Template Name:trainer-activation
 
*/
?>
<?php get_header(); ?>

<?php //topfit_mikado_get_title(); ?>
<div class="mkd-full-width">
		<div class="mkd-full-width-inner">
		<?php
   //       $result =  $wpdb->update( 
			// 	'cp_users', 
			// 	array( 
			// 		'user_status' => 1	// string
					
			// 	), 
			// 	array( 'ID' => $_GET['user'],'user_activation_key'=>$_GET['key']), 
			// 	array( 
			// 		'%d'	// value2
			// 	)  
			// );

		$myrows = $wpdb->get_results( "SELECT * FROM cp_users where user_activation_key='".$_GET['key']."' AND ID='".$_GET['user']."' " );
       
		$trainr_id = $myrows[0]->ID;
		 	

         if(isset($trainr_id) && $trainr_id != '')
         {
         	?>
         	<div class="mkd-full-width">
		      <div class="mkd-full-width-inner">
			  
                <div id="msg" class="alignleft1">Request has been sent to admin for approval</div>
                
             </div>
          </div>
         <?php
         }

		?>
       </div>
 </div>
  
<?php get_footer(); ?>

 


