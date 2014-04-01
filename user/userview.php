<?php

include('includes/userpostclean.php');
include('includes/usersession.php');

include('includes/userhtmlhead.php');
include('includes/userbanner.php');

include('includes/userviewheader.php');




$clientid=0;

if( isset($_SESSION['clientid']) ){
	$clientid = $_SESSION['clientid'];
	$query = sprintf("SELECT * FROM `profile` WHERE `clientid`='%s'",mysql_real_escape_string($_SESSION['clientid']));
	$result = mysql_query($query);
	$pdata = mysql_fetch_array($result);
}

////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////


?>

<BR />
<BR />


<table width=70%>
<td align=right>
<!-- whatever can go here -->
</td>
</table>

Investor
<table class=table width=70%>

<tr>
	<td >
		&nbsp;
	</td>
</tr>

<tr>
	<td colspan=2 class=td1>

	<BR />
	
	<font size=5><?php echo $myclient->fields['clientpronoun'] ?>.&nbsp;&nbsp;<?php echo $myclient->fields['clientfirstname'] ?>&nbsp;<?php echo $myclient->fields['clientlastname'] ?></font>
	<BR />
	<BR />
	<BR />
	<?php echo $myclient->fields['clientapartment'] ?>, <?php echo $myclient->fields['clientaddress'] ?> - <?php echo $myclient->fields['clientcity'] ?>, <?php echo $myclient->fields['clientprovince'] ?>
	<BR />
	<BR />
	Res: <?php echo $myclient->fields['clientresidencephone'] ?>	
	<BR />
	Bus: <?php echo $myclient->fields['clientbusinessphone'] ?>	
	<BR />
	<BR />
	
	<HR />
	
whatever you want goes here.
	
	</td>

	<td class=td1 valign=top width=25%>

	<BR />
	<BR />

	Dealer Number: <?php echo $myclient->fields['clientdealernumber'] ?>

	<BR />
	<BR />

	Advisor Number: <?php echo $myclient->fields['clientadvisornumber'] ?>


	<BR />
	<BR />

	</td>


	
</tr>



</table>

<?php


//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//
// this section is for co investors. if coinvestors exist then this section will display.


if( ($pdata['clientcofirstname'] != '') && ($pdata['clientcolastname'] != '') ){


?>

<BR />

Co-Investor
<table class=table width=70%>

<tr>
	<td >
		&nbsp;
	</td>
</tr>

<tr>
	<td colspan=2 class=td1>

	<BR />
	
	<font size=5><?php echo $myclient->fields['clientcopronoun'] ?>.&nbsp;&nbsp;<?php echo $myclient->fields['clientcofirstname'] ?>&nbsp;<?php echo $myclient->fields['clientcolastname'] ?></font>
	<BR />
	<BR />
	<BR />
	<?php echo $myclient->fields['clientcoapartment'] ?>, <?php echo $myclient->fields['clientcoaddress'] ?> - <?php echo $myclient->fields['clientcocity'] ?>, <?php echo $myclient->fields['clientcoprovince'] ?>
	<BR />
	<BR />
	
	</td>

	<td class=td1 valign=top width=25%>

	<BR />
	<BR />

	&nbsp;

	</td>

	
</tr>

</table>


<?php

}

?>


