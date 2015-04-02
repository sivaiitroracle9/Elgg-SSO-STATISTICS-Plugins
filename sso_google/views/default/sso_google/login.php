<?php
global $CONFIG;
echo "<div id='sso_google_login'>";
echo "<p> <h3> Login with </h3>";
echo '<a href = "' . $CONFIG->wwwroot . 'pg/glogin/forward" target="_self">';
echo "<img alt='GLOGIN' src='" . $vars ["url"] . "mod/sso_google/lib/images/google_logo.png' />";
echo "</a>";
echo "<br> </p>";
echo "</div>";

?>

