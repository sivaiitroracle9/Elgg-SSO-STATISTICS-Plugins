<?php
session_start ();

require_once (dirname ( dirname ( dirname ( dirname ( __FILE__ ) ) ) )) . '/engine/lib/users.php';
require_once (dirname ( dirname ( dirname ( dirname ( __FILE__ ) ) ) )) . '/engine/lib/sessions.php';
require_once dirname ( __FILE__ ) . '/constants.php';
require_once dirname ( __FILE__ ) . '/Facebook/FacebookRedirectLoginHelperElgg.php';
require_once dirname ( __FILE__ ) . '/Facebook/HttpClients/FacebookHttpable.php';
require_once dirname ( __FILE__ ) . '/Facebook/HttpClients/FacebookCurl.php';
require_once dirname ( __FILE__ ) . '/Facebook/HttpClients/FacebookCurlHttpClient.php';
require_once dirname ( __FILE__ ) . '/Facebook/FacebookSession.php';
require_once dirname ( __FILE__ ) . '/Facebook/FacebookRequest.php';
require_once dirname ( __FILE__ ) . '/Facebook/FacebookResponse.php';
require_once dirname ( __FILE__ ) . '/Facebook/FacebookSDKException.php';
require_once dirname ( __FILE__ ) . '/Facebook/FacebookRequestException.php';
require_once dirname ( __FILE__ ) . '/Facebook/FacebookOtherException.php';
require_once dirname ( __FILE__ ) . '/Facebook/FacebookAuthorizationException.php';
require_once dirname ( __FILE__ ) . '/Facebook/GraphObject.php';
require_once dirname ( __FILE__ ) . '/Facebook/GraphSessionInfo.php';
require_once dirname ( __FILE__ ) . '/Facebook/GraphUser.php';

use Facebook\HttpClientsFacebookHttpable;
use Facebook\HttpClientsFacebookCurl;
use Facebook\HttpClientsFacebookCurlHttpClient;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelperElgg;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;

FacebookSession::setDefaultApplication ( appId, appSecret );
global $CONFIG;
$helper = new FacebookRedirectLoginHelperElgg ( fb_login_redirect );

// see if a existing session exists
if (isset ( $_SESSION ) && isset ( $_SESSION ['fb_token'] )) {
	// create new session from saved access_token
	$session = new FacebookSession ( $_SESSION ['fb_token'] );
	// validate the access_token to make sure it's still valid
	try {
		if (! $session->validate ()) {
			$session = null;
		}
	} catch ( Exception $e ) {
		$session = null;
	}
} else {
	// no session exists
	try {
		$session = $helper->getSessionFromRedirect ();
	} catch ( FacebookRequestException $ex ) {
		// When Facebook returns an error
	} catch ( Exception $ex ) {
		// When validation fails or other local issues
		echo $ex->message;
	}
}

// see if we have a session
if (isset ( $session )) {
	// save the session
	$_SESSION ['fb_token'] = $session->getToken ();
	// create a session using saved token or the new one we generated at login
	$session = new FacebookSession ( $session->getToken () );
	// graph api request for user data
	$request = new FacebookRequest ( $session, 'GET', '/me' );
	$response = $request->execute ();
	$graph = $response->getGraphObject ( GraphUser::classname () );
	
	$_SESSION ['valid'] = true;
	$_SESSION ['timeout'] = time ();
	$_SESSION ['fbloggedin'] = true;
	
	$_SESSION ['facebook_id'] = $graph->getId ();
	$_SESSION ['facebook_elgg_email'] = $graph->getProperty ( 'email' );
	$_SESSION ['facebook_elgg_username'] = 'fb_'.explode ( '@', $_SESSION ['facebook_elgg_email'] )[0];
	$_SESSION ['facebook_elgg_password'] = 'student';
	$_SESSION ['facebook_fname'] = $graph->getFirstName ();
	$_SESSION ['facebook_lname'] = $graph->getLastName ();
	$_SESSION ['facebook_gender'] = $graph->getGender ();
	
	// logout and destroy the session, redirect url must be absolute url
	$logoutUrl = $helper->getLogoutUrl ( $session, fb_logout_redirect );
	$_SESSION ['facebook_logout'] = $logoutUrl;

	//print_r($_SESSION );
	$user = get_user_by_username($_SESSION ['facebook_elgg_username']);
	if(isset($user)&&  ($user instanceof ElggUser)) {
		login($user, false);
		forward(fb_dashboard_redirect);		
	} else {
		forward(fb_register_redirect);	
	}
	
} else {
	header('Location: ' . $helper->getLoginUrl(array('email'), '', true));
}
