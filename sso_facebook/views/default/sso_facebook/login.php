<?php
global $CONFIG;
echo "<div id='sso_facebook_login'>";
echo "<p> <h3> Login with </h3>";
echo '<a href = "' . $CONFIG->wwwroot . 'pg/fblogin/forward" target="_self">';
echo "<img alt='FBLOGIN' src='" . $vars ["url"] . "mod/sso_facebook/lib/images/fb_logo.jpg' />";
echo "</a>";
echo "<br> </p>";
echo "</div>";

?>

