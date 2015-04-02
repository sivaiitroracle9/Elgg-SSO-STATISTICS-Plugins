<?php

    require_once(dirname(__FILE__).'/datafriends.php');

    ksort($data);
    echo json_encode($data);
?>
