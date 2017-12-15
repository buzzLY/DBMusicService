<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	
	function insertFollow($uname, $follow) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		$stmt = $mysqli->prepare("INSERT INTO Follows (username, followee, timestamp) VALUES (?, ?, CURRENT_TIMESTAMP)");
		$stmt->bind_param("ss", $uname, $follow);
		$stmt->execute();
		$valid = $stmt->fetch();
		$stmt->close();
		$mysqli->close();
	}
?>


<?php
	session_start();
	$toFollow = $_POST['uname'];
	$name = $_SESSION['login_user'];
	insertFollow($name, $toFollow);

?>