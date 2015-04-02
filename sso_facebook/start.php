<?php


require_once(dirname(__FILE__) . "/lib/page_handlers.php");

function sso_facebook_init() {
	register_page_handler('fblogin', 'fblogin_page_handler');
	
	extend_view("account/forms/login", "sso_facebook/login");

}

//Initialize
register_elgg_event_handler('init', 'system', 'sso_facebook_init');

?>
