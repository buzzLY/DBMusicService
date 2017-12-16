<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	
	function insertFan($uname, $aid) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		$stmt = $mysqli->prepare("INSERT INTO Fans (username, aid, timestamp) VALUES (?, ?, CURRENT_TIMESTAMP)");
		$stmt->bind_param("ss", $uname, $aid);
		$stmt->execute();
		$valid = $stmt->fetch();
		$stmt->close();
		$mysqli->close();
	}
?>


<?php
	session_start();
	$aid = $_POST['id'];
	$name = $_SESSION['login_user'];
	insertFan($name, $aid);

?>