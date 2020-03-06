<?php


	/*
	++++++++++++++++++++++++++++++++++++++++++++++
	+++++++
	=======	Profile Page
	+++++++
	++++++++++++++++++++++++++++++++++++++++++++++
	*/

	ob_start(); // Output Buffering Start 

	session_start();

	$id = $_SESSION['front_userid'];
	$pageTitle= 'Profile info';

	if(isset($_SESSION['front_username'])){// this condation contain all the page

		include "init.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'profile';

		$user = get_record("*","users","userID = $id");
		if($do == 'profile'){
		?>	
			<div class="container text-center">
				<h1><span><?php echo $user['FullName']?></span></h1>
				<p>.......</p>
			</div>
			<div class="container">
				<div class="row">

					<div class="col">
						<div class="upload-img">
							<img id="img" src="Uploads/profile_image/<?php echo $user['img'] ?>" name="img">
						</div>
					</div>

					<div class="col">
						<div class="card">
						  <h5 class="card-header text-center">Profile Info</h5>
						  <div class="card-body profile-info">
						    <div>Full Name : <span><?php echo $user['FullName'] ?></span> </div>
						    <div>Username : <span><?php echo $user['UserName'] ?></span> </div>
						    <div>Email : <span><?php echo $user['Email'] ?></span> </div>
						    <div>Age : <span><?php echo $user['Age'] ?></span> </div>
						    <div>Gender : <span><?php echo $user['Gender'] ?></span> </div>
						    <a href="?do=edit&&user_id=<?php echo $user['userID'];?>" class="btn btn-info btn-block">Edit</a>
						  </div>
						</div>
					</div>

				</div>
			</div>
		<?php
		}elseif($do == 'edit'){
			
			//Check Get Request item[Id] is numeric & get the integer value of it 
			$user_id= isset($_GET['user_id']) && is_numeric($_GET['user_id']) ? intval($_GET['user_id']) : 0 ;
			$stmt = $con -> prepare("SELECT
										 *
									 From
									 	 users
									 WHERE
									 	 userID = ?");
			$stmt -> execute(array($user_id));
			$count = $stmt->rowCount();
		 	$user = $stmt->fetch();

		 	if($count > 0){

			?>

				<div class="container text-center">
					<h1>Edit [<span><?php echo $user['FullName'];?></span>] Profile </h1>
					<p>here you can edit your info ....like (name,age.....etc)</p>
				</div>

				<div class="edit-profile-div">

					<div class="container">

						<form action="?do=update" method="POST" enctype="multipart/form-data">


						  <div class="form-row"><!-- this has two [col] first for img and second for fields of the form   -->

						  	<!-- $$$$$$$$$$$$ Start first [col] Image $$$$$$$$$ -->
							    <div class="form-group col-lg-6 col-md-7 upload-img">

							    	<input type="file" id="upload" class="form-control" name="img" style="" />
							    	<img id="img" src="Uploads/profile_image/<?php echo $user['img'];?>" name="img" >
							    	<!-- overlay upload img  -->
							    	<div class="overlay-upload-img text-center">
							    		<div><i class="far fa-edit"></i> Edit</div>
							    	</div>
							    	<!-- get the name of old img -->
							    	<input type="test" name="oldimg" value="<?php echo $user['img'];?>" hidden = "">
							    </div>
						    <!-- $$$$$$$$$$$$ End first [col] Image $$$$$$$$$ -->



						   <!-- @@@@@@@@@@@ Start Second [col] form fields @@@@@@@@@@@-->
						    <div class="form-group col-lg-6 col-md-6">

							     	<!-- hidden input to send userid through from  -->
								<input type="hidden" name="userid" value="<?php echo $user_id;?>">

								<!-- Fieldes (UserName & Password) -->
							  <div class="form-row">

							    <div class="form-group col-md-6">
							      <label for="inputUserName">UserName</label>
							      <input type="text" class="form-control" name="UserName" value="<?php echo $user['UserName'];?>" id="inputUserName" required="required">
							    </div>

							    <div class="form-group col-md-6">
							      <label for="inputPassword">Password</label>
							      <input type="hidden" class="form-control" name="oldPassword" value="<?php echo $user['Password'];?>" id="inputPassword" >
							      <input type="password" class="form-control" name="newPassword" id="inputPassword" placeholder="optional...">
							    </div>

							  </div>
							  <!-- ............................. -->

							  <!-- Fieldes (FullName & Gender & Age) -->
							  <div class="form-row">

								<div class="form-group col-lg">
							      <label for="inputFullName">FullName</label>
							      <input type="text" class="form-control" name="FullName" value="<?php echo $user['FullName'];?>" id="inputFullName" required="required">
							    </div>

							  	<div class="form-group col-md-4">
							      <label for="inputState">Gender</label>
							      <select id="inputState" class="form-control" name="Gender" >
							      	<?php   
							      			$male_selected = '';
							      			$female_selected = '';

							      			if($user['Gender']=="Male"){
							      				$male_selected = 'selected';
							      			}elseif($user['Gender'=="Female"]){
							      				$female_selected = 'selected';
							      			}
							      			echo "<option " . $male_selected . "  value='Male'>Male</option>";
							      			echo "<option " . $female_selected . "  value='Female'>Female</option>";    	 

							      	?> 
							      </select>
							    </div>

							    <div class="form-group col-md-2">
							      <label for="inputAge">Age</label>
							      <input type="text" class="form-control" name="Age" value="<?php echo $user['Age'];?>" id="inputAge" required="required">
							    </div>

							  </div>  
							  <!-- ............................... -->

							  <!-- Fieldes (Email) -->
							  <div class="form-row">

							    <div class="form-group col-lg">
							      <label for="inputEmail4">E-mail</label>
							      <input type="email" class="form-control" name="Email" id="inputEmail4" placeholder="example@g.c" required="required"  value="<?php echo $user['Email'];?> ">
							    </div>

							  </div>
							  <!-- ............ -->

							  <!-- Fieldes (Button) -->
							  <button type="submit" class="btn btn-primary btn-block">Update</button>
							  <!-- .............. -->

						    </div>
						    <!-- @@@@@@@@@@@ End Second [col] form fields @@@@@@@@@@@--> 
						  	
						  </div><!-- end of div that has two [col] --> 

						</form>	

					</div><!-- end of div that has class (container) -->

				</div><!-- end of div that has class (edit-profile-div) -->

		
		<?php		
			}else{
				$theMsg = "<div class='alert alert-danger container'>There is no Such id</div>";
				redirected($theMsg);
			}

		}elseif($do == 'update'){
			
			if($_SERVER['REQUEST_METHOD'] ==  'POST'){

				//Get Variables from The Form 
		 		$id 		= $_POST['userid'];
		 		$email 		= filter_var($_POST['Email'],FILTER_SANITIZE_EMAIL);
		 		$fullname 	= filter_var($_POST['FullName'],FILTER_SANITIZE_STRING);
		 		$age 		= filter_var($_POST['Age'],FILTER_SANITIZE_NUMBER_INT);
		 		$username 	= filter_var($_POST['UserName'],FILTER_SANITIZE_STRING);
		 		$gender 	= $_POST['Gender'];
		 		$old_image 	= $_POST['oldimg'];

		 		//password trick
		 		$pass = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);
		 		
				$ErrorsArray	= array();

				$image_Name		= $_FILES['img']['name'];

				if($image_Name == ''){//if user didn't choose image get the name of old image from the hidden input in form

					$image_Name = $old_image;

				}else{

					$image_Type		= $_FILES['img']['type'];
					$image_Tmp		= $_FILES['img']['tmp_name'];
					$image_Size		= $_FILES['img']['size'];
					$img_extention 	= strtolower( end( explode('.', $image_Name) ) );

					//List of allowed file typed to upload
					$allowed_img_extention	= array("jpeg" , "jpg" , "png" , "gif");


			 		if(! in_array($img_extention, $allowed_img_extention)){
			 		 $ErrorsArray[] = "The extention of File You uploaded <Strong> not allowed </Strong>";
			 		}
			 		if($image_Size > 4194304){
			 		 $ErrorsArray[] = "Your image cant be larger than <Strong>4MB</Strong>"; 
			 		}

				}

				/* ---------- Start Handling Fields validation ------------- */

			 		if(strlen($username) < 3 || strlen($username) > 14){
			 			$ErrorsArray[] = 'username Must between 3~14 Charachters';
			 		}
			 		if(!is_numeric($age)){
		 				$ErrorsArray[] = 'Age must be a Number';
		 			}

			 		if(empty($username)){ $ErrorsArray[] = "username Can't be Empty"; }
			 		if(empty($age)){ $ErrorsArray[] = "age Can't be Empty"; }
			 		if(empty($fullname)){ $ErrorsArray[] = "fullname Can't be Empty"; }
			 		if(empty($email)){ $ErrorsArray[] = "email Can't be Empty"; }

			 		//loop to echo the errors 
			 		foreach ($ErrorsArray as $error) {
			 			echo '<div class=" container alert alert-danger">' . $error . '</div>';
			 		}

		 		/* ---------- End Handling Fields validation ------------- */

		 		//if there is no error ...so start insert into database
		 		if(empty($ErrorsArray)){

		 			//if user choose image move to uploads folder
		 			if($image_Name !== $old_image){
			 			$image_Name = rand(0,1000000) . '_' . $image_Name; // to ensure that name of image will not be repeat
			 			//move image to project file name uploads
			 			move_uploaded_file($image_Tmp, 'Uploads/profile_image/' . $image_Name);
		 			}
			     	


				    $stmt = $con -> prepare("UPDATE
			 										users 
				 							   SET 
				 							   		UserName = ?,
				 							   		Age = ?, 
				 							   		Gender = ?,
				 							   		Email = ?,
				 							   		img = ?,
				 							   		FullName = ?
				 							   Where
				 							   		userID =$id");
				    $stmt -> execute(array($username,$age,$gender,$email,$image_Name,$fullname));
				    $theMsg = "<div class=' container alert alert-success container' > " . $stmt -> rowCount() . " Record Updated </div>";
		 			redirected($theMsg,'back');
		 		}	

			}else{
				$theMsg = "<div class='alert alert-danger container'>You Can't Access this page direct</div>";
				redirected($theMsg);
			}


		}

		include $tpl . 'footer.php' ;

	}else{

		header("Location:index.php");

		exit();
		
	}	
	ob_end_flush();
?>