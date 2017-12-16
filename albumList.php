<doctype! html>
<html>
<head>
	<title> Album </title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>

    <script>
    	function insPlay(id) {
    		$.post('insertPlay.php', {'id':id});
    		alert("Playing!");
    	}
    </script>
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
		$statement = "SELECT albtitle, albid FROM Album WHERE albid = " . $id . "";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($title, $alid);
		$valid = $stmt->fetch();
		$stmt->close();
		echo "<h1> {$title} Track List </h1>";

		$statement = "SELECT Track.ttitle, Track.trackID, Track.tduration, Artist.aname from ((Album join TrackList on Album.albid = TrackList.albid) join Track on TrackList.trackID = Track.trackID) join Artist on Track.aid = Artist.aid where Album.albid = {$id}"; 
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($title, $tid, $dur, $name);
		$valid = $stmt->fetch();

		echo "<table border=\"1\">";
		echo "<tr><td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Track Name</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Artist</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Duration</b></div> </td>";		
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Play</b></div> </td>";

		while($valid) {
			$minutes = floor($dur/60);
			$seconds = $dur%60;
			echo "<tr>";
		   	echo "<td>";

		   	echo $title;
		   	echo "</td>";
		   	echo "<td>";
		   	echo $name;
		   	echo "</td>";
		   	echo "<td>";
		   	echo  $minutes . "m " . $seconds . "s";
		   	echo "</td>";
		   	echo "<td>";
			echo "<button onclick=\"insPlay({$id})\"><u>Play</u></button>";

		   	echo "</tr>";
		   	echo "</td>";
	    	$valid = $stmt->fetch();

		}
		echo "</table><br>";
		echo "<form action=\"welcome.php\" method=\"post\">";
	    echo "<input type=\"submit\" class=\"button\" value=\"Home\">";
	    echo "</form>";

		$stmt->close();		
		$mysqli->close();
	}
?>



<?php
	session_start();
	$id = $_POST['id'];
	displayInfo($id);

?>




</body>
</html>