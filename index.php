<?php
	 
	 ob_start();//output buffering start
	 session_start();

	 $pageTitle='HomePage';

	 include "init.php";

?>


	<div class="container text-center">
		<h1>OnlineShopping <span>Categories</span></h1>
		<p>here you can see all your categories in the website...</p>
	</div>

	<div class="categories text-center">

		<div class="category-view">
				<?php

				$stmt = $con -> prepare("SELECT * FROM categories WHERE Visibility = 1 ORDER BY Ordering ASC");
				$stmt -> execute();
				$All_Categories = $stmt->fetchAll();

					foreach($All_Categories as $Category){
						echo'<div class="card category-part" style="width: 18rem;">';
						  echo'<img src="Uploads/categories_image/' . $Category['img'] . '" class="img-thumbnail" style="height:170px">';
						  echo'<div class="card-body">';
						    echo'<h2 class="card-title">' . $Category['Name'] . '</h2>';
						    echo'<h6 class="card-subtitle mb-2 text-muted">' . $Category['Description'] . '</h6>';
						  echo'</div>';
						  echo '<div class="category-part-overlay">';
						  	echo '<a href="items.php?category_id=' . $Category["ID"] . '" style="color: white;" class="btn btn-primary"><i class="fab fa-pagelines"></i> View</a>';
						  echo '</div>';
						echo'</div>';
					};
				?>
				<div class="clear"></div><!-- this div for clearing float  -->
		</div>
	</div>

<?php 
	include $tpl . "footer.php";

	ob_end_flush();
?>