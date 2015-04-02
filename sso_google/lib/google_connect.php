<?php

require_once (dirname ( dirname (dirname ( dirname ( __FILE__ ))))) . '/engine/lib/users.php';
require_once (dirname ( dirname (dirname ( dirname ( __FILE__ ))))) . '/engine/lib/sessions.php';

require_once dirname(__FILE__) . '/Google/Client.php';
require_once dirname(__FILE__) . '/Google/Service/Plus.php';
require_once dirname(__FILE__) . '/constants.php';

$google_client = new Google_Client();
$google_client->setClientId(GOOGLE_CLIENT_ID);
$google_client->setClientSecret(GOOGLE_CLIENT_SECRET);
$google_client->setRedirectUri(GOOGLE_REDIRECT_URI);
$google_client->setScopes(GOOGLE_SCOPES);

print_r(GOOGLE_REDIRECT_URI);

session_start();

$google_code = $_SESSION['google_code'];
print_r('code:'.$google_code);
print_r('<br>code isset:'. isset($google_code));


if(isset($google_code) && !empty($google_code)) {
	$google_client->authenticate($google_code);
	$_SESSION['google_token'] = $google_client->getAccessToken();
}

// Google Token & Google Code Verification.
$google_token = $_SESSION['google_token'];
if(isset($google_token) && !empty($google_token)) {
	$google_data = $google_client->verifyIdToken()->getAttributes()['payload'];
		
	$_SESSION['google_id'] = $google_id = $google_data['id'];

	$google_plus = new Google_Service_Plus($google_client);
	$google_plus_data = $google_plus->people->get($google_id);

	$_SESSION['google_email'] = $google_email = $google_data['email'];
	$_SESSION['google_username'] = $google_username = 'glg_'.explode('@', $google_email)[0];
	$_SESSION['google_password'] = $google_password = 'student';
	$_SESSION['google_name'] = $goole_name = $google_plus_data['displayName'];

	$user = get_user_by_username($_SESSION ['google_username']);
	if(isset($user) &&  ($user instanceof ElggUser)) {
		login($user, false);
		forward(REDIRECT_DASHBOARD);
	} else {
		forward(REDIRECT_REGISTER_USER);
	}
	
} else {
	// Sign in with google.
	header('Location: ' . $google_client->createAuthUrl());
}
?>
