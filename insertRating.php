
<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	
	function insertRating($rate, $uname, $trackID) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		$stmt = $mysqli->prepare("INSERT INTO Ratings (username, trackID, rating) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $uname, $trackID, $rate);
		$stmt->execute();
		$valid = $stmt->fetch();
		$stmt->close();
		$mysqli->close();
	}
?>


<?php
	session_start();
	echo "<p> Playing! </p>";
	$rate = $_POST['rate'];
	$id = $_POST['id'];
	#$name = $_POST['name'];
	$name = $_SESSION['login_user'];
	insertRating($rate, $name, $id);

?>