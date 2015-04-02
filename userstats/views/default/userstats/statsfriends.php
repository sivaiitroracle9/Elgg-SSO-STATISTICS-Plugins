<?php

	$body = elgg_view('userstats/chart_friends');	
	page_draw('Posts', elgg_view_layout('sidebar_boxes','hi', elgg_view_title('Most Commented Posts').$body,'hello'));

?>

