<?php

include('../connect.php')

start_session();

$id_user = 7;

$comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);

$stmt = $con -> prepare("INSERT INTO 
									comment (comment,comment_date,user_id,item_id)
								VALUES
								 (:zcomment ,now() ,:zuser_id,:zitem_id)");
$stmt -> execute(array(
	'zcomment' => $comment,
	'zuser_id' => $id_user,
	'zitem_id' => $item_id
));	