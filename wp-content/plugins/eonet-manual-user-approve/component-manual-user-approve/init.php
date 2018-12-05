<?php
/**
 * Let's init the component properly :
 * We load the classes :
 */
if(defined('Eonet')) {

    add_action('plugins_loaded', 'eonet_component_init_mua');

    function eonet_component_init_mua()
    {

        // Classes to load :
        $component_classes = array(
            'ComponentManualUserApprove\EonetManualUserApprove',
            'ComponentManualUserApprove\classes\Eonet_MUA_Message',
            'ComponentManualUserApprove\classes\Eonet_MUA_Sender',
            'ComponentManualUserApprove\classes\Eonet_MUA_UserManager',
            'ComponentManualUserApprove\classes\Eonet_MUA_UsersListManager',
        );
        // Load them :
        foreach ($component_classes as $class) {
            eonet_autoload($class);
        }

        // Fire primary class !
	    eonet_manual_user_approve();

	    //Fire Sub Classes
	    new \ComponentManualUserApprove\classes\Eonet_MUA_UsersListManager();

        // Hook it
        do_action('eonet_component_after_init_mua');

    }

	if(!function_exists('eonet_manual_user_approve')) {
		/**
		 * Return the static instance of the class, in this way the class is instanced only one time and ae avoided actions doubled
		 *
		 * @return \ComponentManualUserApprove\EonetManualUserApprove
		 */
		function eonet_manual_user_approve() {
			return \ComponentManualUserApprove\EonetManualUserApprove::instance();
		}
	}
}
