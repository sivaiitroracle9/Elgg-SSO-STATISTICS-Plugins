<?php

function userstats_init() {

	global $CONFIG;
	add_menu('User Web Statistics', $CONFIG->wwwroot . "pg/statscomments");

	register_page_handler("statspageviews", "statspageviews_page_handler");
	register_page_handler("statsfriends", "statsfriends_page_handler");
	register_page_handler("userstatsdata", "userstatsdata_page_handler");
	register_page_handler("statscomments", "statscomments_page_handler");
	register_page_handler("statscountry", "statscountry_page_handler");

}


function userstatsdata_page_handler($page) {

	require_once(dirname(__FILE__) . '/views/default/userstats/js/'.$page[0]);
}

function statspageviews_page_handler() {
	$body = elgg_view('userstats/chart_pageviews');
	page_draw('Hi', elgg_view_layout('sidebar_boxes', elgg_view_title('Statistics:'), elgg_view_title('Profile Visitors').$body, elgg_view('userstats/statistics')));
}

function statsfriends_page_handler() {
	$body = elgg_view('userstats/chart_friends');	
	page_draw('Hi', elgg_view_layout('sidebar_boxes', elgg_view_title('Statistics:'), elgg_view_title('Friends Added').$body, elgg_view('userstats/statistics')));
}

function statscomments_page_handler() {
	
	require_once(dirname(__FILE__) . '/views/default/userstats/statscomments.php');
}

function statscountry_page_handler() {
	$body = elgg_view('userstats/statscountry');
	page_draw('Statistics:Visitors Country', elgg_view_layout('sidebar_boxes',elgg_view_title('Statistics:'), elgg_view_title('Visitors Country / IP address').$body,elgg_view('userstats/statistics')));
}

register_elgg_event_handler("init", "system", "userstats_init");
