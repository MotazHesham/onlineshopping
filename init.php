<?php

	include "connect.php";

	/*     Routes    */

		$tpl = "includes/templates/"; //Templates Directory
		$func = "includes/functions/"; //functions Directory
		$images = "layout/images/"; //images Directory
		$css = "layout/css/"; //css Directory
		$js  = "layout/js/"; //js Distectory


	/*     important include    */
	
	include $func . "functions.php";
	include $tpl . "header.php";

	//include  NavBar on all page expect the one with $noNavbar variable

	if(!isset($noNavbar)){include $tpl . "NavBar.php";}

	//include  Carousel on all page expect the one with $noCarousel variable

	if(!isset($noCarousel)){include $tpl . "Carousel.php";}
			
