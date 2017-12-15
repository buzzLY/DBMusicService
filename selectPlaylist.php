<doctype! html>
<html>
<head>
	<title> Select Playlist </title>
	<h1> Add to Playlist: </h1>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>

    <script>
    	function insert(pid,trackId) {
    		alert(pid);
    		alert(trackId);
    		$.post('insertPlaylist.php', {'pid':pid, 'trackId':trackId});
    		alert("Track Added to Playlist");
    	}

    	function createNew(trackId) {
    		var pname = $("#inputName").val();
    		$.post('createPlaylist.php',{'trackId':trackId, 'pname':pname});
    		alert("New Playlist Creted");
    	}
    </script>

</head>
<body>



<?php

	$servername = "localhost";
	$username = "root";
	$password = "";


	function display($name, $id) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}
		$statement = "SELECT pid, ptitle FROM PlaylistInfo WHERE username = '{$name}'";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($pid, $title);
		$valid = $stmt->fetch();

	    echo "<table border=\"1\">";
	    if (!$valid) {
			echo "No Results Found";
		}
	    while ($valid) {
	    	echo "<tr>";
		   	echo "<td>";
		   	echo $title . " ";
		   	echo "<button onclick=\"insert('$pid', '$id')\"> Add </button>"; 
		   	echo "</td>";
		   	echo "</tr>";
		   	$valid = $stmt->fetch();
	    }
	    echo "</table>";
	    $stmt->close();	
		$mysqli->close();

		echo "<br><input id = \"inputName\" type=\"text\" name=\"createNew\" placeholder=\"Insert Name..\"><br>";
		echo "<button id=\"newPlay\" onclick=\"createNew('$id')\">Create New Playlist</button>";



		echo "<br><br><form action=\"welcome.php\" method=\"post\">";
	    echo "<input type=\"submit\" class=\"button\" value=\"Home\">";
	    echo "</form>";

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