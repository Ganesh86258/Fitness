<?php

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

/**
 * @package appfbconnect
 * 
 * Example filters
 * 
 * Update this code as desired and copy it into your child theme's functions.php (preferred)
 * or make a copy of this file and add it to your /mu-plugins/ folder
 * 
 * @since 2.2.0
 */

/**
 * This filter will allow you to change where your login will return after login
 */
function my_appfbconnect_oathcallback( $oauthcallback ) {
	
	$oauthcallback = site_url( '/my-new-page/' );

	return $oauthcallback;
}
add_filter( 'appfbconnect_oathcallback', 'my_appfbconnect_oathcallback' );

/**
 * This filter will allow you to include additional fields that you 
 * want to pull from the Facebook user
 */
function my_appfbconnect_me_fields( $me_fields ) {
	
	$me_fields = 'name,email';

	return $me_fields;
}
add_filter( 'appfbconnect_me_fields', 'my_appfbconnect_me_fields' );


/**
* Stores user Photo URL on FB Auth via App.
*
* @param  int $user_id authenticated user ID.
* @return void
*/
function get_fb_profile_picture( $user_id = 0 ) {
	if( $user_id ) {
		$fb_id = get_user_meta( $user_id, 'appp_fb_id', true );
		if( $fb_id ) {
			$graph_api_url = sprintf( 'https://graph.facebook.com/%d/picture?fields=url&redirect=false&type=large', $fb_id );
			$json_response = file_get_contents( $graph_api_url );
			$data = json_decode( $json_response );
			if( $data ) {
				$profile_pic_url = $data->data->url;
				update_user_meta( $user_id, 'fb_profile_picture', $profile_pic_url );
			}
		}	
	}
}
add_action( 'appp_fb_loggedin', 'get_fb_profile_picture' );