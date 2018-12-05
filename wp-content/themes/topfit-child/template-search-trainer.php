<?php
/*
Template Name:Search trainer 
 
*/
 
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document).ready(function(){
jQuery('#trainer_type').on('change',function(){ 
		var trainer_type = jQuery(this).val();
		//alert(trainer_type);
		jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data:'trainer_type='+trainer_type+"&action=get_search_option",
				 success:function(html){ 
					 //alert(html);
					 jQuery('#main_search_option').html(html); 
					
				 }
				}); 
	});


 
  
});
</script>

  
<?php get_header(); ?>
<?php topfit_mikado_get_title(); ?>
<div class="mkd-full-width">
		<div class="mkd-full-width-inner">
		 
		 <table border="1" style="border-collapse: collapse; width: 50%">
		 <tr>
		 <td>Trainer Type</td>
		 <td>
		 	<select name="trainer_type" id="trainer_type">
				<option value="">Select Trainer Type</option>
				<option value="personal">Personal Trainer</option>
				<option value="remote">Remote Trainer</option>
			</select>
		 </td>	
		 </tr>
		 </table>
		 <div id="main_search_option"></div> 
		  <div id="trainer_list"></div>  
         
       </div>
 </div>
  
<?php get_footer(); ?>