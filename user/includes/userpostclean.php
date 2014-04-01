<?php


//sanitize a hash foy mysql
function hash_mysql_sanitize($pdata){
	
if( isset($pdata) ){

	//make sure that $pdata is cleaned. put this in a header.
	foreach( $pdata as $key => $value ){
		//clean up!
		mysql_real_escape_string($value);
	}
}

return $pdata;
}

?>















