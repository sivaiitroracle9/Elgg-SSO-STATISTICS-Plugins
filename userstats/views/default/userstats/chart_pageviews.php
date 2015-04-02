<?php
	require_once(dirname(__FILE__) . '/js/datapageviews.php');
?> 

<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/userstats/views/default/userstats/js/js_pageviews.php">
</script>

<script type="text/javascript">
$(function() {
	pageviews_chart_stats();
});
</script>

<div id="pageviews_container" style="min-width: 310px; max-width: 700px; height: 400px; margin: 0 auto"></div>

<?php
	$statsobj = $_SESSION['userstatistics_stats_pageviews'];
	$totald = isset($statsobj['day']) ? $statsobj['day'] : 0;
	$totalw = isset($statsobj['week']) ? $statsobj['week'] : 0;
	$totalm = isset($statsobj['month']) ? $statsobj['month'] : 0;
	$total = isset($statsobj['total']) ? $statsobj['total'] : 0;
?>

<p> <br/> <h2><center> Total Profile Visitors : <?php echo $total; ?> 

<table> 
	<tr>
		<td> ------------------------------</td>
		<td> -------------------------</td>
		<td> -------------------------</td>
	</tr>
	<tr>
		<td> Views Today : &nbsp &nbsp</td>
		<td> &nbsp - &nbsp </td>
		<td> <?php echo $totald; ?> </td>
	</tr>
	<tr>
		<td> Views this Week : &nbsp &nbsp</td>
		<td> &nbsp - &nbsp </td>
		<td> <?php echo $totalw; ?> </td>
	</tr>
	<tr>
		<td> Views this month : &nbsp &nbsp</td>
		<td> &nbsp - &nbsp </td>
		<td> <?php echo $totalm; ?> </td>
	</tr>
</table>
</center></h2></p>
