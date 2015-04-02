<?php
require_once dirname ( __FILE__ ) . '/constants.php';

function fblogin_page_handler($page) {
	switch ($page[0]) {
		case "login" :
			$_SESSION ['FBRLH_' . 'state'] = get_input ( 'state' );
			require_once dirname ( __FILE__ ) . '/facebook.php';
			break;
		case "register":
			facebook_register_user();
			break;
		case "forward":
			require_once dirname ( __FILE__ ) . '/facebook.php';
			break;
		case "logout":
			session_unset();
			session_destroy();
			logout();
			break;
	}
}

function facebook_register_user() {
	global $CONFIG;
	
	// Get variables
	$elgg_username = $_SESSION['facebook_elgg_username'];
	$elgg_password = $_SESSION['facebook_elgg_password'];
	$elgg_email = $_SESSION['facebook_elgg_email'];
	$elgg_name = $_SESSION['facebook_fname'].$_SESSION ['facebook_lname'];

	$admin = get_input('admin');
	if (is_array($admin)) {
		$admin = $admin[0];
	}
	
	if (!$CONFIG->disable_registration) {
		try {
			$guid = register_user($elgg_username, $elgg_password, $elgg_name, $elgg_email, false, 0, '');
			print_r($guid);
			if ($guid) {
				$new_user = get_entity($guid);
	
				set_user_validation_status($guid, true, 'email');
	
				system_message(sprintf(elgg_echo("registerok"),$CONFIG->sitename));

				// Forward on success, assume everything else is an error...
				login($new_user, false);
				forward(fb_dashboard_redirect);
			} else {
				register_error(elgg_echo("registerbad"));
			}
		} catch (RegistrationException $r) {
			register_error($r->getMessage());
		}
	} else {
		print_r('<br>err1<br>');
		register_error(elgg_echo('registerdisabled'));
	}
		
}
