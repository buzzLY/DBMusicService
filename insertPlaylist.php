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

		$positio = "SELECT position from Playlist where pid = $pid Order by position desc limit 1";
		$st = $mysqli->prepare($positio);
		$st->execute();

		$st->bind_result($poss);
		$valid = $st->fetch();
		$st->close();
		$poss++;
		
		$sql = "INSERT INTO Playlist (pid, trackID, position) VALUES (?, ?, ?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('iii', $pid, $trackId, $poss);
		$stmt->execute();
		$valid = $stmt->fetch();
		$stmt->close();
		$mysqli->close();
	}
?>


<?php
	session_start();
	$pid = $_POST['pid'];
	$trackId = $_POST['trackId'];
	$name = $_SESSION['login_user'];
	insert($pid, $trackId);

?>
</body>
</html>