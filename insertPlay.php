<?php

include "dbconnection.php";

if (isset($_POST['username']) ) {
	$_SESSION['username'] = $_POST['username'];
}

if (isset($_POST['trackID']) ) {
	$_SESSION['trackID'] = $_POST['trackID'];
}

if (isset($_POST['fromAlbum']) ) {
	$_SESSION['fromAlbum'] = $_POST['fromAlbum'];
}

if (isset($_POST['fromPlaylist']) ) {
	$_SESSION['fromPlaylist'] = $_POST['fromPlaylist'];
}



?>