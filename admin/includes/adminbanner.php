<?php

//pull the user data so we can tell the user when they last logged in
$data = mysql_fetch_array( mysql_query('SELECT * FROM `users` WHERE `username` LIKE "'.$_SESSION['username'].'"'));




//echo "Welcome back, ".$_SESSION['username'].". <BR />";
//echo "Your last login was ".date('l, F j, Y', $data['last_seen']).". <BR />";
//echo "<HR />";
echo "


<table width=\"80%\" border=\"0\">
<tr width=\"100%\">

<td width=\"80\" align=\"center\">
<a href=\"adminhome.php\">
<img border=\"0\" src=\"images/home.jpg\"><BR />
Home
</a>
</td>


<td width=\"90\" align=\"center\">
<a href=\"admincreate.php\">
<img border=\"0\" src=\"images/create.jpg\"><BR />
Add Client
</a>
</td>


<td width=\"90\" align=\"center\">
<a href=\"adminviewprofile.php\">
<img border=\"0\" src=\"images/profile.jpg\"><BR />
View Clients
</a>
</td>



<td width=\"90\" align=\"center\">
<a href=\"admincore.php\">
<img border=\"0\" src=\"images/core.jpg\"><BR />
Core
</a>
</td>


<td width=\"90\" align=\"center\">
<a href=\"logout.php\">
<img border=\"0\" src=\"images/logout.jpg\"><BR />
Logout
</a>
</td>

<td align=\"right\">
<div id=\"statusInfo\">

</div>
</td>

</tr>
</table>

";

echo "<HR />";

?>






