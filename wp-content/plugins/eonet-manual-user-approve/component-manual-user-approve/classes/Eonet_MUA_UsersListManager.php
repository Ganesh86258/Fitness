<?php

namespace ComponentManualUserApprove\classes;


use ComponentManualUserApprove\EonetManualUserApprove;

if ( ! defined('ABSPATH') ) die('Forbidden');

/**
 * Manager of the users list in the backend
 *
 * Class Eonet_MUA_UsersListManager
 *
 * @package ComponentManualUserApprove
 */
class Eonet_MUA_UsersListManager {

	public function __construct() {

		// -------------------- ACTIONS & FILTERS --------------------
		add_action( 'load-users.php', array( $this, 'trigger_query_actions' ) );
		add_action( 'admin_notices', array( $this, 'display_admin_notices' ), 99 );

		// Functions about users listing
		add_action( 'restrict_manage_users', array($this, 'add_status_filter') );
		add_action( 'admin_footer-users.php', array( $this, 'add_bulk_actions' ) );
		add_action( 'load-users.php', array( $this, 'trigger_bulk_action' ) );

		// Handle the status field in the profile page of users in backend
		add_action( 'show_user_profile', array( $this, 'render_profile_field' ) );
		add_action( 'edit_user_profile', array( $this, 'render_profile_field' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_profile_field' ) );
		add_filter( 'user_row_actions', array( $this, 'ceate_quick_links' ), 10, 2 );
		add_filter( 'manage_users_columns', array( $this, 'add_column_head' ) );
		add_filter( 'manage_users_custom_column', array( $this, 'add_column_cell' ), 10, 3 );
		add_filter( 'pre_get_users', array($this, 'filter_users_by_approval_status') );

		// BuddyPress members page override
		add_action('bp_signups_admin_load', array($this, 'bp_alert'));

	}

	/**
     * Add a custom message for the bp-signup page
     *
     */
	public function bp_alert()
	{
	    $message = __('<b>Watch out!</b> You are using the Eonet manual user approval plugin. This page regards BuddyPress pending registrations, which is different and not used with this plugin as the activation email is never sent. Thus not useful. <b>Please use the "All" tab to approve or deny users</b>.', 'eonet-manual-user-approve');
	    echo '<div class="notice notice-warning is-dismissible"><p>'. $message . '</p></div>';
	}

	/**
	 * Create two quick links Approve and Deny for each user in the users list
	 *
	 * @param $actions
	 * @param $user
	 *
     * @throws \Exception
     *
	 * @return array
	 */
	public function ceate_quick_links( $actions, $user ) {

		$user_manager = new Eonet_MUA_UserManager($user);

		if ( ! $user_manager->can_status_be_changed_by(get_current_user_id()))
			return $actions;

		
		$approve_link = add_query_arg( array( 'action' => 'approve', 'user' => $user->ID ) );
		$approve_link = remove_query_arg( array( 'new_role' ), $approve_link );
		$approve_link = wp_nonce_url( $approve_link, 'eonet_mua_change_status' );

		$deny_link = add_query_arg( array( 'action' => 'deny', 'user' => $user->ID ) );
		$deny_link = remove_query_arg( array( 'new_role' ), $deny_link );
		$deny_link = wp_nonce_url( $deny_link, 'eonet_mua_change_status' );

		$approve_action = '<a style="color:#006505" href="' . esc_url( $approve_link ) . '">' . _x( 'Approve', 'The action on users list page', 'eonet-manual-user-approve' ) . '</a>';
		$deny_action = '<a style="color:#d98500" href="' . esc_url( $deny_link ) . '">' . _x( 'Deny', 'The action on users list page', 'eonet-manual-user-approve' ) . '</a>';


		if($user_manager->is_pending() || $user_manager->is_denied())
			$actions['eonet_mua_approve_action'] = $approve_action;

		if($user_manager->is_pending() || $user_manager->is_approved())
			$actions['eonet_mua_deny_action'] = $deny_action;

		return $actions;
	}


	/**
	 * Trigger the action query and check if some users have been approved or denied
	 */
	public function trigger_query_actions() {

		$action  = isset( $_REQUEST['action'] ) ? sanitize_key($_REQUEST['action']) : false;
		$mode    = isset( $_POST['mode'] ) ? $_POST['mode'] : false;

		// If this is a multisite, bulk request, stop now!
		if ( 'list' == $mode ) {
			return;
		}

		if ( ! empty( $action ) && in_array( $action, array( 'approve', 'deny' ) ) && !isset( $_GET['new_role'] ) ) {

			check_admin_referer( 'eonet_mua_change_status' );


			//$redirect = wp_get_referer();
			$redirect = admin_url( 'users.php' );

			$status = $action;
			$user = absint( $_GET['user'] );

			$user_manager = new Eonet_MUA_UserManager($user);

			if ( $status == 'approve' ) {
				$user_manager->approve();
				$redirect = add_query_arg( array( 'approved' => 1 ), $redirect );
			} else {
				$user_manager->deny();
				$redirect = add_query_arg( array( 'denied' => 1 ), $redirect );
			}

			wp_redirect( $redirect );
			exit;
		}
	}

	/**
	 * Display a notice to admin if some users have been approved or denied
	 */
	public function display_admin_notices() {
		$screen = get_current_screen();

		if ( $screen->id != 'users' ) {
			return;
		}

		$message = null;

		$users_denied = (isset( $_GET['denied'] ) && is_numeric($_GET['denied'])) ? absint($_GET['denied']) : null;
		$users_approved = (isset( $_GET['approved'] ) && is_numeric($_GET['approved'])) ? absint($_GET['approved']) : null;

		if ( $users_approved ) {
			$message = sprintf( _n( 'User approved.', '%s users approved.', $users_approved, 'eonet-manual-user-approve' ), $users_approved );
		} else if( $users_denied ){
			$message = sprintf( _n( 'User denied.', '%s users denied.', $users_denied, 'eonet-manual-user-approve' ), $users_denied );
		}

		if ( !empty( $message ) ) {
			echo '<div id="user-approvation-result" class="notice notice-success is-dismissible"><p><strong>' . $message . '</strong></p></div>';
		}
	}

	/**
	 * Add the column header for the status column
	 *
	 * @param array $columns
	 * @return array
	 */
	public function add_column_head( $columns ) {
		$the_columns['eonet_mua_user_status'] = __( 'Status', 'eonet-manual-user-approve' );

		$newcol = array_slice( $columns, 0, -1 );
		$newcol = array_merge( $newcol, $the_columns );
		$columns = array_merge( $newcol, array_slice( $columns, 1 ) );

		return $columns;
	}

	/**
	 * Set the status value for each user in the users list
	 *
	 * @param string $val
	 * @param string $column_name
	 * @param int $user_id
     *
     * @throws \Exception
     *
	 * @return string
	 */
	public function add_column_cell( $val, $column_name, $user_id ) {
		if ( $column_name == 'eonet_mua_user_status') {

				$user_manager = new Eonet_MUA_UserManager($user_id);
				$status = $user_manager->get_user_status();

				return Eonet_MUA_UserManager::get_status_label($status);

		}

		return $val;
	}

	public function add_status_filter($which) {

		$id = 'bottom' === $which ? 'eonet_mua_approval_status2' : 'eonet_mua_approval_status';
		$filter_value = (isset($_GET[$id]) && !empty($_GET[$id])) ? $_GET[$id] : false;

		$approved_label = Eonet_MUA_UserManager::get_status_label(Eonet_MUA_UserManager::APPROVED);
		$pending_label = Eonet_MUA_UserManager::get_status_label(Eonet_MUA_UserManager::PENDING);
		$denied_label = Eonet_MUA_UserManager::get_status_label(Eonet_MUA_UserManager::DENIED);

		?>
		</div><!-- .alignleft.actions opened in extra_tablenav() - class-wp-users-list-table.php:259 -->
		<div class="alignleft actions">

		<label class="screen-reader-text" for="<?php echo $id ?>"><?php _e( 'All statuses', 'eonet-manual-user-approve' ) ?></label>
		<select name="<?php echo $id ?>" id="<?php echo $id ?>">
			<option value=""><?php _e( 'All approval statuses', 'eonet-manual-user-approve' ) ?></option>

			<?php
			echo '<option value="approved" '.selected( 'approved', $filter_value ).'>'.$approved_label.'</option>';
			echo '<option value="pending" '.selected( 'pending', $filter_value ).'>'.$pending_label.'</option>';
			echo '<option value="denied" '.selected( 'denied', $filter_value ).'>'.$denied_label.'</option>';
			?>
		</select>
		<?php
		submit_button( __( 'Filter', 'eonet-manual-user-approve' ), 'button', 'eonet_mua_filter_action', false );

	}

	/**
	 * Fire the filter selction and show only the users with specified approval status
	 *
	 * @param $query
	 */
	public function filter_users_by_approval_status( $query ) {

		$eonet_mua_filter_action = (isset($_REQUEST['eonet_mua_filter_action']) && !empty($_REQUEST['eonet_mua_filter_action'])) ? $_REQUEST['eonet_mua_filter_action'] : false;
		$eonet_mua_approval_status = (isset($_REQUEST['eonet_mua_approval_status']) && !empty($_REQUEST['eonet_mua_approval_status'])) ? $_REQUEST['eonet_mua_approval_status'] : false;
		$eonet_mua_approval_status2 = (isset($_REQUEST['eonet_mua_approval_status2']) && !empty($_REQUEST['eonet_mua_approval_status2'])) ? $_REQUEST['eonet_mua_approval_status2'] : false;

		if( !$eonet_mua_filter_action || (!$eonet_mua_approval_status && !$eonet_mua_approval_status2))
			return;

		$status = null;
		if ( $eonet_mua_approval_status2 ) {
			$status = sanitize_text_field($eonet_mua_approval_status2);
		} elseif ( $eonet_mua_approval_status ) {
			$status = sanitize_text_field($eonet_mua_approval_status);
		}

		switch($status) {
			case 'approved':
				$status = Eonet_MUA_UserManager::APPROVED;
				break;
			case 'pending':
				$status = Eonet_MUA_UserManager::PENDING;
				break;
			case 'denied':
				$status = Eonet_MUA_UserManager::DENIED;
				break;
			default:
				return;
		}


		$meta_query = array(
			array(
				'key' => 'eonet_mua_status',
				'value' => $status,
				'compare' => '='
			)

		);

		if($status == Eonet_MUA_UserManager::APPROVED) {
			$meta_query = array(
				'relation' => 'OR',
				array(
					'key' => 'eonet_mua_status',
					'compare' => 'NOT EXISTS', // works!
					'value' => '' // This is ignored, but is necessary...
				),
				array(
					'key' => 'eonet_mua_status',
					'value' => Eonet_MUA_UserManager::APPROVED
				)
			);
		}

		$query->set( 'meta_query', $meta_query );


	}


	/**
	 * Seems that doesn't exists a properaction or filter that allow to add custom bulk actions, so this function add them
     * in the select form at runtime, using javascript
     *
     */
	public function add_bulk_actions() {

		if( !Eonet_MUA_UserManager::is_user_allowed_to_change_status())
			return;

		?>

		<script type="text/javascript">
	        jQuery(document).ready(function() {
	            jQuery('<option>').val('approve').text('<?php _e('Approve', 'eonet-manual-user-approve'); ?>').appendTo("select[name='action']");
	            jQuery('<option>').val('approve').text('<?php _e('Approve', 'eonet-manual-user-approve'); ?>').appendTo("select[name='action2']");

	            jQuery('<option>').val('deny').text('<?php _e('Deny', 'eonet-manual-user-approve'); ?>').appendTo("select[name='action']");
	            jQuery('<option>').val('deny').text('<?php _e('Deny', 'eonet-manual-user-approve'); ?>').appendTo("select[name='action2']");
	        });
	    </script>
		<?php
	}


	/**
	 * Trigger the bulk action approvation
     */
    public function trigger_bulk_action() {

		$wp_list_table = _get_list_table('WP_Users_List_Table');
		$action = $wp_list_table->current_action();

		$redirect = 'users.php';

		//Check if the action is under the scope of this unction
		if ( $action != 'approve' && $action != 'deny' )
			return;

		//Check if the current user has permissions to change approvation statuses
		if( !Eonet_MUA_UserManager::is_user_allowed_to_change_status())
			throw new \Exception('You have not enough permissions to perform a bulk action on users approval status');


		if ( empty($_REQUEST['users']) ) {
			wp_redirect($redirect);
			exit();
		}

		if($action == 'approve') {
	        $status = Eonet_MUA_UserManager::APPROVED;
	        $query_arg = 'approved';
        } else {
            $status = Eonet_MUA_UserManager::DENIED;
            $query_arg = 'denied';
        }
	               

		$userids = $_REQUEST['users'];

		$c = 0;
		foreach ( $userids as $id ) {
			$id = (int) $id;

			$user_manager = new Eonet_MUA_UserManager($id);

			//For each user, check if the current user can change him status
			if(! $user_manager->can_status_be_changed_by(get_current_user_id()))
				continue;

			$user_manager->save_status($status);

			$c++;
		}
	
		wp_redirect(add_query_arg($query_arg, $c, $redirect));
		exit();
	
	}

	/**
     * Render the field Status in the user profile, in backend
     *
	 * @param $user
     *
     * @throws \Exception
     */
	public function render_profile_field( $user ) {

		$user_manager = new Eonet_MUA_UserManager($user);

		//If the current user can't change status of the user displayed, then return
		if ( !$user_manager->can_status_be_changed_by(get_current_user_id()) )
			return;

		$user_status = $user_manager->get_user_status();
		?>
		<table class="form-table">
			<tr>
				<th><label for="eonet_mua_user_status"><?php _e( 'Approval Status', 'eonet-manual-user-approve' ); ?></label>
				</th>
				<td>
					<select id="eonet_mua_user_status" name="eonet_mua_user_status">
						<?php
						$available_statuses = array( Eonet_MUA_UserManager::APPROVED, Eonet_MUA_UserManager::PENDING, Eonet_MUA_UserManager::DENIED );
						foreach (  $available_statuses as $status ) : ?>
							<option
								value="<?php echo esc_attr( $status ); ?>"<?php selected( $status, $user_status ); ?>><?php echo esc_html( Eonet_MUA_UserManager::get_status_label($status) ); ?></option>
						<?php endforeach; ?>
					</select>

					<span class="description"><?php _e( 'If user has access to sign in or not.', 'eonet-manual-user-approve' ); ?></span>
				</td>
			</tr>
		</table>
	<?php
	}


	/**
	 * Update the profile field Status in the user profile, in backend
	 *
	 * @param $user_id
     *
     * @throws \Exception
	 *
	 * @return bool
	 */
	public function save_profile_field( $user_id ) {

		$user_manager = new Eonet_MUA_UserManager($user_id);

		if ( !current_user_can( 'edit_users', $user_id ) || !$user_manager->can_status_be_changed_by(get_current_user_id())) {
			return false;
		}

		if ( empty( $_POST['eonet_mua_user_status'] ) && !Eonet_MUA_UserManager::validate_status($_POST['eonet_mua_user_status']) )
			return false;

		$new_status = $_POST['eonet_mua_user_status'];

		$user_manager->save_status($new_status);

	}


}
