<doctype! html>
<html>
<head>
	<title> About Artist </title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>

    <script>
    	function redir(id) {
    		$.redirect('albumList.php', {'id':id});
    	}
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
		if (!$valid) {
			echo "<p> No Tracks Found </p>";
		}
		echo "<table border=\"1\">";
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
		   	echo $minutes . "m " . $seconds . "s";
		   	echo "</td>";
		   	echo "<td>";

			echo "<button onclick=\"insPlay({$id})\"><u>Play</u></button><br>";

		   	echo "</tr>";
		   	echo "</td>";
	    	$valid = $stmt->fetch();

		}
		echo "</table>";


		$statement = "select albid, albtitle, aname from Album natural join Artist" .
		" where aid = " . $id . "";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($id, $title, $name);
		$valid = $stmt->fetch();

		echo "<p><b> Albums: </b></p>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		while( $valid ) {
	    	echo "<tr>";
		   	echo "<td>";
		   	echo "<button onclick=\"redir({$id})\"><u>{$title}</u></button>";
		   	echo "</td>";
		   	echo "<td>";
		   	echo $name;
	 		echo "</td>";
	    	echo "</tr>";
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