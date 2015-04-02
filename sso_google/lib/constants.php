<?php

global $CONFIG;
define('GOOGLE_CLIENT_ID', '67785980183-nembepolaq93c7i0c4c1iblv7a860mcq.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'DHrXpx6kNmiiRsZafjWwTgRY');
define('GOOGLE_REDIRECT_URI', $CONFIG->wwwroot . 'pg/glogin/login' );
define('GOOGLE_SCOPES', 'email');

define('REDIRECT_REGISTER_USER', $CONFIG->wwwroot . 'pg/glogin/register');
define('REDIRECT_DASHBOARD', $CONFIG->wwwroot . 'pg/dashboard');

?>
