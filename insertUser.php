<?php
include "dbconnection.php";

if(isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
}
if(isset($_POST['name'])) {
    $_SESSION['name'] = $_POST['name'];
}
if(isset($_POST['city'])) {
    $_SESSION['city'] = $_POST['city'];
}
if(isset($_POST['pass'])) {
    $_SESSION['pass'] = $_POST['pass'];
}
if(isset($_POST['email'])) {
    $_SESSION['email'] = $_POST['email'];
}

$username = $_SESSION['username'];
$name = $_SESSION['name'];
$city = $_SESSION['city'];
$email = $_SESSION['email'];
$pass = $_SESSION['pass'];

//$sql = "INSERT INTO `user` VALUES ('tinku','tinku','tinku','tinku','tinku', NOW())";
//$result = mysqli_query($connection,$sql);

//verify if the user is unique.
$sql = "SELECT username from `User` where username = '{$username}'";
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$count = mysqli_num_rows($result);

if($count >= 1){
// throw error.
	//$sql = "INSERT INTO `User`VALUES ('$username','$name','$email','$city','$pass',NOW())";
	//$sql = "INSERT INTO `User`VALUES ('tinku','tinku','tinku','tinku','tinku',NOW())";
	echo $sql;
}
else {
// insert the user into the database.
	$sql = "INSERT INTO `User`VALUES ('$username','$name','$email','$city','$pass',NOW())";
	$result = mysqli_query($connection,$sql);
	$_SESSION['login_user'] = $username;
}

?>