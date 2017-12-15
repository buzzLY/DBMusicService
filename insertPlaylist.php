<html>
<head></head>
<body>
<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	function insert($pid, $trackId) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		$position = "SELECT position from Playlist where pid = 5 Order by position desc limit 1";
		$st = $mysqli->prepare($position);
		$st->execute();

		$st->bind_result($pos);
		$valid = $st->fetch();
		$pos++;
		

		$stmt = $mysqli->prepare("INSERT INTO Playlist (pid, trackID, position) VALUES (?, ?, ?)");
		echo "<script> alert(" . $pos . ")</script>";
	//	$_SESSION['query'] = $stmt;
		//$stmt->debugDumpParams();
		$stmt->bind_param("iii", $pid, $trackId, $pos);
		$stmt->execute();
		$valid = $stmt->fetch();
		$stmt->close();
		$mysqli->close();
	}
?>


<?php
	session_start();
	//$pid = $_POST['pid'];
	//$trackId = $_POST['trackId'];
	$name = $_SESSION['login_user'];
	//insert($pid, $trackId);
	insert(5, 1);

?>
</body>
</html>