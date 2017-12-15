<doctype! html>
<html>
<head>
	<title> Select Playlist </title>
	<h1> Existing Playlists: </h1>
</head>
<body>



<?php

	$servername = "localhost";
	$username = "root";
	$password = "";


	function insert($pid, ) {

	}

	function display($name, $id) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}
		$statement = "SELECT ptitle FROM PlaylistInfo WHERE username = {$name}";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_results($title);
		$valid = $stmt->fetch();

		$valid = $stmt->fetch();
		echo "<form action=\"insertPlaylist(), {$id})\" method=\"post\">";
	    echo "<table border=\"1\">";
	    if (!$valid) {
			echo "No Results Found";
		}
	    while ($valid) {
	    	echo "<tr>";
		   	echo "<td>";
		   	echo "<input type=\"radio\" name=\"chosen\" value=\"";
		   	echo $title . "<br>";
		   	echo "</td>";
		   	echo "</tr>";
		   	$valid = $stmt->fetch();
	    }
	    echo "</table>";
	    echo "<input type=\"submit\" class=\"button\" value=\"Add to Playlist\">";
	    echo "</form>";
	    $stmt->close();	
		$mysqli->close();


	}

?>



<?php
	session_start();
	$name = $_SESSION['login_user'];
	$id = $_POST['id'];
	display($name, $id);

?>




</body>
</html>