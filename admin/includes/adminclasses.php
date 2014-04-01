<?php 


include('../classes/classClient.php');


if( isset($_SESSION['clientid']) ){

	$myclient = new Client($_SESSION['clientid']);

}


?>