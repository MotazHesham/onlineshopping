<?php

	/*
	++++++++++++++++++++++++++++++++++++++++++++++
	+++++++
	=======	Users Page
	+++++++
	++++++++++++++++++++++++++++++++++++++++++++++
	*/

	ob_start(); // Output Buffering Start 
	
	session_start();

	$pageTitle = 'Users';

	if(isset($_SESSION['UserName']) && $_SESSION['role']==1){// this condation contain all the page 

		

		include "init.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if($do == "Manage"){//Manage Page 

			$stmt = $con -> prepare("SELECT * from users ORDER BY Date DESC");
			$stmt -> execute();
			$rows = $stmt->fetchAll();

		?>
		<div class="page-content">
			<div class="container text-center">
				<h1> Manage <span>Members</span></h1>
				<p>here you can manage all users in system ......edit or delete anyone</p>
			</div>

			<div class="row">
				<div class="col-md-3 offset-md-9">
					<a href='?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member</a>
				</div>
			</div>

			<div class="container">
				<div class="responsive-table">
					<table class="table main-table table-striped table-bordered dt-responsive nowrap text-center">
						<thead>
							<tr>
								<th>#ID</th>
								<th>UserName</th>
								<th>Email</th>
								<th>FullName</th>
								<th>Gender</th>
								<th>Age</th>
								<th>Register Date</th>
								<th>Control</th>
							</tr>	
						</thead>
						<?php 
							foreach ($rows as $user) {
							  echo "
								<tr>
									<td>" . $user['userID'] . "</td>
									<td>" . $user['UserName'] . "</td>
									<td>" . $user['Email'] . "</td>
									<td>" . $user['FullName'] . "</td>
									<td>" . $user['Gender'] . "</td>
									<td>" . $user['Age'] . "</td>
									<td>" . calculate_diff_date($user['Date']) . "</td>
									<td>
										<a href='?do=Edit&userid=" . $user['userID'] . "' class='btn btn-info'><i class='fas fa-user-edit'></i> Edit</a>
										<a href='?do=Delete&userid=" . $user['userID'] . "' class='btn btn-danger confirm'><i class='fas fa-trash'></i> Delete</a>
									</td>
								</tr>
								";
							}
						?>

					</table>	
				</div>
			</div>

		</div>

		<?php }elseif($do == "Add"){//add page

			 ?>
			 <div class="page-content">
			 	<div class="container text-center">
			 		<h1>Add New <span>Member</span></h1>
					<p>here you can add new user to can use your system...</p>
			 	</div>
				
				<div class="container">

					<form action="?do=Insert" method="POST">

						<!-- Fieldes (UserName & Password) -->
					  <div class="form-row">

					    <div class="form-group col-md-6">
					      <label for="inputUserName">UserName</label>
					      <input type="text" class="form-control" name="UserName" id="inputUserName" required="required" placeholder="3~14 Characher">
					    </div>

					    <div class="form-group col-md-6">
					      <label for="inputPassword">Password</label>
					      <input type="password" class="form-control" name="newPassword" id="inputPassword" required="required" placeholder="Choose Strong Password">
					    </div>

					  </div>
					  <!-- ............................. -->

					  <!-- Fieldes (FullName & Gender & Age) -->
					  <div class="form-row">

						<div class="form-group col-lg">
					      <label for="inputFullName">FullName</label>
					      <input type="text" class="form-control" name="FullName" id="inputFullName" required="required" placeholder="Can't be empty">
					    </div>

					  	<div class="form-group col-md-4">
					      <label for="inputState">Gender</label>
					      <select id="inputState" class="form-control" name="Gender" >
					      	<option value='Male'>Male</option>
					      	<option value='Female'>Female</option>
					      </select>
					    </div>

					    <div class="form-group col-md-2">
					      <label for="inputAge">Age</label>
					      <input type="text" class="form-control" name="Age"  id="inputAge" required="required" placeholder="must be number">
					    </div>

					  </div>  
					  <!-- ............................... -->

					  <!-- Fieldes (Email) -->
					  <div class="form-row">

					    <div class="form-group col-lg">
					      <label for="inputEmail4">E-mail</label>
					      <input type="email" class="form-control" name="Email" id="inputEmail4" required="required" placeholder="example@g.c"  >
					    </div>

					  </div>
					  <!-- ............ -->

					  <!-- Fieldes (Button) -->
					  <button type="submit" class="btn btn-primary btn-block">Add</button>
					  <!-- .............. -->

					</form>	

				</div>

             </div>
				<?php	
			
		}elseif($do == "Insert"){

		 	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		 		//Get Variables from The Form 
		 		$email 		= $_POST['Email'];
		 		$fullname 	= $_POST['FullName'];
		 		$age 		= $_POST['Age'];
		 		$username 	= $_POST['UserName'];
		 		$gender 	= $_POST['Gender'];
		 		$pass  		= $_POST['newPassword'];

		 		$hashdPass = sha1($_POST['newPassword']);
		 		

		 		/* ---------- Start Handling Fields validation ------------- */

		 		$ErrorsArray = array();

		 		if(strlen($username) < 3 || strlen($username) > 14){
		 			$ErrorsArray[] = 'UserName Must between 3~14 Charachters';
		 		}
		 		if(!is_numeric($age)){
		 			$ErrorsArray[] = 'Age must be a Number';
		 		}

		 		if(empty($username)){ $ErrorsArray[] = "UserName Can't be Empty"; }
		 		if(empty($pass)){ $ErrorsArray[] = "Password Can't be Empty"; }
		 		if(empty($age)){ $ErrorsArray[] = "Age Can't be Empty"; }
		 		if(empty($email)){ $ErrorsArray[] = "E-Mail Can't be Empty"; }
		 		if(empty($fullname)){ $ErrorsArray[] = "FullName Can't be Empty"; }

		 		//loop to echo the errors 
		 		foreach ($ErrorsArray as $error) {
		 			echo '<div class=" container alert alert-danger">' . $error . '</div>';
		 		}

		 		/* ---------- End Handling Fields validation ------------- */

		 		// if there is no errors start Inserting the record
			 		if(empty($ErrorsArray)){

			 			$check = Checkitem('UserName','users',$username);

			 			if($check == 1 ){

			 				$theMsg = "<div class='alert alert-danger container'>Sorry The UserName is Exist</div>";
			 				redirected($theMsg,'back',5);
			 			}else{

					 		//Insert into Database  
					 		$stmt = $con->prepare("INSERT INTO
					 									users ( UserName, Password, Email, FullName, Gender, Age,Date)
					 							   VALUES 
					 							   			  ( :user, :password, :email, :fullname, :gender, :age , now())
					 							   		");

					 		$stmt -> execute(array(
					 			'user' 	   	=> $username,
					 			'email'	    => $email,
					 			'fullname'	=> $fullname,
					 			'age' 		=> $age,
					 			'gender'	=> $gender,
					 			'password'	=> $hashdPass
					 		));

					 		$theMsg = "<div class='alert alert-success container' > " . $stmt -> rowCount() . " Record Inserted </div>";
			 				redirected($theMsg);
			 			}
			 		}

			}else{
			  $theMsg= "<div class='alert alert-danger container'>you cant access this page direct</div>";
			  redirected($theMsg);
			}

	 	}elseif($do == "Edit"){//Edit Page

			//Check Get Request userid is numeric & get the integer value of it 
			$userid= isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

			//Select Data Depend On ID
			$stmt = $con->prepare("SELECT * FROM users Where userID = ? ");
		 	$stmt->execute(array($userid));
		 	$count = $stmt->rowCount();
		 	$row = $stmt->fetch();

		 	if($count > 0 ){ ?>
				<div class="page-content">		
					<div class="container text-center">
				 		<h1>Edit <span>Profile</span></h1>
						<p>here you can edit profiles...like (add newphoto,change name,etc.....)</p>
				 	</div>

					<div class="container">

						<form action="?do=Update" method="POST">

							<!-- hidden input to send userid through from  -->
							<input type="hidden" name="userid" value="<?php echo $userid;?>">

							<!-- Fieldes (UserName & Password) -->
						  <div class="form-row">

						    <div class="form-group col-md-6">
						      <label for="inputUserName">UserName</label>
						      <input type="text" class="form-control" name="UserName" value="<?php echo $row['UserName'];?>" id="inputUserName" required="required">
						    </div>

						    <div class="form-group col-md-6">
						      <label for="inputPassword">Password</label>
						      <input type="hidden" class="form-control" name="oldPassword" value="<?php echo $row['Password'];?>" id="inputPassword" >
						      <input type="password" class="form-control" name="newPassword" id="inputPassword" placeholder="optional...">
						    </div>

						  </div>
						  <!-- ............................. -->

						  <!-- Fieldes (FullName & Gender & Age) -->
						  <div class="form-row">

							<div class="form-group col-lg">
						      <label for="inputFullName">FullName</label>
						      <input type="text" class="form-control" name="FullName" value="<?php echo $row['FullName'];?>" id="inputFullName" required="required">
						    </div>

						  	<div class="form-group col-md-4">
						      <label for="inputState">Gender</label>
						      <select id="inputState" class="form-control" name="Gender" >
						      	<?php   
						      			$male_selected = '';
						      			$female_selected = '';

						      			if($row['Gender']=="Male"){
						      				$male_selected = 'selected';
						      			}elseif($row['Gender'=="Female"]){
						      				$female_selected = 'selected';
						      			}
						      			echo "<option " . $male_selected . "  value='Male'>Male</option>";
						      			echo "<option " . $female_selected . "  value='Female'>Female</option>";    	 

						      	?> 
						      </select>
						    </div>

						    <div class="form-group col-md-2">
						      <label for="inputAge">Age</label>
						      <input type="text" class="form-control" name="Age" value="<?php echo $row['Age'];?>" id="inputAge" required="required">
						    </div>

						  </div>  
						  <!-- ............................... -->

						  <!-- Fieldes (Email) -->
						  <div class="form-row">

						    <div class="form-group col-lg">
						      <label for="inputEmail4">E-mail</label>
						      <input type="email" class="form-control" name="Email" id="inputEmail4" placeholder="example@g.c" required="required"  value="<?php echo $row['Email'];?> ">
						    </div>

						  </div>
						  <!-- ............ -->

						  <!-- Fieldes (Button) -->
						  <button type="submit" class="btn btn-primary btn-block">Update</button>
						  <!-- .............. -->

						</form>	

					</div>	
				</div>	
		<?php		
			}else{
				$theMsg = "<div class='alert alert-danger container'>There is no Such id</div>";
				redirected($theMsg);
			}

	 }elseif($do == "Update"){

	 	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	 		//Get Variables from The Form 
	 		$id 		= $_POST['userid'];
	 		$email 		= $_POST['Email'];
	 		$fullname 	= $_POST['FullName'];
	 		$age 		= $_POST['Age'];
	 		$username 	= $_POST['UserName'];
	 		$gender 	= $_POST['Gender'];

	 		//password trick
	 		$pass = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);
	 		

	 		/* ---------- Start Handling Fields validation ------------- */

	 		$ErrorsArray = array();

	 		if(strlen($username) < 3 || strlen($username) > 14){
	 			$ErrorsArray[] = 'UserName Must between 3~14 Charachters';
	 		}
	 		if(!is_numeric($age)){
	 			$ErrorsArray[] = 'Age must be a Number';
	 		}

	 		if(empty($username)){ $ErrorsArray[] = "UserName Can't be Empty"; }
	 		if(empty($age)){ $ErrorsArray[] = "Age Can't be Empty"; }
	 		if(empty($email)){ $ErrorsArray[] = "E-Mail Can't be Empty"; }
	 		if(empty($fullname)){ $ErrorsArray[] = "FullName Can't be Empty"; }

	 		//loop to echo the errors 
	 		foreach ($ErrorsArray as $error) {
	 			echo '<div class=" container alert alert-danger">' . $error . '</div>';
	 		}

	 		/* ---------- End Handling Fields validation ------------- */

	 		// if there is no errors start updating the record
	 		if(empty($ErrorsArray)){

	 			$check = Checkitem_update('UserName','userID','users',$username,$id);

			 	if($check == 1 ){

			 		$theMsg = "<div class='alert alert-danger container'>Sorry The UserName is Exist</div>";
			 		redirected($theMsg,'back',5);

			 	}else{

			 		//Update Database with new info
			 		$stmt = $con->prepare("UPDATE
			 									users 
			 							   SET 
			 							   		UserName = ?,
			 							   		Email = ?, 
			 							   		FullName = ?,
			 							   		Age = ?,
			 							   		Gender = ?,
			 							   		Password = ?
			 							   Where
			 							   		userID =$id");

			 		$stmt -> execute(array($username,$email,$fullname,$age,$gender,$pass));
			 		$theMsg = "<div class=' container alert alert-success container' > " . $stmt -> rowCount() . " Record Updated </div>";
		 			redirected($theMsg,'back');
		 		}	
	 		}

	 	}else{
	 		$theMsg =  "<div class=' container alert alert-danger container' > you cant access this page direct </div>";
	 		redirected($theMsg);
	 	}
	 }elseif($do == "Delete"){//delete page 

	 		//Check Get Request userid is numeric & get the integer value of it 
			$userid= isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

			$check = Checkitem("userID","users",$userid);

		 	if($check > 0 ){ 
		 		$stmt =$con ->prepare("DELETE FROM users Where userID = :userid");
		 		$stmt -> bindParam(":userid", $userid);
		 		$stmt ->execute();
		 		$theMsg = "<div class='alert alert-success container' > " . $stmt -> rowCount() . " Record Deleted </div>";
		 		redirected($theMsg);
		 	}else{
		 		$theMsg = "<div class='alert alert-danger container'>This userID Not Exist</div>";
		 		redirected($theMsg);
		 	}

	 }
		
	 	//end of the page 
		include $tpl . "footer.php";

	}else{// if there is no session with username -> redirect to the login page
		header("Location:index.php");
		exit();
	}

	ob_end_flush();
?>

