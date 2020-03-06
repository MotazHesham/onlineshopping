<?php 
include "../connect.php";
if(isset($_GET['category_id']) && is_numeric($_GET['category_id'])){
	$category_id_select = intval($_GET['category_id']);
	$stmt = $con -> prepare("SELECT * FROM items WHERE category_id = ?");
	$stmt -> execute(array($category_id_select));
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
			  	echo '<a href="?do=Delete&&item_id=' . $item["item_ID"] . '" style="color: white;" class="btn btn-danger confirm"><i class="fas fa-trash"></i> Delete</a>';
			  echo '</div>';
			echo'</div>';
		};
}else{
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
			  	echo '<a href="?do=Delete&&item_id=' . $item["item_ID"] . '" style="color: white;" class="btn btn-danger confirm"><i class="fas fa-trash"></i> Delete</a>';
			  echo '</div>';
			echo'</div>';
		};
}
?>