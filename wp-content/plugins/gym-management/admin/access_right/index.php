<?php 
// This is Class at admin side!!!!!!!!!
$active_tab = isset($_GET['tab'])?$_GET['tab']:'member';
	?>
<!-- View Popup Code -->	
<div class="popup-bg">
    <div class="overlay-content">
    	<div class="notice_content"></div>    
    </div> 
</div>	
<div class="page-inner" style="min-height:1631px !important">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'gmgt_system_logo', 'gym_mgt'); ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option('gmgt_system_name','gym_mgt');?></h3>
	</div>
	
<div  id="main-wrapper" class="notice_page">
	<div class="panel panel-white">
					<div class="panel-body">    

	<h2 class="nav-tab-wrapper">
    	<a href="?page=gmgt_access_right&tab=member" class="nav-tab <?php echo $active_tab == 'member' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Member', 'gym_mgt'); ?></a>

    	<a href="?page=gmgt_access_right&tab=staff_member" class="nav-tab <?php echo $active_tab == 'staff_member' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Staff Member', 'gym_mgt'); ?></a> 
 
     <a href="?page=gmgt_access_right&tab=accountant" class="nav-tab <?php echo $active_tab == 'accountant' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Accountant', 'gym_mgt'); ?></a>    
    </h2>
    <?php
	if($active_tab == 'member')
	{
		require_once GMS_PLUGIN_DIR. '/admin/access_right/member.php';
	}	 
	elseif($active_tab == 'staff_member')
	{
		require_once GMS_PLUGIN_DIR. '/admin/access_right/staff_member.php';
	}	 
	elseif($active_tab == 'accountant')
	{
		require_once GMS_PLUGIN_DIR. '/admin/access_right/accountant.php';
	}	
	 ?>
	 	</div>
	 	</div>
	 </div>
</div>
<?php ?>