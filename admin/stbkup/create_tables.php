<?php

//	require_once('connect.php');

mysql_connect('localhost','root','shadow');
mysql_select_db('stest');



	mysql_query('CREATE TABLE `fields` (
		`fieldid` 		int(11) 	auto_increment,
		`profilefieldname` 	varchar(20) 	UNIQUE NOT NULL,
		`thisfieldname` 	varchar(20) 	UNIQUE NOT NULL,
		`security` 		int(10) 	NOT NULL,
		PRIMARY KEY (fieldid)
		)' );


//	
//UNFINISHED
//
	mysql_query('CREATE TABLE `profile` (
		`profileid` 		int(11) 	auto_increment,
		`clientid` 		varchar(10) 	UNIQUE NOT NULL,
		`clienttype` 		varchar(10) 	NOT NULL,
		`clientdealernumber`	varchar(10)	NOT NULL DEFAULT "",
		`clientadvisornumber`	varchar(10)	NOT NULL DEFAULT "",
		`clientpronoun`		varchar(10)	,
		`clientlastname`	varchar(30)	NOT NULL,
		`clientfirstname`	varchar(30)	NOT NULL,
		`clientinitial`		varchar(1)	,
		`clientaddress`		varchar(30)	NOT NULL,
		`clientapartment`	varchar(30)	,
		`clientcity`		varchar(30)	NOT NULL,
		`clientprovince`	varchar(20)	NOT NULL,
		`clientpostalcode`	varchar(10)	,
		`clientresidencephone`	varchar(20)	,
		`clientbusinessphone`	varchar(20)	,
		`clientssn`		varchar(9)	,
		`clientdob`		varchar(20)	,
		`clientcoaddress`	varchar(30)	,
		`clientcoapartment`	varchar(30)	,
		`clientcocity`		varchar(30)	,
		`clientcoprovince`	varchar(20)	,
		`clientcopostalcode`	varchar(10)	,
		`clientmeetmethod`	varchar(20)	,
		`clientknowndate`	varchar(20)	,
		`clientknownyears`	varchar(2)	,
		`clientcitizenship`	varchar(20)	NOT NULL,
		`clientoccupation`	varchar(40)	,
		`clientemployer`	varchar(50)	,
		`clientemployeraddress`		varchar(30)	,
		`clientemployerbusinesstype`	varchar(30)	,
		`clientnumberofdependants`	varchar(2)	,
		`clientmaritalstatus`	varchar(10)	NOT NULL,
		`clientidnumber`	varchar(20)	UNIQUE NOT NULL,
		`clientexpirydate`	varchar(20)	,
		`clientidissuecountryprovince`	varchar(50)	,
		`clientfinancialinstitution`	varchar(50)	NOT NULL,
		`clienttransitaccountnumber`	varchar(50)	,
		`clientcurrency`	varchar(20)	,

		PRIMARY KEY (profileid)
		)' );
		


	mysql_query('CREATE TABLE `users` (
		`userid` 		int(11)  	auto_increment,
		`username` 		varchar(20) 	UNIQUE NOT NULL DEFAULT"",
		`password` 		varchar(32) 	NOT NULL DEFAULT "",
		`date_registered` 	int(10) 	NOT NULL DEFAULT 0,
		`last_seen` 		int(10) 	NOT NULL DEFAULT 0,
		`security`		int(10)		NOT NULL,
		PRIMARY KEY (userid)
		)' );


	mysql_query('CREATE TABLE `blobs` (
		`blobid` 		int(11)  	auto_increment,
		`username` 		varchar(20) 	NOT NULL DEFAULT "",
		`display_name` 		varchar(200) 	NOT NULL DEFAULT "",
		`description` 		varchar(200) 	NOT NULL DEFAULT "",
		`display_order` 	int(10) 	NOT NULL DEFAULT 0,
		`name` 			varchar(30) 	NOT NULL DEFAULT "",
		`type` 			varchar(30) 	NOT NULL DEFAULT "",
		`size` 			int(10) 	NOT NULL DEFAULT 0,
	        `content` 		MEDIUMBLOB 	NOT NULL DEFAULT "",
		PRIMARY KEY(blobid)	
		)' );
		
		
	mysql_query('CREATE TABLE `core` (
		`coreid` 		int(11)  	auto_increment,
		`session_timeout` 	int(10) 	NOT NULL DEFAULT 360,
		`message_scrubtime` 	int(10) 	NOT NULL DEFAULT 60,
		`max_file_size` 	int(10) 	NOT NULL DEFAULT 2000000,
		PRIMARY KEY (coreid)
		)' );
		
		
	mysql_query('CREATE TABLE `messages` (
		`messageid` 		int(11) 	NOT NULL auto_increment,
		`message` 		varchar(200) 	NOT NULL DEFAULT "",
		`age` 			varchar(40) 	NOT NULL DEFAULT "",
		PRIMARY KEY (messageid)
		)' );

		
		


//	mysql_query('DROP TABLE fields');
//	mysql_query('DROP TABLE users');
//	mysql_query('DROP TABLE profile');
//	mysql_query('DROP TABLE blobs');
//	mysql_query('DROP TABLE core');
//	mysql_query('DROP TABLE messages');

?>
