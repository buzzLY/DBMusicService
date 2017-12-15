<doctype! html>
<html>
<head>
	<title> PlayList </title>

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
		$statement = "SELECT ptitle, username FROM PlaylistInfo WHERE pid = " . $id . "";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($title, $user);
		$valid = $stmt->fetch();
		$stmt->close();
		echo "<h1> {$title} Track List </h1>";

		$ns = "SELECT Track.ttitle, Track.trackID, Track.tduration, Artist.aname from ((PlaylistInfo join Playlist on PlaylistInfo.pid = Playlist.pid) join Track on Playlist.trackID = Track.trackID) join Artist on Track.aid = Artist.aid where PlaylistInfo.pid = {$id}"; 

		$st = $mysqli->prepare($ns);
		$st->execute();
		$st->bind_result($title, $tid, $dur, $name);
		$valid = $st->fetch();

		echo "<table border=\"1\">";
		while($valid) {
			$minutes = floor($dur/60);
			$seconds = $dur%60;
			echo "<tr>";
		   	echo "<td>";

		   	echo $title . "<br>" . $name . "<br>" . $minutes . "m " . $seconds . "s<br>";
			echo "<button onclick=\"insPlay({$id})\"><u>Play</u></button>";

		   	echo "</tr>";
		   	echo "</td>";
	    	$valid = $st->fetch();

		}
		echo "</table><br>";

		echo "<form action=\"welcome.php\" method=\"post\">";
	    echo "<input type=\"submit\" class=\"button\" value=\"Home\">";
	    echo "</form>";

		$st->close();		
		$mysqli->close();
	}
?>



<?php
	session_start();
	$pid = $_POST['id'];
	displayInfo($pid);

?>




</body>
</html>