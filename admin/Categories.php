<?php


	/*
	++++++++++++++++++++++++++++++++++++++++++++++
	+++++++
	=======	Categories Page
	+++++++
	++++++++++++++++++++++++++++++++++++++++++++++
	*/

	ob_start(); // Output Buffering Start 

	session_start();

	$pageTitle='Categories';

	if(isset($_SESSION['UserName']) && $_SESSION['role']==1){// this condation contain all the page

		include "init.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if($do == 'Manage'){

			?>
			<div class="page-content">
				<div class="container text-center">
					<h1>Manage Your <span>Categories</span></h1>
					<p>here you can manage all your categories... edit and delete whatever you want</p>
				</div>

				<div class="manage-category text-center">
					<div class="container">

						<div class="row">
							<div class="col-md-3 offset-md-8">
								<a href='?do=Add' class="btn btn-primary align-self-end"><i class="fa fa-plus"></i> Add New Category</a>
							</div>
						</div>
						
					</div>
					<div class="category-view">
							<?php

							$stmt = $con -> prepare("SELECT * FROM categories ORDER BY Ordering ASC");
							$stmt -> execute();
							$All_Categories = $stmt->fetchAll();

								foreach($All_Categories as $Category){
									echo'<div class="card category-part" style="width: 18rem;">';
									  echo'<img src="../Uploads/categories_image/' . $Category['img'] . '" class="img-thumbnail" style="height:170px">';
									  echo'<div class="card-body">';
									    echo'<h2 class="card-title">' . $Category['Name'] . '</h2>';
									    echo'<h6 class="card-subtitle mb-2 text-muted">' . $Category['Description'] . '</h6>';
									  echo'</div>';
									  echo '<div class="category-part-overlay">';
									  	echo '<a href="?do=Edit&&category_id=' . $Category["ID"] . '" style="color: white;" class="btn btn-primary"><i class="far fa-edit"></i> Edit</a>';
									  	echo '<a href="?do=Delete&&category_id=' . $Category["ID"] . '" style="color: white;" class="btn btn-danger confirm"><i class="fas fa-trash"></i> Delete</a>';
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
					<h1>Add New <span>Category</span></h1>
					<p>here you can add new category to your shop..</p>
				</div>

					<div class="container">

						<form action="?do=Insert" method="POST" enctype="multipart/form-data">

						  <div class="form-row"><!-- this has two [col] first for img and second for fields of the form   -->

						  	<!-- $$$$$$$$$$$$ Start first [col] Image $$$$$$$$$ -->
						  	<div class="form-group col-lg-6 col-md-7 upload-img">

						    	
						    	<input type="file" id="upload" class="form-control" name="img" style="" />
						    	<img id="img" src="../Uploads/categories_image/empty.jpg" name="img">
						    	<!-- overlay upload img  -->
						    	<div class="overlay-upload-img text-center">
						    		<div><i class="far fa-edit"></i> Edit</div>
						    	</div>

						    </div>
							<!-- $$$$$$$$$$$$ End first [col] Image $$$$$$$$$ -->


							<!-- @@@@@@@@@@@ Start Second [col] form fields @@@@@@@@@@@-->
						    <div class="form-group col-lg-6 col-md-6">

						      <!-- Fieldes (Name & Ordering) -->
							  <div class="form-row">

							    <div class="form-group col-md-6">
							      <label for="inputName">Name</label>
							      <input type="text" class="form-control" name="name" id="inputName" required="required" placeholder="Name of Category">
							    </div>

							    
								<div class="form-group col-lg">
							      <label for="inputOrdering">Ordering</label>
							      <input type="text" class="form-control" name="ordering" id="inputOrdering" placeholder="Number To Arrange The Category">
							    </div>

							  </div>
							  <!-- ............................. -->

							  <!-- Fieldes (Description) -->
							  <div class="form-row">

								<div class="form-group col">
							      <label for="inputDesc">Description</label>
							      <input type="text" class="form-control" name="description" id="inputDesc"  placeholder="Describe The Category" required="required">
							    </div>

							  </div>  
							  <!-- ............................... -->

							  <!-- Fieldes ( Visibility & AllowComment & Allow Ads) -->
							  <div class="form-row">

							    <div class="form-group col">
							      <label for="inputVisibility">Visibility</label>
							      <div>
							      	<input id="vis-yes" type="radio" name="visibility" value="1" checked>
							      	<label for="vis-yes">Yes</label>
							      </div>
							      <div>
							      	<input id="vis-no" type="radio" name="visibility" value="0">
							      	<label for="vis-no">No</label>
							      </div>
							    </div>

							    <div class="form-group col">
							      <label for="inputAllowComment">AllowComment</label>
							      <div>
							      	<input id="comm-yes" type="radio" name="commenting" value="1" checked>
							      	<label for="comm-yes">Yes</label>
							      </div>
							      <div>
							      	<input id="comm-no" type="radio" name="commenting" value="0">
							      	<label for="comm-no">No</label>
							      </div>
							    </div>

							    <div class="form-group col">
							      <label for="inputAllowAds">AllowAds</label>
							      <div>
							      	<input id="ads-yes" type="radio" name="ads" value="1" checked>
							      	<label for="ads-yes">Yes</label>
							      </div>
							      <div>
							      	<input id="ads-no" type="radio" name="ads" value="0">
							      	<label for="ads-no">No</label>
							      </div>
							    </div>

							  </div>
							  <!-- ............ -->

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

		 		//Get Variables from The Form 
		 		$name 			= $_POST['name'];
		 		$description 	= $_POST['description'];
		 		$ordering   	= $_POST['ordering'];
		 		$visible 		= $_POST['visibility'];
		 		$commenting 	= $_POST['commenting'];
		 		$ads  			= $_POST['ads'];
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
		 		if(!is_numeric($ordering) && !empty($ordering)){ $ErrorsArray[] = "ordering must be a number"; }

		 		//loop to echo the errors 
		 		foreach ($ErrorsArray as $error) {
		 			echo '<div class=" container alert alert-danger">' . $error . '</div>';
		 		}

		 		/* ---------- End Handling Fields validation ------------- */

		 		//if there is no error ...so start insert into database
		 		if(empty($ErrorsArray)){	 		 

			 		//check if category exist in database 
		 			$check = Checkitem('Name','categories',$name);

		 			if($check == 1 ){
		 				$theMsg = "<div class='alert alert-danger container'>Sorry This Category is already Exist</div>";
		 				redirected($theMsg,'back',5);
		 			}else{


		 				//if user choose image move to uploads folder
			 			if($image_Name !== "empty.jpg"){
				 			$image_Name = rand(0,1000000) . '_' . $image_Name; // to ensure that name of image will not be repeat
				 			//move image to project file name uploads
				 			move_uploaded_file($image_Tmp, '../Uploads/categories_image/' . $image_Name);
			 			}

				 		//Insert into Database  
				 		$stmt = $con->prepare("INSERT INTO
				 									categories ( Name, Description, img, Ordering, visibility, Allow_comment, Allow_ads)
				 							   VALUES 
				 							   			  ( :zname, :zdescription, :zimg, :zordering, :zvisible, :zcommenting, :zads)
				 							   		");

				 		$stmt -> execute(array(
				 			'zname' 	   		=> $name,
				 			'zdescription'	    => $description,
				 			'zimg'	    		=> $image_Name,
				 			'zordering'			=> $ordering,
				 			'zvisible' 			=> $visible,
				 			'zcommenting'		=> $commenting,
				 			'zads'				=> $ads
				 		));

				 		$theMsg = "<div class='alert alert-success container' > " . $stmt -> rowCount() . " Record Inserted </div>";
		 				redirected($theMsg);
		 			}
		 		}	

			}else{
			  $theMsg= "<div class='alert alert-danger container'>You Can't Access this page direct</div>";
			  redirected($theMsg);
			}

		}elseif($do == 'Edit'){

			//Check Get Request category[Id] is numeric & get the integer value of it 
			$id_category= isset($_GET['category_id']) && is_numeric($_GET['category_id']) ? intval($_GET['category_id']) : 0 ;
			$stmt = $con -> prepare("SELECT * From categories WHERE ID = ?");
			$stmt -> execute(array($id_category));
			$count = $stmt->rowCount();
		 	$category = $stmt->fetch();

		 	if($count > 0){

			?>

			<div class="page-content">
				<div class="container text-center">
					<h1>Edit [<span><?php echo $category['Name'];?></span>] Category </h1>
					<p>here you can edit your category ....like (name,ordering.....etc)</p>
				</div>

				<div class="Edit-category-div">

					<div class="container">

						<form action="?do=Update" method="POST" enctype="multipart/form-data">


						  <div class="form-row"><!-- this has two [col] first for img and second for fields of the form   -->

						  	<!-- $$$$$$$$$$$$ Start first [col] Image $$$$$$$$$ -->
							    <div class="form-group col-lg-6 col-md-7 upload-img">

							    	
							    	<input type="file" id="upload" class="form-control" name="img" style="" />
							    	<img id="img" src="../Uploads/categories_image/<?php echo $category['img'];?>" name="img" >
							    	<!-- overlay upload img  -->
							    	<div class="overlay-upload-img text-center">
							    		<div><i class="far fa-edit"></i> Edit</div>
							    	</div>
							    	<!-- get the name of old img -->
							    	<input type="test" name="oldimg" value="<?php echo $category['img'];?>" hidden = "">
							    </div>
						    <!-- $$$$$$$$$$$$ End first [col] Image $$$$$$$$$ -->



						    <!-- @@@@@@@@@@@ Start Second [col] form fields @@@@@@@@@@@-->
							    <div class="form-group col-lg-6 col-md-6">
							    	
							    <!-- Fieldes (Name & Ordering & hidden input id) -->
								  <div class="form-row">

								  	<!-- id -->
								  	<input type="hidden" name="id" value="<?php echo $category['ID'];?>">

								  	<!-- Name -->
								    <div class="form-group col-md-6">
								      <label for="inputName">Name</label>
								      <input type="text" class="form-control" name="name" id="inputName" required="required" placeholder="Name of Category" value="<?php echo $category['Name'];?>">
								    </div>

								    <!-- Ordering -->
									<div class="form-group col-lg">
								      <label for="inputOrdering">Ordering</label>
								      <input type="text" class="form-control" name="ordering" id="inputOrdering" placeholder="Number To Arrange The Category" value="<?php echo $category['Ordering'];?>">
								    </div>

								  </div>
								  <!-- .......End....... -->

								  <!-- Fieldes (Description & Img) -->
								  <div class="form-row">

								  	<!-- Description -->
									<div class="form-group col">
								      <label for="inputDesc">Description</label>
								      <input type="text" required="required" class="form-control" name="description" id="inputDesc"  placeholder="Describe The Category" value="<?php echo $category['Description'];?>" >
								    </div>

								  </div>  
								  <!-- .......End....... -->

								  <!-- Fieldes ( Visibility & AllowComment & Allow Ads) -->	  
								  <div class="form-row">

								  	<!-- Visibility -->
								    <div class="form-group col">

								      <label for="inputVisibility">Visibility</label>

								 	 	<?php 
									      	$yes_visibile = '';
									      	$no_visibile = '';
									      	if($category['Visibility'] == 1){
									      		$yes_visibile = 'checked';
									      	}elseif($category['Visibility'] == 0){
									      		$no_visibile = 'checked';
									      	}
								     	?>

							      	   <div>
								      	 <input id="vis-yes" type="radio" name="visibility" value="1" <?php echo $yes_visibile;?>>
								      	 <label for="vis-yes">Yes</label>
								       </div>

								       <div>
								      	 <input id="vis-no" type="radio" name="visibility" value="0" <?php echo $no_visibile;?>>
								      	 <label for="vis-no">No</label>
								       </div>

								    </div>

								    <!-- Allow_comment -->
								    <div class="form-group col">

								      <label for="inputAllowComment">AllowComment</label>

								        <?php 
									      	$yes_comment = '';
									      	$no_comment = '';
									      	if($category['Allow_comment'] == 1){
									      		$yes_comment = 'checked';
									      	}elseif($category['Allow_comment'] == 0){
									      		$no_comment = 'checked';
									      	}
								        ?>

								      <div>
								      	<input id="comm-yes" type="radio" name="commenting" value="1" <?php echo $yes_comment;?>>
								      	<label for="comm-yes">Yes</label>
								      </div>

								      <div>
								      	<input id="comm-no" type="radio" name="commenting" value="0" <?php echo $no_comment;?>>
								      	<label for="comm-no">No</label>
								      </div>

								    </div>

								    <!-- Allow_Ads -->
								    <div class="form-group col">

								      <label for="inputAllowAds">AllowAds</label>

								        <?php 
									      	$yes_Ads = '';
									      	$no_Ads = '';
									      	if($category['Allow_Ads'] == 1){
									      		$yes_Ads = 'checked';
									      	}elseif($category['Allow_Ads'] == 0){
									      		$no_Ads = 'checked';
									      	}
								        ?>

								      <div>
								      	<input id="ads-yes" type="radio" name="ads" value="1"      <?php echo $yes_Ads;?>>
								      	<label for="ads-yes">Yes</label>
								      </div>

								      <div>
								      	<input id="ads-no" type="radio" name="ads" value="0"       <?php echo $no_Ads;?>>
								      	<label for="ads-no">No</label>
								      </div>

								    </div>

								  </div>
								  <!-- .......End....... -->

								  <!-- Fieldes (Button) -->
								  <div class="form-row">

								    <button type="submit" class="btn btn-primary btn-block col">Update</button>
								    
								  </div>
								  <!-- .......End....... -->

							    </div>
							<!-- @@@@@@@@@@@ End Second [col] form fields @@@@@@@@@@@-->

						  </div> <!-- end of div that has two [col] --> 

						</form>	

					</div><!-- end of div that has class (container) -->

				</div><!-- end of div that has class (edit-category-div) -->

			</div>	
			<?php
				}else{
					$theMsg = "<div class='alert alert-danger container'>There is no Such this category</div>";
					redirected($theMsg);
				}

		}elseif($do == 'Update'){

			if($_SERVER['REQUEST_METHOD'] ==  'POST'){

				$name 			= $_POST['name'];
				$description 	= $_POST['description'];
				$ordering 		= $_POST['ordering'];
				$commenting 	= $_POST['commenting'];
				$visibility 	= $_POST['visibility'];
				$ads 			= $_POST['ads'];
				$id 			= $_POST['id'];
				$old_image 		= $_POST['oldimg'];
				$ErrorsArray	= array();

				$image_Name		= $_FILES['img']['name'];

				if($image_Name == ''){//if user didn't choose image

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
		 		if(!is_numeric($ordering) && !empty($ordering)){ $ErrorsArray[] = "ordering must be a number"; }

		 		//loop to echo the errors 
		 		foreach ($ErrorsArray as $error) {
		 			echo '<div class=" container alert alert-danger">' . $error . '</div>';
		 		}

		 		/* ---------- End Handling Fields validation ------------- */

		 		//if there is no error ...so start insert into database
		 		if(empty($ErrorsArray)){

					 //check if category exist in database 
				     $check = Checkitem_update('Name','ID','categories',$name,$id);

				     if($check == 1){

				     	$theMsg = '<div class="alert alert-danger container">Sorry This Category Name is Already Exist</div>';
				     	redirected($theMsg,'back',5);

				     }else{

				     	//if user choose image move to uploads folder
			 			if($image_Name !== $old_image){
				 			$image_Name = rand(0,1000000) . '_' . $image_Name; // to ensure that name of image will not be repeat
				 			//move image to project file name uploads
				 			move_uploaded_file($image_Tmp, '../Uploads/categories_image/' . $image_Name);
			 			}	

					    $stmt = $con -> prepare("UPDATE
				 									categories 
					 							   SET 
					 							   		Name = ?,
					 							   		Description = ?, 
					 							   		img = ?,
					 							   		Ordering = ?,
					 							   		Visibility = ?,
					 							   		Allow_Ads = ?,
					 							   		Allow_comment = ?
					 							   Where
					 							   		ID =$id");
					    $stmt -> execute(array($name,$description,$image_Name,$ordering,$visibility,$ads,$commenting));
					    $theMsg = "<div class=' container alert alert-success container' > " . $stmt -> rowCount() . " Record Updated </div>";
			 			redirected($theMsg,'back');

				     }

				}     

			}else{
				$theMsg = "<div class='alert alert-danger container'>You Can't Access this page direct</div>";
				redirected($theMsg);
			}

		}elseif($do == 'Delete'){

			//Check Get Request category_id is numeric & get the integer value of it 
			$id= isset($_GET['category_id']) && is_numeric($_GET['category_id']) ? intval($_GET['category_id']) : 0 ;
			$check = Checkitem("ID","categories",$id);	


			if($check > 0){
				$stmt = $con -> prepare("DELETE FROM categories WHERE ID = ?");
				$stmt -> execute(array($id));
				$theMsg = "<div class='alert alert-success container' > " . $stmt -> rowCount() . " Record Deleted </div>";
		 		redirected($theMsg,'back');
			}else{
				$theMsg = "<div class='alert alert-danger container'>There is no category with this id</div>";
		 		redirected($theMsg,'back');
			}
		}

		include $tpl . 'footer.php' ;

	}else{

		header("Location:index.php");

		exit();
		
	}	