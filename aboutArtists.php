<doctype! html>
<html>
<head>
	<title> About Artist </title>
</head>
<body>

<?php

	$servername = "localhost";
	$username = "root";
	$password = "";

	function displayInfo($id) {

		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}
		$statement = "SELECT aname FROM Artist WHERE aid = " . $id . "";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($title);
		$valid = $stmt->fetch();
		$stmt->close();
		echo "<h1> About {$title} </h1>";

		$statement = "SELECT ttitle, trackID, tduration, tgenre, aname from Track natural join Artist where aid = " . $id . ""; 
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($title, $tid, $dur, $gen, $name);
		$valid = $stmt->fetch();

		echo "<p><b> Tracks: </b></p>";
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

	$id = $_SESSION['aid'];
	displayInfo($id);

?>


</body>
</html>