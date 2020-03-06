<?php


	/*
	++++++++++++++++++++++++++++++++++++++++++++++
	+++++++
	=======	Comments page
	+++++++
	++++++++++++++++++++++++++++++++++++++++++++++
	*/

	ob_start(); // Output Buffering Start 

	session_start();

	$pageTitle='Comments';

	if(isset($_SESSION['UserName']) && $_SESSION['role']==1){// this condation contain all the page

		include "init.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if($do == 'Manage'){
			
			$stmt = $con -> prepare("SELECT comment.* ,
											users.FullName as user_fullname,
											items.Name as item_name,
											items.img
										FROM 
											comment
									    INNER JOIN
									        users ON users.userID = comment.user_id 
									    INNER JOIN 
									        items ON items.item_ID = comment.item_id
									    ORDER BY 
									    	comment_date
									    DESC");
			$stmt -> execute();
			$rows = $stmt->fetchAll();

		?>
		<div class="page-content">
			<div class="container text-center">
				<h1> Manage <span>Comments</span></h1>
				<p>here you can manage all users comments in system ......delete anything illegal</p>
			</div>

			<div class="container">
				<div class="responsive-table">
					<table class="table main-table table-striped table-bordered dt-responsive nowrap text-center">
						<thead>
							<tr>
								<th>Name</th>
								<th>Item_Name</th>
								<th>Item_Image</th>
								<th>Comment</th>
								<th>Comment_date</th>
								<th>Control</th>

							</tr>	
						</thead>
						<?php
							foreach ($rows as $comment) {
							$comment_date = explode(" ", $comment['comment_date']);
							  echo "
								<tr>
									<td>" . $comment['user_fullname'] . "</td>
									<td>" . $comment['item_name'] . "</td>
									<td><img style='width:80px;height:80px' src='../Uploads/items_image/" . $comment['img'] . "'></td>
									<td>" . $comment['comment'] . "</td>
									<td>" . $comment_date[0] . " <span style='color:grey;font-size:10px'>" . $comment_date[1] . "</span></td>
									<td>
										<a href='?do=Delete&comment_id=" . $comment['comment_id'] . "' class='btn btn-danger confirm'><i class='fas fa-trash'></i> Delete</a>
									</td>
								</tr>
								";
							}
						?>

					</table>	
				</div>
			</div>

		</div>

		<?php

		}elseif($do == 'Delete'){

			//Check Get Request comment_id is numeric & get the integer value of it 
			$comment_id= isset($_GET['comment_id']) && is_numeric($_GET['comment_id']) ? intval($_GET['comment_id']) : 0 ;

			$check = Checkitem("comment_id","comment",$comment_id);

		 	if($check > 0 ){ 
		 		$stmt =$con ->prepare("DELETE FROM comment Where comment_id = :commentid");
		 		$stmt -> bindParam(":commentid", $comment_id);
		 		$stmt ->execute();
		 		$theMsg = "<div class='alert alert-success container' > " . $stmt -> rowCount() . " Record Deleted </div>";
		 		redirected($theMsg,'back');
		 	}else{
		 		$theMsg = "<div class='alert alert-danger container'>This comment Not Exist</div>";
		 		redirected($theMsg);
		 	}

		}

		include $tpl . 'footer.php' ;

	}else{

		header("Location:index.php");

		exit();
		
	}	