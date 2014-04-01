<?php

//pull the user data so we can tell the user when they last logged in
$data = mysql_fetch_array( mysql_query('SELECT * FROM `users` WHERE `username` LIKE "'.$_SESSION['username'].'"'));

echo "Welcome back, ".$_SESSION['username'].". <BR />";
echo "Your last login was ".date('l, F j, Y', $data['last_seen']).". <BR />";
echo "<HR />";
echo "<a href=\"adminhome.php\">Home</a> | <a href=\"admincore.php\">Core</a> | <a href=\"admincreate.php\">Create</a> | <a href=\"adminprofile.php\">Profile</a> | <a href=\"admincomponents.php\">Components</a> | <a href=\"logout.php\">Logout</a>";
echo "<HR />";


?>















