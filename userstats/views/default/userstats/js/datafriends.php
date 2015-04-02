<?php
global $CONFIG;
//for($i=1; $i<=12; $i++) {
	$data[] = array((float)mktime(1,0,0,2, 1+1, 2014)*1000, 0);	
//}

    $owner = get_loggedin_user();
    $query = 'select count(*) as friends, date(time_created) as date_created from ' . $CONFIG->dbprefix . 'entity_relationships where (relationship = \'friend\') and (guid_one=' . $owner->guid . ' or guid_two =' . $owner->guid . ') group by date_created';
	
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
	$friends = (float)$row->friends;
	$total += $friends;

	$unixdate = mktime(1,0,0,$date[1], $date[2]+1, $date[0])*1000;
	$data[] = array((float)$unixdate, $friends);	

	if($unixtoday == $unixdate) {
		$totald += $friends;
	}
	if($unixtoday >= $unixdate && $unixweekback <= $unixdate) {
		$totalw += $friends;	
	}
	//print_r('<br>@@ -'.$date[0].'-'.$date[1].'-'.$date[2].'------'.$todaydate[0].'-'.$todaydate[1].'-'.$todaydate[2].'---'.$friends.'<br>');
	if(($date[1]==$todaydate[1]) && ($date[0]==$todaydate[0])) {
		$totalm += $friends;
	}
    }

    $_SESSION['userstatistics_stats_friends'] = array('total'=>$total, 'day' => $totald, 'week' => $totalw, 'month' => $totalm);

?>
