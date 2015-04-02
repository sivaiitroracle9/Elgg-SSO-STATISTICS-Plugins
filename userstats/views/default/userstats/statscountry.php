<?php
    global $CONFIG;
    $owner = get_loggedin_user();
    $query = 'select visitor_ipaddress as ipaddr, time_created from ' . $CONFIG->dbprefix . 'page_views where owner_id=' . $owner->guid;
	
    $query_rslt = get_data($query);
	
    foreach($query_rslt as $row) {
	$map[$row->time_created] = $row->ipaddr;	
    }
    
    krsort($map);

?>

<div>
<?php if(sizeof($map)>0): ?>
	<p><center><h2>Number of Profile Visitors: <?php echo sizeof($map); ?></h2></center><center>
<br/>
<table class="elgg-table" border="1">
	<tr>
		<td><center><b> Visitor IP ADDR </b></center></td>
		<td><b> &nbsp&nbsp  </b></td>
		<td><center><b> TIMESTAMP </b></center></td>
	</tr>
		<td> &nbsp </td>
		<td> &nbsp </td>
		<td> &nbsp </td>
<?php	foreach($map as $key=>$value) {
		echo '<tr>';
		echo '<td>' . $value . '</td>';
		echo '<td> &nbsp-&nbsp </td>';
		echo '<td>&nbsp&nbsp' . $key . '</td>';
		echo '</tr>';	
	}
?>	
</table>
<?php else: ?>
	<p><center><h4>No Visitors. !!</h4></center></p>
<?php endif; ?>
</center>
</p>

</div>
