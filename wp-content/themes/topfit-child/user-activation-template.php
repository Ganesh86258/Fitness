<?php
/*
Template Name:user-activation
 
*/
?>
<?php get_header(); ?>
<?php //topfit_mikado_get_title(); ?>
<div class="mkd-full-width">
		<div class="mkd-full-width-inner">
		<?php
         $result =  $wpdb->update( 
				'cp_users', 
				array( 
					'user_status' => 0	// string
					
				), 
				array( 'ID' => $_GET['user'],'user_activation_key'=>$_GET['key']), 
				array( 
					'%d'	// value2
				)  
			);

         if($result == 1)
         {
         	?>
         	<div class="mkd-full-width">
		      <div class="mkd-full-width-inner">
			  
                <div id="msg" class="alignleft1">User Acivated successfully.</div>
                <div class="alignleft1"><a href="<?php echo site_url(); ?>/
gym-management-login-page/">Click here to login</a></div>
             </div>
          </div>
         <?php
         }

		?>
       </div>
 </div>
  
<?php get_footer(); ?>

 


