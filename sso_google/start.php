<?php


require_once(dirname(__FILE__) . "/lib/page_handlers.php");

function sso_google_init() {
	register_page_handler('glogin', 'glogin_page_handler');
	
	extend_view("account/forms/login", "sso_google/login");
}

//Initialize
register_elgg_event_handler('init', 'system', 'sso_google_init');

?>
