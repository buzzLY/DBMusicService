<?php
session_start();
?>
<doctype! html>
<html>
<head>
	<title> Results </title>
	<h1> Top Search Results </h1>
</head>
<body>

<?php
	include "session.php";
	$servername = "localhost";
	$username = "root";
	$password = "sareen";


	function insertRating($rate, $uname, $trackID) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}
		$statement = "INSERT INTO Ratings (username, trackID, rating) VALUES (?, ?, ?)";
		$stmt = $mysqli->prepare($statement);
		$stmt->bind_param("sss", $uname, $trackID, $rate);
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$valid = $stmt->fetch();
		$stmt->close();
		$mysqli->close();

	}


	function showArtists($keyword) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		$statement = "select aname, adesc from Artist where aname like '%{$keyword}%' or adesc like '%{$keyword}%'";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($name, $desc);
		$valid = $stmt->fetch();

		echo "<p><b> Top Artists: </b></p>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		while( $valid ) {
			echo "<tr>";
		   	echo "<td>";
	    	echo $name . " - " . $desc . "<br>";
	    	echo "</td>";
	    	echo "</tr>";
		   	$valid = $stmt->fetch();
		}
		echo "</table>";
		$stmt->close();
		$mysqli->close();
	}

	function showTracks($keyword) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		$statement = "select ttitle, tduration, tgenre, aname from Track natural join Artist" .
		" where ttitle like '%{$keyword}%' or tgenre like '%{$keyword}%' or aname like '%{$keyword}%'";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($title, $duration, $genre, $name);
		$valid = $stmt->fetch();

		echo "<p><b> Top Tracks: </b></p>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		while( $valid ) {
			$minutes = floor($duration/60);
			$seconds = $duration%60;
	    	echo "<tr>";
		   	echo "<td>";
	    	echo $title . " - " . $name . "<br>" . $genre . " - " . $minutes . "m " . $seconds . "s";
	    	
	    	echo "<br><br><input type=\"image\" src=\"play.png\" class=\"btTxt submit\" id=\"saveForm\" alt=\"Play\" <br>";

	    	echo " <p>
	    	<select rate='formRate'> 
	    		<option value=''>Rate Track</option>
	    		<option value='1'>1</option>
	    		<option value='2'>2</option>
	    		<option value='3'>3</option>
	    		<option value='4'>4</option>
	    		<option value='5'>5</option>
	    	</select>
	    	</p>";



	 		echo "</td>";
	    	echo "</tr>";


	    	$valid = $stmt->fetch();
	    	
	    }

	    echo "</table>";

	    $stmt->close();
		$mysqli->close();
	}

	function showAlbums($keyword) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		$statement = "select albtitle, aname from Album natural join Artist" .
		" where albtitle like '%{$keyword}%' or aname like '%{$keyword}%'";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($title, $name);
		$valid = $stmt->fetch();

		echo "<p><b> Top Albums: </b></p>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		while( $valid ) {
	    	echo "<tr>";
		   	echo "<td>";
	    	echo $title . " - " . $name . "<br>";
	 		echo "</td>";
	    	echo "</tr>";
	    	$valid = $stmt->fetch();
	    }

	    echo "</table>";

	    $stmt->close();
		$mysqli->close();
	}

	function showPlaylists($keyword) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}



		echo "<p><b> Top Playlists: </b></p>";


		$mysqli->close();
	}


?>
	<?php

	#$name = $_POST['cus_name'];
	#$keyword = "Eminem";
	$keyword = $_POST['key'];
	#$name = htmlspecialchars($name);
	#$keyword = htmlspecialchars($keyword);
	#$_SESSION['user_name'] = $name;
	if (!empty($keyword)) {
		showArtists($keyword);
		showTracks($keyword);
		showAlbums($keyword);
		#showPlaylists($keyword);
	}
	$uname = $_SESSION['login_user'];
	$track = 10;
	$rate = 5;
	insertRating($uname, $track, $rate);
	?>

</body>
</html>