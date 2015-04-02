<?php

	$sessionuser = $_SESSION['user'];
	$userid=$sessionuser->guid;

	$query = "select e.guid as guid from elgg_entities e join elgg_entity_subtypes s on e.subtype=s.id where s.subtype='blog' and (e.container_guid=$userid or e.owner_guid=$userid)";

	$query_rslt = get_data($query);
	foreach($query_rslt as $row) {
//		if(!in_array($row->guid, $blogs)) {
		    $blog_commentcnt_map[$row->guid] = 0;
		    $blogs[]=$row->guid;		
//		}
        }
	
	$query = "select count(*) as comment, a.entity_guid as blog from elgg_entities e join elgg_annotations a on e.guid=a.entity_guid join elgg_metastrings ms on a.value_id=ms.id where a.name_id in (select id from elgg_metastrings where string= 'generic_comment') group by blog";

	$query_rslt = get_data($query);
	foreach($query_rslt as $row) {
		if(in_array($row->blog, $blogs)) {
			$blog_commentcnt_map[$row->blog] = $row->comment;
			$blogs[]=$row->blog;
		}
        }

	$options = array('type' => 'object', 'callback'=>"", 'entity_guids' => $blogs, 'subtype' => 'blog', 'limit' => 10, 'full_view' => FALSE, 'offset' => (int)get_input('offset',0), 'view_type_toggle'=>FALSE, 'pagination'=>TRUE);

	$entities = elgg_get_entities($options);
	$validEntities = array();
	foreach($entities as $entity) {
		$guid = $entity->getGUID();
		if(in_array($guid, $blogs)) {
			$validEntitiescntmap[$blog_commentcnt_map[$guid]] = $entity;	
		}
	}

krsort($validEntitiescntmap, SORT_NUMERIC);

foreach($validEntitiescntmap as $key=>$value){
	$validSorted[] = $value;
	if(sizeof($validSorted)>=5)break;
}

$body = elgg_view_entity_list($validSorted, sizeof($validEntitiescntmap), $options['offset'],
		$options['limit'], $options['full_view'], $options['view_type_toggle'], $options['pagination']);

	page_draw('Posts', elgg_view_layout('sidebar_boxes',elgg_view_title('Statistics:'), elgg_view_title('Most Commented Posts').$body,elgg_view('userstats/statistics')));

?>

