<?php

	include "connect.php";

	/*     Routes    */

		$tpl = "includes/templates/"; //Templates Directory
		$func = "includes/functions/"; //functions Directory
		$css = "layout/css/"; //css Directory
		$js  = "layout/js/"; //js Distectory
		$img  = "layout/images/"; //images Distectory


	/*     important include    */
	
	include $func . "functions.php";
	include $tpl . "header.php";

	//include  NavBar on all page expect the one with $Navbar variable

	if(!isset($noNavbar)){include $tpl . "NavBar.php";}
			
