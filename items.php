<?php


	/*
	++++++++++++++++++++++++++++++++++++++++++++++
	+++++++
	=======	items page
	+++++++
	++++++++++++++++++++++++++++++++++++++++++++++
	*/

	ob_start(); // Output Buffering Start 

	session_start();

	$pageTitle='';

	

		include "init.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'all';
		//Check Get Request category[Id] is numeric & get the integer value of it 
		$category_id= isset($_GET['category_id']) && is_numeric($_GET['category_id']) ? intval($_GET['category_id']) : 0 ;
		$items = getrecords("*","items","WHERE Category_id=$category_id","Add_Date","DESC");
		$category_info = get_record("*","categories","ID=$category_id");

			
		if($do == 'all'){
			echo '<div class="container text-center">';
				echo '<h1><span>' . $category_info["Name"] . '</span> Category </h1>';
				echo '<p>here you can see all items that category contain...</p>';
			echo '</div>';

			echo "<div class='items-view'>";
				foreach ($items as $item) {
			?>

				<div class="container">
					<div class="card mb-3 item-part" href="#" style="max-width: 540px;">
					  <div class="row no-gutters">

					    <div class="col-md-4">
					      <img src="Uploads/items_image/<?php echo $item['img'];?>" style="height: 100%" class="card-img" alt="...">
					    </div>

					    <div class="col-md-8">
					      <div class="card-body">
					        <h5 class="card-title"><?php echo $item['Name']?></h5>
					        <div class="card-text">Price : <span><?php echo $item['Price'];?></span></div>
					        <div class="card-text">CountryMade: <span><?php echo $item['Country_Made'];?></span></div>
					        <span class="card-text"><small class="text-muted"><?php echo calculate_diff_date($item['Add_Date'])?></small></span>
					      </div>
					    </div>

					  </div>
					  <a href="?do=item&&item_id=<?php echo $item['item_ID']?>" class="btn btn-info btn-block" style="position: absolute;height: 100%;opacity: 0;">view</a>
					</div>
				</div>
			<?php

				}
				echo '<div class="clear"></div>';
			echo "</div>";

		}elseif($do == 'item'){

			//Check Get Request item[Id] is numeric & get the integer value of it
			$item_id= isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0 ;	
			$item_info = get_record("*","items","item_ID=$item_id");
			$comments_item = getrecords("*","comment","WHERE item_id=$item_id","comment_date","DESC");

		?>	
			<div class="container text-center">
				<h1><span> <?php echo $item_info["Name"]  ?></span> item </h1>
				<p>here you can see all info about that item...</p>
			</div>

			<div class="container">
				<div class="row">

					<div class="col">
						<div class="upload-img">
							<img id="img" src="Uploads/items_image/<?php echo $item_info['img'] ?>" name="img">
						</div>
					</div>

					<div class="col">
						<div class="card">
						  <h5 class="card-header text-center">Item Info</h5>
						  <div class="card-body profile-info">
						    <div>Name : <span><?php echo $item_info['Name'] ?></span> </div>
						    <div>CountryMade : <span><?php echo $item_info['Country_Made'] ?></span> </div>
						    <div>Description : <span><?php echo $item_info['Description'] ?></span> </div>
						    <div>Date : <span><?php echo calculate_diff_date($item_info['Add_Date']) ?></span> </div>
						    <div>Price : <span><?php echo $item_info['Price'] ?></span> </div>
						    <a href="?do=order&&item_id=<?php echo $item_id;?>" class="btn btn-info">Order</a>
						    <a href="?do=addto_cart&&item_id=<?php echo $item_id;?>" class="btn btn-success">Add to Cart</a>
						  </div>
						</div>
					</div>

				</div>
			</div>

			<?php
	   		 
				echo '<div class="container">';
					echo '<div class="card" style="margin-top:20px;">';
					 echo '<div class="card-header text-center"><i class="fa fa-comments"></i> Comments</div>';
					 if(isset($_SESSION['front_username'])){	
			    		echo "<div class='comment-box'>";
			    			echo "<span class='comment-owner'><image style='height:35px;width:35px;border-radius:50%' src=Uploads/profile_image/" . $user['img'] . "></span>";
			    			echo "<span class='comment-content'>";
			    				echo "<input type='text' name='written_comment' id='written_comment' autocomplete='off' placeholder='Write a comment...'>";
			    				echo "<Button type='button' id='send_comment' id='" . $item_id . "' />send</Button>";
			    			echo "</span>";
		    			echo "</div>";
		    			echo "<hr style='border-width:2px'>";
		    		}
			    		foreach($comments_item as $comment){
			    			$user_id=$comment['user_id'];
			    			$comment_username = get_record("*","users","userID=$user_id");
			    			echo "<div class='comment-box'>";
				    			echo "<span class='comment-owner'><image style='height:35px;width:35px;border-radius:50%' src=Uploads/profile_image/" . $comment_username['img'] . "> " . $comment_username['FullName'] . "</span>";
				    			echo "<span class='comment-content'>";
					    			echo $comment['comment'] ;
					    			$date_comment=calculate_diff_date($comment['comment_date']);
					    			echo "<div class='text-right' style='font-size:13px;color:black'>" . $date_comment . "</div>";
				    			echo "</span>";
			    			echo "</div>";
			    		}
					echo '</div>';
				echo '</div>';
	    	

		}elseif($do == 'insert_comment'){

		}elseif($do == 'order'){

		}elseif($do == 'insert_order'){

		}elseif($do == 'addto_cart'){

		}

		include $tpl . 'footer.php' ;
	