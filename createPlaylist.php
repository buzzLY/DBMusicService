<html>
<head></head>
<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	function create($pname, $trackId, $uname) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		$position = "SELECT pid from PlaylistInfo Order by pid desc limit 1";
		$st = $mysqli->prepare($position);
		$st->execute();
		$st->bind_result($poss);
		$valid = $st->fetch();
		$st->close();
		$poss++;

		$stmt = $mysqli->prepare("INSERT INTO PlaylistInfo (pid, ptitle, pdate, username) VALUES (?, ?, CURRENT_TIMESTAMP, ?)");
		$stmt->bind_param('iss', $poss, $pname, $uname);
		$stmt->execute();
		$valid = $stmt->fetch();
		$stmt->close();

		

		

		$sql = "INSERT INTO Playlist (pid, trackID, position) VALUES (?, ?, 1)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $poss, $trackId);
		$stmt->execute();
		$valid = $stmt->fetch();
		$stmt->close();
		$mysqli->close();
	}
?>


<?php
	session_start();
	$trackId = $_POST['trackId'];
	$pname = $_POST['pname'];
	$name = $_SESSION['login_user'];
	create($pname, $trackId, $name);

?>
<body>
</body>
</html>