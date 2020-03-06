<?php
	
	ob_start();//output buffering start

	session_start();

	if(isset($_SESSION['UserName']) && $_SESSION['role']==1){

		$pageTitle='Dashboard';

		include "init.php";

		/* Start Dashboard Page*/
		?>
			<div class="page-content">

				<div class="container text-center">
						<h1>Dashboard</h1>
						<p>here you can see statistics of your website ..... </p>
				</div>

				<!-- Home Stat  -->
				<div class="home-stat">
					<div class="container text-center">
						<div class="row">

							<!-- Total Members -->
							<div class="col">
								<div class="card text-white total-members  mb-3 stat" style="max-width: 18rem;">
								  <div class="card-header"><i class="fa fa-users"></i> Total members</div>
								  <div class="card-body">
								    <h5 class="card-title"> <?php echo Countitem('userID','users');?> </h5>
								  </div>
								</div>
							</div>

							<!-- Total Items -->
							<div class="col">
								<div class="card text-white total-items mb-3 stat" style="max-width: 18rem;">
								  <div class="card-header"><i class="fa fa-tags"></i> Total Items</div>
								  <div class="card-body">
								    <h5 class="card-title"><?php echo Countitem('item_ID','items');?></h5>
								  </div>
								</div>							
							</div>

							<!-- Total Items pennding -->
							<div class="col">
								<div class="card text-white total-pending-items mb-3 stat" style="max-width: 18rem;">
								  <div class="card-header"><i class="fa fa-tag"></i> Total Pending Items</div>
								  <div class="card-body">
								    <h5 class="card-title"><?php echo Countitem('item_ID','items','WHERE Approve=0');?></h5>
								  </div>
								</div>
							</div>

							<!-- Total Comments -->
							<div class="col">
								<div class="card text-white total-comments mb-3 stat" style="max-width: 18rem;">
								  <div class="card-header"><i class="fa fa-comments"></i> Total Comments</div>
								  <div class="card-body">
								    <h5 class="card-title"><?php echo Countitem('comment_id','comment');?></h5>
								  </div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<!-- latest added -->
				<div class="latest">
					<div class="container">
						<div class="row">
							
							<!-- latest added user -->
							<div class="col-lg-6">
								<div class="card">
								  <div class="card-header text-center"><i class="fas fa-users"></i> Lastest Registerd Users</div>
								  
								    	<?php 
								    		$latest_users = getlatest("*","users","Date",5);
								    		foreach($latest_users as $user){
								    			echo "<div class='card-item'>";
									    			echo $user['FullName'] ;
									    			$date_user=calculate_diff_date($user['Date']);
									    			echo "<div class='text-right' style='font-size:13px;color:black'>" . $date_user . "</div>";
								    			echo "</div>";
								    		}
								    	?>
								  
								</div>
							</div>

							<!-- latest added items -->
							<div class="col-lg-6">
								<div class="card">
								  <div class="card-header text-center"><i class="fas fa-tag"></i> Lastest items</div>
								    	<?php 
								    		$latest_items = getlatest("*","items","Add_Date",5);
								    		foreach($latest_items as $item){
								    			echo "<div class='card-item'>";
									    			echo $item['Name'] ;
									    			$date_item=calculate_diff_date($item['Add_Date']);
									    			echo "<div class='text-right' style='font-size:13px;color:black'>" . $date_item . "</div>";
								    			echo "</div>";
								    		}
								    	?>
								</div>
							</div>

							<!-- latest added comments -->
							<div class="col-lg-12">
								<div class="card">
								  <div class="card-header text-center"><i class="fas fa-comments"></i> Lastest Comment</div>
								    	<?php 
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
																	    comment_id
																    DESC
																    LIMIT 5");
											$stmt -> execute();
											$latest_comment = $stmt->fetchAll(); 

								    		foreach($latest_comment as $comment){
								    			echo "<div class='comment-box'>";
									    			echo "<span class='comment-owner'><i class='fa fa-user-circle'></i> " . $comment['user_fullname'] . "</span>";
									    			echo "<span class='comment-content'>";
										    			echo $comment['comment'] ;
										    			$date_comment=calculate_diff_date($comment['comment_date']);
										    			echo "<div class='text-right' style='font-size:13px;color:black'>" . $date_comment . "</div>";
									    			echo "</span>";
								    			echo "</div>";
								    		}
								    	?>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>	

		<?php
		/* End Dashboard Page*/

		include $tpl . "footer.php";

	}else{

		header("Location:index.php");

		exit();

	}

	ob_end_flush();
?>
