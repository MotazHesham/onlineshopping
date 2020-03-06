<?php

	 ob_start();//output buffering start
	 session_start();
	 $noNavbar='';
	 $pageTitle='Login';

	 //to Stay login to the webstie if the session have the UserName
		 if(isset($_SESSION['UserName'])){
		 	header("Location:dashboard.php");
		 }

	 include "init.php";

	 //login request

	 if($_SERVER['REQUEST_METHOD'] == 'POST'){

	 	$username = $_POST['username'];
	 	$password = $_POST['password'];
	 	$hashedpass = sha1($password);

	 	// Check The USer In Database
	 	$stmt = $con->prepare("SELECT
	 								*
	 						   FROM 
	 						   		users 
	 						   Where 
	 						   		UserName = ? 
	 						   AND  
	 						   		Password = ? 
	 						   AND 
	 						   		Role = 1");

	 	$stmt->execute(array($username,$hashedpass));
	 	$count = $stmt->rowCount();
	 	$row = $stmt->fetch();

	 	//if $count >0 This Mean the DataBase Contain Record abour this user name 
	 		if($count > 0){
	 			$_SESSION['UserName'] = $username;
	 			$_SESSION['UserID'] = $row['userID'];
	 			$_SESSION['fullname'] = $row['FullName'];
	 			$_SESSION['role'] = $row['Role'];
	 			header("Location:dashboard.php");
	 			exit();
	 		}

	 }

?>
	<div class="login-page">
		<div  class="container">
			<div class="center-page">
				<div class="side-form-img">
					<img src="../Uploads/profile_image/shape4.jpg">
				</div>
				<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
					<h4 class="text-center">Admin Login</h4>
					<input class="form-control" type="text" name="username" placeholder="UserName" autocomplete="off">
					<input class="form-control" type="password" name="password" placeholder="Password">
					<input class="btn btn-dark btn-block" type="submit" value="Login">
				</form>
			</div>
		</div>
	</div>


<?php 
	include $tpl . "footer.php";
	ob_end_flush();
?>