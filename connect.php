<?php

	$dsn = "mysql:host=localhost;dbname=onlineshopping";//data source name
	$user = "root";
	$password = "";

	try{
		$con = new PDO($dsn,$user,$password);
		$con -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e){
		echo "Failed To Connect" . $e->getMessage();
	}