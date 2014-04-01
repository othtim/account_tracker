<?php

include('includes/userpostclean.php');
include('includes/usersession.php');


//we have to check up here for downloads because we have to output headers.
if(isset($_GET['downloadid'])){

	$query = sprintf("SELECT * FROM `blobs` WHERE blobid='%s'", mysql_real_escape_string($_GET['downloadid']) );
	$result = mysql_fetch_array(mysql_query($query));

	//lets start by checking to see if this file actually exists.
	$myFilehandle = fopen($result['path'], 'r');// or die("Can't open file $result['path']");
	$myData = fread($myFilehandle, filesize($result['path']));
	fclose($myFilehandle);

	header('Content-type: '.$result['type']);
	header('Content-Disposition: attachment; filename="'.$result['name'].'"');
	header('Content-Length: '.$result['size']);


	print $myData;

	exit();	
}

?>