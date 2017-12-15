
<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	function insertPlay($uname, $trackID) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		$stmt = $mysqli->prepare("INSERT INTO Plays (username, trackID, time, fromAlbum, fromList) VALUES (?, ?, CURRENT_TIMESTAMP, NULL, NULL)");
		$stmt->bind_param("ss", $uname, $trackID);
		$stmt->execute();
		$valid = $stmt->fetch();
		$stmt->close();
		$mysqli->close();
	}
?>


<?php
	session_start();
	echo "<p> Playing! </p>";
	$id = $_POST['id'];
	#$name = $_POST['name'];
	$name = $_SESSION['login_user'];
	insertPlay($name, $id);

?>
