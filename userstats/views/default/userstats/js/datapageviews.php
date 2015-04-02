<?php


//for($i=1; $i<=12; $i++) {
	$data[] = array((float)mktime(1,0,0,2, 1+1, 2014)*1000, 0);	
//}

global $CONFIG;

    $owner = get_loggedin_user();
    $query = 'select count(*) as views, date(time_created) as date_created from ' . $CONFIG->dbprefix . 'page_views where owner_id=' . $owner->guid . ' group by date_created';
	
    $query_rslt = get_data($query);

    $totald=0;
    $totalw=0;
    $totalm=0;
    $total=0;

	$todaydate=explode('-', date("Y-m-d"));
	$unixtoday = (float)mktime(1,0,0,$todaydate[1], $todaydate[2]+1, $todaydate[0])*1000;
	$unixweekback = ((float)$unixtoday - 6*24*60*60*1000);

    foreach($query_rslt as $row) {
	$date = explode('-', $row->date_created);
	$views = (float)$row->views;
	$total += $views;

	$unixdate = mktime(1,0,0,$date[1], $date[2]+1, $date[0])*1000;
	$data[] = array((float)$unixdate, $views);	

	if($unixtoday == $date) {
		$totald += $views;
	}
	if($unixtoday >= $unixdate && $unixweekback <= $unixdate) {
		$totalw += $views;	
	}
	
	if(($date[1]==$todaydate[1]) && ($date[0]==$todaydate[0])) {
		$totalm += $views;
	}
    }

    $_SESSION['userstatistics_stats_pageviews'] = array('total'=>$total, 'day' => $totald, 'week' => $totalw, 'month' => $totalm);
?>
