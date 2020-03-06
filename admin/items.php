<?php
	/*
	++++++++++++++++++++++++++++++++++++++++++++++
	+++++++
	=======	Items Page
	+++++++
	++++++++++++++++++++++++++++++++++++++++++++++
	*/

	ob_start(); // Output Buffering Start 

	session_start();

	$pageTitle='Items';

	if(isset($_SESSION['UserName']) && $_SESSION['role']==1){// this condation contain all the page

		include "init.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if($do == 'Manage'){
			?>
			<div class="page-content">
				<div class="container text-center">
					<h1>Manage Your <span>Items</span></h1>
					<p>here you can manage all your items in shop ...edit or delete anything</p>
				</div>

				<div class="manage-items text-center">
					<div class="container">

					    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #eaeaea;">

						  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						    <span class="navbar-toggler-icon"></span>
						  </button>

						  <div class="collapse navbar-collapse" id="navbarNavDropdown">

						    <ul class="navbar-nav">

						      <li class="nav-item">
						        <a class="nav-link" onclick="showitems('all')" style="cursor: pointer;">All</a>
						      </li>

						      <li class="nav-item">
						      	<form action="">
							        <select class="nav-link" style="background-color:#eaeaea;border:0;" onchange="showitems(this.value)">
							        <?php
							        		$stmt = $con -> prepare("SELECT * FROM categories");
							        		$stmt -> execute();
							        		$Categories = $stmt -> fetchAll();
							        		echo '<option value="">Categories</option>';
							        		foreach ($Categories as $category) {
							        			echo '<option value="' . $category['ID'] . '">' . $category['Name'] . '</option>';
							        		} 
							        ;?>
							        </select>
						    	</form>
						      </li>

						      <li class="nav-item">
						      	<a href='?do=Add' class="btn btn-link align-self-end"><i class="fa fa-plus"></i> Add New item</a>
						      </li>

						    </ul>

						  </div>

						</nav>

					</div>

					<div class="select-cat"></div>

					<div class="item-view" id="category-select">
						<?php
							$stmt = $con -> prepare("SELECT * FROM items");
							$stmt -> execute();
							$All_Items = $stmt->fetchAll();

								foreach($All_Items as $item){
									echo'<div class="card item-part" style="width: 18rem;">';
									  echo'<img src="../Uploads/items_image/' . $item['img'] . '" class="img-thumbnail" style="height:170px">';
									  echo'<div class="card-body">';
									    echo'<h2 class="card-title">' . $item['Name'] . '</h2>';
									    echo'<h6 class="card-subtitle mb-2 text-muted">' . $item['Description'] . '</h6>';
									  echo'</div>';
									  echo '<div class="item-part-overlay">';
									  	echo '<a href="?do=Edit&&item_id=' . $item["item_ID"] . '" style="color: white;" class="btn btn-primary"><i class="far fa-edit"></i> Edit</a>';
									  	echo '<a href="?do=Delete&&item_id=' . $item["item_ID"] . '" style="color: white;" class="btn btn-danger confirm"><i class="fas fa-trash"></i> Delete</a><br><br>';
									 	if($item['Approve'] == 0){
									 		echo '<a href="?do=Approve&&item_id=' . $item["item_ID"] . '" style="color: white;" class="btn btn-info"><i class="fas fa-check"></i> Approve</a>';
									 	}
									  echo '</div>';
									echo'</div>';
								};
						?>	
						<div class="clear"></div><!-- this div for clearing float  -->
					</div>
					
				</div>

			</div>	

			<?php

		}elseif($do == 'Add'){
			?>
			<div class="page-content">

				<div class="container text-center">
					<h1>Add New <span>Item</span></h1>
					<p>here you can add new items to specific category and view it to all customers .....</p>
				</div>

				<div class="container">

					<form action="?do=Insert" method="POST" enctype="multipart/form-data">

					  <div class="form-row"><!-- this has two [col] first for img and second for fields of the form   -->

					  	<!-- $$$$$$$$$$$$ Start first [col] Image $$$$$$$$$ -->
					  	<div class="form-group col-lg-6 col-md-7 upload-img">

					    	
					    	<input type="file" id="upload" class="form-control" name="img" style="" />
					    	<img id="img" src="../Uploads/items_image/empty.jpg" name="img">
					    	<!-- overlay upload img  -->
					    	<div class="overlay-upload-img text-center">
					    		<div><i class="far fa-edit"></i> Edit</div>
					    	</div>

					    </div>
						<!-- $$$$$$$$$$$$ End first [col] Image $$$$$$$$$ -->


						<!-- @@@@@@@@@@@ Start Second [col] form fields @@@@@@@@@@@-->
					    <div class="form-group col-lg-6 col-md-6">

					      <!-- Fieldes (Name & country_made) -->
						  <div class="form-row">

						    <div class="form-group col-md-6">
						      <label for="inputName">Name</label>
						      <input type="text" class="form-control" name="name" id="inputName" required="required" placeholder="Name of item">
						    </div>

						    
							<div class="form-group col-lg">
						      <label for="inputcountrymade">Country Made</label>
						      <input type="text" required="required" class="form-control" name="country_made" id="inputcountrymade" placeholder="Made In ?">
						    </div>

						  </div>
						  <!-- ............................. -->

						  <!-- Fieldes (Description & Price) -->
						  <div class="form-row">

							<div class="form-group col">
						      <label for="inputDesc">Description</label>
						      <input type="text" class="form-control" name="description" id="inputDesc"  placeholder="Describe The Item" required="required">
						    </div>

						    <div class="form-group col">
						      <label for="inputprice">Price</label>
						      <input type="text" class="form-control" name="price" id="inputprice"  placeholder="" required="required">
						    </div>

						  </div>  
						  <!-- ............................... -->

						  <!-- Fieldes Categoris -->
						  <div class="form-row">

						    <div class="form-group col">
						      <label for="inputcategory">Categories</label>
						      <select id="inputcategory" class="form-control" name="category" >
						      	<?php
						      	 	$stmt = $con -> prepare("SELECT * FROM categories");
						      	 	$stmt -> execute();
						      	 	$Categories = $stmt -> fetchAll();

						      	 	foreach ($Categories as $category ){
						      	 		echo "<option value='" . $category['ID'] . "'>" . $category['Name'] . "</option>";
						      	 	}
						      	?>
						      </select>
						    </div>

						  </div>  
						  <!-- ............................... -->

						  <!-- Fieldes (Button) -->
						  <button type="submit" class="btn btn-primary btn-block">Add</button>
						  <!-- .............. -->

					    </div>
					    <!-- @@@@@@@@@@@ End Second [col] form fields @@@@@@@@@@@--> 
					  	
					  </div><!-- end of div that has two [col] --> 

					</form>	
				</div>

			</div>	

			<?php

		}elseif($do == 'Insert'){

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				//get the admin id ... to know who insert the item
				$user_id = $_SESSION['UserID'];

				$name 			= $_POST['name'];
				$description 	= $_POST['description'];
				$country_made	= $_POST['country_made'];
				$price 			= $_POST['price'];
				$category_id 	= $_POST['category'];
				$ErrorsArray 	= array();


				$image_Name		= $_FILES['img']['name'];

				if($image_Name == ''){//if user didn't choose image

					$image_Name = 'empty.jpg';

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

		 		if(strlen($name) < 3 || strlen($name) > 14){
		 			$ErrorsArray[] = 'Name Must between 3~14 Charachters';
		 		}

		 		if(empty($name)){ $ErrorsArray[] = "name Can't be Empty"; }
		 		if(empty($description)){ $ErrorsArray[] = "description Can't be Empty"; }
		 		if(empty($country_made)){ $ErrorsArray[] = "country_made Can't be Empty"; }
		 		if(empty($price)){ $ErrorsArray[] = "price Can't be Empty"; }

		 		//loop to echo the errors 
		 		foreach ($ErrorsArray as $error) {
		 			echo '<div class=" container alert alert-danger">' . $error . '</div>';
		 		}

		 		/* ---------- End Handling Fields validation ------------- */

		 		//if there is no error ...so start insert into database
		 		if(empty($ErrorsArray)){

		 			//if user choose image move to uploads folder
		 			if($image_Name !== "empty.jpg"){
			 			$image_Name = rand(0,1000000) . '_' . $image_Name; // to ensure that name of image will not be repeat
			 			//move image to project file name uploads
			 			move_uploaded_file($image_Tmp, '../Uploads/items_image/' . $image_Name);
		 			}

		 			$stmt = $con -> prepare("INSERT INTO
					 									items ( Name, Description, Country_Made, Price, img, user_id , Category_id, Add_Date)
					 							   VALUES 
					 							   			  ( :zname, :zdesc, :zcountry_made, :zprice, :zimg, :zuser_id, :zcategory_id , now())
					 							   		");
		 			$stmt -> execute(array(
		 				'zname'			 	=> $name,
		 				'zprice'			=> $price,
		 				'zdesc'				=> $description,
		 				'zcountry_made' 	=> $country_made,
		 				'zimg'				=> $image_Name,
		 				'zuser_id'			=> $user_id,
		 				'zcategory_id'		=> $category_id
		 			));

		 			$theMsg = "<div class='alert alert-success container' > " . $stmt -> rowCount() . " Record Inserted </div>";
			 		redirected($theMsg);
		 		}


			}else{
				$theMsg = '<div class="alert alert-danger container">You Cant access this page direct</div>';
				redirected($theMsg);
			}

		}elseif($do == 'Edit'){

			//Check Get Request item[Id] is numeric & get the integer value of it 
			$item_id= isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0 ;
			$stmt = $con -> prepare("SELECT
										 *
									 From
									 	 items
									 WHERE
									 	 item_ID = ?");
			$stmt -> execute(array($item_id));
			$count = $stmt->rowCount();
		 	$item = $stmt->fetch();

		 	if($count > 0){

			?>
			<div class="page-content">

				<div class="container text-center">
					<h1>Edit [<span><?php echo $item['Name'];?></span>] item </h1>
					<p>here you can edit your item ....like (name,description.....etc)</p>
				</div>

				<div class="Edit-item-div">

					<div class="container">

						<form action="?do=Update" method="POST" enctype="multipart/form-data">


						  <div class="form-row"><!-- this has two [col] first for img and second for fields of the form   -->

						  	<!-- $$$$$$$$$$$$ Start first [col] Image $$$$$$$$$ -->
							    <div class="form-group col-lg-6 col-md-7 upload-img">

							    	
							    	<input type="file" id="upload" class="form-control" name="img" style="" />
							    	<img id="img" src="../Uploads/items_image/<?php echo $item['img'];?>" name="img" >
							    	<!-- overlay upload img  -->
							    	<div class="overlay-upload-img text-center">
							    		<div><i class="far fa-edit"></i> Edit</div>
							    	</div>
							    	<!-- get the name of old img -->
							    	<input type="test" name="oldimg" value="<?php echo $item['img'];?>" hidden = "">
							    </div>
						    <!-- $$$$$$$$$$$$ End first [col] Image $$$$$$$$$ -->



						   <!-- @@@@@@@@@@@ Start Second [col] form fields @@@@@@@@@@@-->
						    <div class="form-group col-lg-6 col-md-6">

						      <!-- Fieldes (Name & country_made) -->
							  <div class="form-row">

							  
							    <div class="form-group col-md-6">
							      <label for="inputName">Name</label>
							      <input type="text" class="form-control" name="name" id="inputName" required="required" placeholder="Name of item" value="<?php echo $item['Name'];?>">
							    </div>

							    
								<div class="form-group col-lg">
							      <label for="inputcountrymade">Country Made</label>
							      <input type="text" required="required" class="form-control" name="country_made" id="inputcountrymade" placeholder="Made In ?" value="<?php echo $item['Country_Made'];?>">
							    </div>

							  </div>
							  <!-- ............................. -->

							  <!-- Fieldes (Description & Price & input hidden [id]) -->
							  <div class="form-row">

							  	<!-- id -->
								  <input type="hidden" name="id" value="<?php echo $item['item_ID'];?>">

								<div class="form-group col">
							      <label for="inputDesc">Description</label>
							      <input type="text" class="form-control" name="description" id="inputDesc"  placeholder="Describe The Item" required="required" value="<?php echo $item['Description'];?>">
							    </div>

							    <div class="form-group col">
							      <label for="inputprice">Price</label>
							      <input type="text" class="form-control" name="price" id="inputprice"  placeholder="" required="required" value="<?php echo $item['Price'];?>">
							    </div>

							  </div>  
							  <!-- ............................... -->

							  <!-- Fieldes Categoris -->
							  <div class="form-row">

							    <div class="form-group col">
							      <label for="inputcategory">Categories</label>
							      <select id="inputcategory" class="form-control" name="category" >
							      	<?php
							      	 	$stmt = $con -> prepare("SELECT * FROM categories");
							      	 	$stmt -> execute();
							      	 	$Categories = $stmt -> fetchAll();

							      	 	foreach ($Categories as $category ){
							      	 		if($item['Category_id'] == $category["ID"]){
							      	 			echo "<option selected value='" . $category['ID'] . "'>" . $category['Name'] . "</option>";
							      	 		}else{
							      	 			echo "<option value='" . $category['ID'] . "'>" . $category['Name'] . "</option>";
							      	 		}	
							      	 	}
							      	?>
							      </select>
							    </div>

							    <div class="form-group col">
							      <label for="inputseller">Seller</label>
							      <select id="inputseller" class="form-control" name="seller_name" >
							      	<?php
							      	 	$stmt = $con -> prepare("SELECT * FROM users");
							      	 	$stmt -> execute();
							      	 	$users = $stmt -> fetchAll();

							      	 	foreach ($users as $user ){
							      	 		if($item['user_id'] == $user["userID"]){
							      	 			echo "<option selected value='" . $user['userID'] . "'>" . $user['FullName'] . "</option>";
							      	 		}else{
							      	 			echo "<option value='" . $user['userID'] . "'>" . $user['FullName'] . "</option>";
							      	 		}	
							      	 	}
							      	?>
							      </select>
							    </div>

							   </div> 
							  <!-- ............................... -->


							  <!-- Fieldes (Button) -->
							  <button type="submit" class="btn btn-primary btn-block">Update</button>
							  <!-- .............. -->

						    </div>
						    <!-- @@@@@@@@@@@ End Second [col] form fields @@@@@@@@@@@--> 
						  	
						  </div><!-- end of div that has two [col] --> 

						</form>	

					</div><!-- end of div that has class (container) -->

				</div><!-- end of div that has class (edit-category-div) -->

			</div>	
			<?php
				}else{
					$theMsg = "<div class='alert alert-danger container'>There is no Such this item</div>";
					redirected($theMsg);
				}

		}elseif($do == 'Update'){

			if($_SERVER['REQUEST_METHOD'] ==  'POST'){

				$name 			= $_POST['name'];
				$description 	= $_POST['description'];
				$price 			= $_POST['price'];
				$country_made 	= $_POST['country_made'];
				$seller_name 	= $_POST['seller_name'];
				$category 		= $_POST['category'];
				$id 			= $_POST['id'];
				$old_image		= $_POST['oldimg'];
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

		 		if(strlen($name) < 3 || strlen($name) > 14){
		 			$ErrorsArray[] = 'Name Must between 3~14 Charachters';
		 		}

		 		if(empty($name)){ $ErrorsArray[] = "name Can't be Empty"; }
		 		if(empty($description)){ $ErrorsArray[] = "description Can't be Empty"; }
		 		if(empty($country_made)){ $ErrorsArray[] = "country_made Can't be Empty"; }
		 		if(empty($price)){ $ErrorsArray[] = "price Can't be Empty"; }

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
			 			move_uploaded_file($image_Tmp, '../Uploads/items_image/' . $image_Name);
		 			}
			     	


				    $stmt = $con -> prepare("UPDATE
			 									items 
				 							   SET 
				 							   		Name = ?,
				 							   		Description = ?, 
				 							   		img = ?,
				 							   		Price = ?,
				 							   		Country_Made = ?,
				 							   		Category_id = ?,
				 							   		user_id = ?
				 							   Where
				 							   		item_ID =$id");
				    $stmt -> execute(array($name,$description,$image_Name,$price,$country_made,$category,$seller_name));
				    $theMsg = "<div class=' container alert alert-success container' > " . $stmt -> rowCount() . " Record Updated </div>";
		 			redirected($theMsg,'back');
		 		}	

			}else{
				$theMsg = "<div class='alert alert-danger container'>You Can't Access this page direct</div>";
				redirected($theMsg);
			}


		}elseif($do == 'Delete'){

			//Check Get Request item_id is numeric & get the integer value of it 
			$id= isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0 ;
			$check = Checkitem("item_id","items",$id);	


			if($check > 0){
				$stmt = $con -> prepare("DELETE FROM items WHERE item_ID = ?");
				$stmt -> execute(array($id));
				$theMsg = "<div class='alert alert-success container' > " . $stmt -> rowCount() . " Record Deleted </div>";
		 		redirected($theMsg,'back');
			}else{
				$theMsg = "<div class='alert alert-danger container'>There is no item with this id Not Exist</div>";
		 		redirected($theMsg,'back');
			}

		}elseif($do == 'Approve'){

			//Check Get Request item_id is numeric & get the integer value of it 
			$id= isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0 ;
			$check = Checkitem("item_id","items",$id);

			if($check > 0){
				$stmt = $con -> prepare("UPDATE items SET Approve = 1  WHERE item_ID = ?");
				$stmt -> execute(array($id));
				$theMsg = "<div class='alert alert-success container' > " . $stmt -> rowCount() . " Item Approved </div>";
		 		redirected($theMsg,'back');
			}else{
				$theMsg = "<div class='alert alert-danger container'>There is no item with this id Not Exist</div>";
		 		redirected($theMsg,'back');
			}

		}

		include $tpl . 'footer.php' ;

	}else{

		header("Location:index.php");

		exit();
		
	}	