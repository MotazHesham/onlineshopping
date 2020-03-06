<?php


	/*
	++++++++++++++++++++++++++++++++++++++++++++++
	+++++++
	=======	CopyTemplate
	+++++++
	++++++++++++++++++++++++++++++++++++++++++++++
	*/

	ob_start(); // Output Buffering Start 

	session_start();

	$pageTitle='';

	if(isset($_SESSION['UserName']) && $_SESSION['role']==1){// this condation contain all the page

		include "init.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if($do == 'Manage'){
			echo "WElcome to Manage";
		}elseif($do == 'Add'){

		}elseif($do == 'Insert'){

		}elseif($do == 'Edit'){

		}elseif($do == 'Update'){

		}elseif($do == 'Delete'){

		}

		include $tpl . 'footer.php' ;

	}else{

		header("Location:index.php");

		exit();
		
	}	