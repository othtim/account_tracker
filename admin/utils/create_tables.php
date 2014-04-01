<?php


/// 
///  Later need to fill in all the validations for all of the different fields.
///

mysql_connect('localhost','root','test');
mysql_query('CREATE DATABASE stest');
mysql_select_db('stest');


	mysql_query('CREATE TABLE `views`  (
		`viewid`		(int 11)	auto_increment NOT NULL,
		`viewname`		(varchar 100)	NOT NULL,
		`viewdata`		(varchar 1000)	,
		`PRIMARY KEY (`viewid`)
		)' );


	mysql_query('CREATE TABLE `fields` (
		`fieldid` 		int(11) 	auto_increment NOT NULL,
		`displayfieldname` 	varchar(50) 	NOT NULL,
		`corefieldname` 	varchar(50) 	UNIQUE NOT NULL,
		`security` 		int(10) 	,
		`usersecurity` 		varchar(500) 	,
		PRIMARY KEY (`fieldid`)
		)' );


	mysql_query('CREATE TABLE `profile` (
		`profileid` 		int(11) 	auto_increment NOT NULL,
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
		`clientcompanyname`	varchar(100)	,
		`clientcoaddress`	varchar(30)	,
		`clientcoapartment`	varchar(30)	,
		`clientcocity`		varchar(30)	,
		`clientcoprovince`	varchar(20)	,
		`clientcopostalcode`	varchar(10)	,
		`clientcolastname`	varchar(30)	,
		`clientcofirstname`	varchar(30)	,
		`clientcossn`		varchar(9)	,
		`clientcodob`		varchar(50)	,
		`clientcopronoun`	varchar(10)	,
		`clientmeetmethod`	varchar(50)	,
		`clientknowndate`	varchar(50)	,
		`clientknownyears`	varchar(2)	,
		`clientcitizenship`	varchar(50)	,
		`clientoccupation`	varchar(50)	,
		`clientemployer`	varchar(50)	,
		`clientemployeraddress`		varchar(50)	,
		`clientemployerbusinesstype`	varchar(50)	,
		`clientnumberofdependants`	varchar(2)	,
		`clientmaritalstatus`		varchar(50)	,
		`clientidnumber`		varchar(50)	,
		`clientidexpirydate`		varchar(50)	,
		`clientidissuecountryprovince`	varchar(50)	,
		`clientfinancialinstitution`	varchar(50)	,
		`clienttransitaccountnumber`	varchar(50)	,
		`clientcurrency`		varchar(50)	,
		`clientinvestorincome`		varchar(50)	,
		`clientinvestornetworth`	varchar(50)	,
		`clientinvestmentknowledge`	varchar(50)	,
		`clientcoinvestoroccupation`	varchar(50)	,
		`clientcoinvestoremployer`	varchar(50)	,
		`clientjointincome`		varchar(50)	,
		`clientjointnetworth`		varchar(50)	,
		`creator`			varchar(50)	NOT NULL,	
		`usersecurity`			varchar(1000)	,	
		PRIMARY KEY (`profileid`)
		)' );



	mysql_query('CREATE TABLE `users` (
		`userid` 		int(11)  	auto_increment NOT NULL,
		`username` 		varchar(20) 	UNIQUE NOT NULL DEFAULT"",
		`password` 		varchar(32) 	NOT NULL DEFAULT "",
		`date_registered` 	int(10) 	NOT NULL DEFAULT 0,
		`last_seen` 		int(10) 	NOT NULL DEFAULT 0,
		`security`		int(10)		NOT NULL,
		PRIMARY KEY (`userid`)
		)' );
		mysql_query('INSERT INTO `users` (`username`,`password`,`date_registered`,`last_seen`,`security`) VALUES("admin","test","'.time().'","'.time().'",99) ');



	mysql_query('CREATE TABLE `blobs` (
		`blobid` 		int(11)  	auto_increment NOT NULL,
		`clientid` 		varchar(20) 	NOT NULL DEFAULT "",
		`display_name` 		varchar(200) 	NOT NULL DEFAULT "",
		`description` 		varchar(200) 	DEFAULT "",
		`display_order` 	int(10) 	NOT NULL DEFAULT 1,
		`name` 			varchar(200) 	NOT NULL DEFAULT "",
		`type` 			varchar(30) 	DEFAULT "",
		`size` 			bigint	 	NOT NULL DEFAULT 0,
	        `path` 			varchar(200) 	NOT NULL,
		PRIMARY KEY (`blobid`)	
		)' );
		
		
	mysql_query('CREATE TABLE `core` (
		`coreid` 		int(11)  	auto_increment NOT NULL,
		`username` 		varchar(20) 	NOT NULL DEFAULT "",
		`session_timeout` 	int(10) 	NOT NULL DEFAULT 360,
		`message_scrubtime` 	int(10) 	NOT NULL DEFAULT 60,
		`max_file_size` 	int(12) 	DEFAULT 0,
		PRIMARY KEY (`coreid`)
		)' );
		mysql_query('INSERT INTO `core` (`username`,`session_timeout`,`message_scrubtime`,`max_file_size`) VALUES("admin",360,60,200000000)');
		
		

	mysql_query('CREATE TABLE `messages` (
		`messageid` 		int(11) 	auto_increment NOT NULL,
		`clientid` 		varchar(50) 	NOT NULL,
		`message` 		varchar(1000) 	NOT NULL,
		`date` 			varchar(40) 	,
		`creator`		varchar(50)	,
		`security`		int(10)		,
		PRIMARY KEY (`messageid`)
		)' );



	mysql_query('CREATE TABLE `accounts` (
		`accountid`		int(11)		auto_increment NOT NULL,
		`clientid`		varchar(50)	NOT NULL,
		`accountType`		varchar(100)	NOT NULL,
		`investmentObjectives`	varchar(1000)	,
		`percentIncome`		int(11)		,
		`percentBalanced`	int(11)		,
		`percentGrowth`		int(11)		,
		PRIMARY KEY (`accountid`)
		)' );
		


//	mysql_query('DROP TABLE fields');
//	mysql_query('DROP TABLE users');
//	mysql_query('DROP TABLE profile');
//	mysql_query('DROP TABLE blobs');
//	mysql_query('DROP TABLE core');
//	mysql_query('DROP TABLE messages');

?>
