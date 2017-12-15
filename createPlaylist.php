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

		$stmt = $mysqli->prepare("INSERT INTO PlaylistInfo (pid, ptitle, pdate, username) VALUES (?, ?, CURRENT_TIMESTAMP,?)");
		$stmt->bind_param("sss", $pid, $pname, $uname);
		$stmt->execute();
		$valid = $stmt->fetch();
		$stmt->close();

		$stmt = $mysqli->prepare("INSERT INTO Playlist ")
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