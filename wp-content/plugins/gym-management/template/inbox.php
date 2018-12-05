<?php 
//Subject
//var_dump($school_obj->subject);

?>
<div class="mailbox-content">
<div class="table-responsive">
 	<table class="table">
 		<thead>
 			<tr>
 				<!--  <th class="hidden-xs" colspan="1">
                	<span>
                		<div class="checker">
                			<span><input type="checkbox" class="check-mail-all"></span>
                		</div>
                	</span>
                </th> -->
                <th class="text-right" colspan="5">
               <?php $message = gmgt_count_inbox_item(get_current_user_id());
              // var_dump($message);
 		$max = 10;
 		if(isset($_GET['pg'])){
 			$p = $_GET['pg'];
 		}else{
 			$p = 1;
 		}
 		 
 		$limit = ($p - 1) * $max;
 		$prev = $p - 1;
 		$next = $p + 1;
 		$limits = (int)($p - 1) * $max;
 		$totlal_message =count($message);
 		$totlal_message = ceil($totlal_message / $max);
 		$lpm1 = $totlal_message - 1;
 		$offest_value = ($p-1) * $max;
 		echo gmgt_inbox_pagination($totlal_message,$p,$lpm1,$prev,$next);?>
                </th>
 			</tr>
 		</thead>
 		<tbody>
 		<tr>
 			<!-- <td class="hidden-xs">
            	<span>&nbsp;</span>
            </td> -->
 			<th class="hidden-xs">
            	<span><?php _e('Message For','gym_mgt');?></span>
            </th>
            <th><?php _e('Subject','gym_mgt');?></th>
             <th>
                  <?php _e('Description','gym_mgt');?>
            </th>
            </tr>
 		<?php 
 		
 		
 		$message = gmgt_get_inbox_message(get_current_user_id(),$limit,$max);
 		
 		foreach($message as $msg)
 		{
 			?>
 			 <tr>
 			<!-- <td class="hidden-xs">
            	<span><div class="checker"><span class=""><input type="checkbox" class="checkbox-mail"></span></div></span>
            </td>
            -->
            <td><?php echo gym_get_display_name($msg->sender);//echo get_user_name_byid($msg->sender);?></td>
             <td>
                 <a href="?dashboard=user&page=message&tab=view_message&from=inbox&id=<?php echo $msg->message_id;?>"> <?php echo $msg->subject;?></a>
            </td>
            <td><?php echo $msg->message_body;?>
            </td>
            <td>
                <?php  echo  mysql2date('d M', $msg->date );?>
            </td>
            </tr>
 			<?php 
 		}
 		?>
 		
 		</tbody>
 	</table>
 	</div>
 </div>
 <?php ?>