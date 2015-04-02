<?php
require_once dirname ( __FILE__ ) . '/constants.php';
function glogin_page_handler($page) {
	switch ($page [0]) {
		case "forward" :
			print_r(GOOGLE_REDIRECT_URI);			
			require_once dirname ( __FILE__ ) . '/google_connect.php';
			break;
		case "login" :
			$_SESSION ['google_code'] = get_input ( 'code' );
			require_once dirname ( __FILE__ ) . '/google_connect.php';
			break;
		case "register" :
			print_r('came to reg pagehandler');
			google_register_user ();
			break;
		case "logout" :
			session_unset ();
			session_destroy ();
			logout ();
			break;
	}
}
function google_register_user() {
	global $CONFIG;
	
	// Get variables
	$elgg_username = $_SESSION ['google_username'];
	$elgg_password = $_SESSION ['google_password'];
	$elgg_email = $_SESSION ['google_email'];
	$elgg_name = $_SESSION ['google_name'];

	print("<br> $elgg_username <br>");
	print("<br> $elgg_password <br>");
	print("<br> $elgg_email <br>");
	print("<br> $elgg_name <br>");
	
	if (! $CONFIG->disable_registration) {
		try {
			$guid = register_user ( $elgg_username, $elgg_password, $elgg_name, $elgg_email, false, 0, '' );
			print_r ( $guid );
			if ($guid) {
				$newuser = get_entity ( $guid );
				set_user_validation_status ( $guid, true, 'email' );
				
				system_message ( sprintf ( elgg_echo ( "registerok" ), $CONFIG->sitename ) );
				
				login ( $newuser, false );
				forward ( REDIRECT_DASHBOARD );
			} else {
				register_error ( elgg_echo ( "registerbad" ) );
			}
		} catch ( RegistrationException $r ) {
			register_error ( $r->getMessage () );
		}
	} else {
		register_error ( elgg_echo ( 'registerdisabled' ) );
	}
}
