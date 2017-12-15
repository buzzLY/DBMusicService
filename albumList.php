<doctype! html>
<html>
<head>
	<title> Album </title>
</head>
<body>




<?php

	$servername = "localhost";
	$username = "root";
	$password = "";

	function insertPlay($uname, $trackID, $fromPlay) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		#Check if it is from an album or playlist

		#MySQL connection
		$stmt = $mysqli->prepare("INSERT INTO Plays (username, trackID, time, fromAlbum, fromPlayList) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $uname, $trackID, "CURRENT_TIMESTAMP", "NULL", "NULL");
		$stmt->execute();
		$valid = $stmt->fetch();
		$stmt->close();
		$mysqli->close();
	}

	function displayInfo($id) {

		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}
		$statement = "SELECT albtitle FROM Album WHERE albid = " . $id . "";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($title);
		$valid = $stmt->fetch();
		$stmt->close();
		echo "<h1> {$title} Track List </h1>";

		$statement = "SELECT ttitle, trackID, tduration, tgenre, aname from Track natural join Artist natural join Album where albid = " . $id . ""; 
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($title, $tid, $dur, $gen, $name);
		$valid = $stmt->fetch();

		echo "<table border=\"1\">";
		while($valid) {
			$minutes = floor($dur/60);
			$seconds = $dur%60;
			echo "<tr>";
		   	echo "<td>";

		   	echo $title . "<br>" . $name . "<br>" . $minutes . "m " . $seconds . "s";
			echo "<br><br><input type=\"image\" src=\"play.png\" class=\"btTxt submit\" \
	    	id=\"saveForm\" alt=\"Play\" onclick=insertPlay({p}, {$tid})<br>";
		   	echo "</tr>";
		   	echo "</td>";
	    	$valid = $stmt->fetch();

		}
		echo "</table>";

		$stmt->close();		
		$mysqli->close();
	}
?>



<?php
	session_start();

	$id = $_SESSION['albid'];
	displayInfo($id);

?>




</body>
</html>