<?php

require_once(dirname(__FILE__).'/datapageviews.php');

    ksort($data);
    echo json_encode($data);
?>
