<?php
include_once "connection.php";


function getAuthorName($id){
	global $conn;
	$sql = "SELECT * FROM author WHERE author_id='$id'";
	$result = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_assoc($result)){
		$name = $row['author_name'];
		echo $name;
	}
}



function getCategoryName($id){
	global $conn;
	$sql = "SELECT * FROM category WHERE category_id='$id'";
	$result = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_assoc($result)){
		$name = $row['category_name'];
		echo $name;
	}
}


?>