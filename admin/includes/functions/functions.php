<?php

	/* Page Title Function -->version 1.0
	 echo the page title 
	 if: the page has the variable $pagetitle
	 else: echo default title
    */

	 function getTitle(){
	 	global $pageTitle;
	 	if(isset($pageTitle)){
	 		echo $pageTitle;
	 	}else{
	 		echo "default";
	 	}
	 }



	 /* Redirect Function --> version 2.0
	 $TheMsg :Echo the error
	 $seconds: Seconds before redirecting
	 $url: The link you want to redirect
    */

	 function redirected($errorMsg,$url=null,$seconds = 3){

	 	if($url === null){

	 		$url = 'index.php';

	 	}else{

	 		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
	 			$url = $_SERVER['HTTP_REFERER'];
	 		}else{
	 			$url = 'index.php';
	 		}
	 		
	 	}

	 	echo "<div class='page-content'>";
		 	echo  $errorMsg ;

		 	echo "<div class='alert alert-info container'> You Will Be ReDirected After " . $seconds . " Seconds</div>";
		echo "</div>"; 	
	 	header("refresh:$seconds;url=$url");

	 	exit();
	 }



	 /* Check item Function --> version 1.0
	  	 this function check if the item exists in database
	  	 $select : Column Name -> the item i want to select
	  	 $From : Table Name
	  	 $Value : The item i check if exist in database 
	 */

	 function Checkitem($select,$from,$value){

	 	global $con;

	 	$statment = $con -> prepare("SELECT $select From $from Where $select = ?");
	 	$statment ->execute(array($value));
	 	$count = $statment -> rowCount();

	 	return $count;
	 }

	 /* Check item Function --> version 2.0
	  	 this function version 2 of checkitem Function
	  	 $select1 : Column Name -> the item i want to select
	  	 $select2 : Column Name -> the id of item i want to select
	  	 $From : Table Name
	  	 $Value : The item i check if exist in database 
	  	 $id : this for not return row of item i want to update
	 */
	 function Checkitem_update($select1,$select2,$from,$value,$id=0){

	 	global $con;

	 	$statment = $con -> prepare("SELECT $select1,$select2 From $from Where $select1 = ? AND $select2 <> $id");
	 	$statment ->execute(array($value));
	 	$count = $statment -> rowCount();

	 	return $count;
	 }
	 



	 /* Count items function --> Version 1.0
	 	this funnction count number of items Rows
	 	$item : The Item to Count 
	 	$table : The Table To Choose from 
	 */
	 	function Countitem($item,$table,$where = ''){

	 		global $con;

	 		$statment = $con -> prepare("SELECT COUNT($item) From $table $where");
	 		$statment -> execute();

	 		return $statment->fetchColumn();
	 	}

	 /* Get latest items functions --> Version 1.0
	 	this function get latest items from the database
	 	$select : Field i wannt to select 
		$table : The table to choose from
		$order : The Desc Ordering
		$limit : Number of recordes to get
	 */
		function getlatest($select,$table,$order,$limit = 5){

			global $con;

			$statment = $con -> prepare("SELECT $select From $table ORDER BY $order DESC LIMIT $limit");
			$statment -> execute();

			return $statment->fetchAll();
		}

	/* this function calculate diffrence between
	  the date i parse and the current date -> version 1.0
	 */
	  function calculate_diff_date($date){

		date_default_timezone_set('Africa/Cairo');

		$added_date = explode(" ", $date);
		$added_date_1 = explode("-", $added_date[0]);
		$added_date_2 = explode(":", $added_date[1]);
		$change_timeformat = date('h:i a ', strtotime($added_date[1]));//change time from 24h to 12h (am) or (pm)

		$strStart = ($date);  
		$strEnd = (date("Y-m-d H:i")); //current date
		$dteStart = new DateTime($strStart);
		$dteEnd   = new DateTime($strEnd);
		  
		  $dteDiff  = $dteStart->diff($dteEnd);

		  $diffrence = explode(" ", $dteDiff->format("%Y-%M-%d %h:%i"));
		  $diffrence_1 =explode("-", $diffrence[0]);
		  $diffrence_2 =explode(":", $diffrence[1]);

		  $ago = ''; 

		  if($diffrence_1[0] != 0){
		  	$ago = getmonth_name($added_date_1[1]) . " " . $added_date_1[2] . "," . $added_date_1[0]; 
		  	return $ago;
		  }
		  if($diffrence_1[1] != 0){
		  	$ago = getmonth_name($added_date_1[1]) . " " . $added_date_1[2] . " at " .  $change_timeformat;
		  	return $ago;
		  }
		  if($diffrence_1[2] > 1){
		  	$ago = getmonth_name($added_date_1[1]) . " " . $added_date_1[2] . " at " .  $change_timeformat;
		  	return $ago;
		  }
		  if($diffrence_1[2] == 1){
		  	$ago = "Yesterday at " . $change_timeformat ;
		  	return $ago;
		  }
		  if($diffrence_1[2] == 0){
		  	if($diffrence_2[0] == 0){
		  		if($diffrence_2[1]==0){
		  			$ago = "1mins";
			  		return $ago . " ago";
		  		}else{
			  		$ago = $diffrence_2[1] . "mins";
			  		return $ago . " ago";
		  		}
		  	}else{
		  		$ago = $diffrence_2[0] . "hrs";
		  		return $ago . " ago";
		  	}
		  }

	  }

	  /* this function called by calculate_diff_date() 
	  		to get the month name  
	  */
	  function getmonth_name($monthNum){
		$dateObj   = DateTime::createFromFormat('!m', $monthNum);
		$monthName = $dateObj->format('F');
		return $monthName;
	  }	
?>