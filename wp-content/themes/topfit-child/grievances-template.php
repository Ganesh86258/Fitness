<?php
/*
Template Name:Grievances
 
*/
 
?>
 <style type="text/css">
 	table td, table th {
    text-align: left !important;
}

 </style>
<script>
  var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
  jQuery(document).ready(function(){
  	alert("gfgfg");
  jQuery("#btnsumnitgrievnces").click(function(){

   alert("hi");
  
    });

	 
  });
</script>
 
<?php get_header(); ?>
<?php //topfit_mikado_get_title(); ?>
<div class="mkd-full-width">
		<div class="mkd-full-width-inner">
			  <table width="50%" border="0">
			  <tr>
			    <td >Name</td>
			    <td ><input type="text" name="title" /></td>
			  </tr>
			  <tr>
			    <td>Description</td>
			    <td><textarea name="description" rows="5" cols="40" ></textarea></td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><button type="submit" name="btnsumnitgrievnces" id="btnsumnitgrievnces"  >Submit</button></td>
			  </tr>
 			</table>
 			

       </div>
 </div>
  
<?php get_footer(); ?>