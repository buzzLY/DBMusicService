<html>
<head>
	<title> Results </title>
	<h1> Top Search Results </h1>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>

    <script>
    	function redir(id) {
    		$.redirect('albumList.php', {'id':id});
    	}

    	function redirArt(id) {
    		$.redirect('aboutArtists.php', {'id':id});
    	}

    	function insPlay(id) {
    		$.post('insertPlay.php', {'id':id});
    		alert("Playing!");
    	
    	}

    	function insRate(dropDownId, trackId) {
    		var selectedValue = $("#".concat(dropDownId)).val();
    		$.post('insertRating.php', {'rate':selectedValue, 'id':trackId});
    		alert("Thank you for your rating!");
    	}

    	function insFollow(temp) {
    		alert("Now following user");
    		$.post('insertFollow.php', {'uname':temp});

    	}

    	function openPlaylist(trackId) {
    		$.redirect('playList.php', {'id':trackId});
    	}

    	function playLists(id) {
    		
    		$.redirect('selectPlaylist.php', {'id':id})
    		
    	}


    </script>

</head>
<body>

<?php
	include "session.php";
	$servername = "localhost";
	$username = "root";
	$password = "";




	function showArtists($keyword) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		echo "<form action=\"welcome.php\" method=\"post\">";
	    echo "<input type=\"submit\" class=\"button\" value=\"Home\">";
	    echo "</form>";

		$statement = "select aid, aname, adesc from Artist where aname like '%{$keyword}%' or adesc like '%{$keyword}%'";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($id, $name, $desc);
		$valid = $stmt->fetch();

		echo "<p><b> Artists: </b></p>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		while( $valid ) {
			echo "<tr>";
		   	echo "<td>";
		   	echo "<button onclick=\"redirArt({$id})\"><u>{$name}</u></button>";
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

		
		$statement = "select distinct(trackID), ttitle, tduration, tgenre, aname from Track natural join Artist" .
		" where ttitle like '%{$keyword}%' or tgenre like '%{$keyword}%' or aname like '%{$keyword}%'";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($trackId, $title, $duration, $genre, $name);
		$valid = $stmt->fetch();

		$uname = $_SESSION['login_user'];
		$temp = $uname;
		echo "<p><b> Tracks: </b></p>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		$i = 0;
		while( $valid ) {
			$minutes = floor($duration/60);
			$seconds = $duration%60;
	    	echo "<tr>";
		   	echo "<td>";
	    	echo $title . "<br>" . $name . "<br>" . $minutes . "m " . $seconds . "s<br>";

		   	echo "<button onclick=\"insPlay({$trackId})\">Play</button><br>";
		   	
	    	echo " 
	    	<select id='formRate$i' name='formRate'> 
	    		<option value=''>Rate Track</option>
	    		<option value='1'>1 STAR</option>
	    		<option value='2'>2 STARS</option>
	    		<option value='3'>3 STARS</option>
	    		<option value='4'>4 STARS</option>
	    		<option value='5'>5 STARS</option>
	    	</select>
	    	";
	    	

	    	//echo "<p> {$rate} </p>";
		   	echo "<button onclick=\"insRate('formRate$i', {$trackId})\">Submit Rating</button><br>";  	
	    	echo "<button onclick=\"playLists({$trackId})\">Add To Playlist</button><br>";
	    	$i++;
	    	
	 		echo "</td>";
	    	echo "</tr>";


	    	$valid = $stmt->fetch();
	    	
	    }

	    echo "</table>";

	    $stmt->close();
		$mysqli->close();
	}


	function showUsers($keyword) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		$statement = "select username, uname, ucity from User where username like '%{$keyword}%'";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($usr, $name, $city);
		$valid = $stmt->fetch();


		echo "<p><b> Users: </b></p>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		while( $valid ) {
	    	echo "<tr>";
		   	echo "<td>";
		 	echo $name . "<br>Username: " . $usr . "<br>From: " . $city;

		   	echo "<br><button onclick=\"insFollow('$usr')\">Follow User</button>";
	 		echo "</td>";
	    	echo "</tr>";
	    	$valid = $stmt->fetch();
	    }
	    echo "</table>";
	    $stmt->close();
		$mysqli->close();
	}

	
	#DONE
	function showAlbums($keyword) {
		global $servername, $username, $password; 
		$mysqli = new mysqli($servername, $username, $password, "dbproject"); 
		if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}

		$statement = "select albid, albtitle, aname from Album natural join Artist" .
		" where albtitle like '%{$keyword}%' or aname like '%{$keyword}%'";
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
		   	echo "<button onclick=\"redir({$id})\"><u>{$title}</u></button><br>{$name}";
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

		echo "<p><b> Playlists: </b></p>";
		$statement = "select pid, ptitle, username from PlaylistInfo" .
		" where ptitle like '%{$keyword}%'";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($id, $title, $uname);
		$valid = $stmt->fetch();

		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		while( $valid ) {
			echo "<tr>";
		   	echo "<td>";
		   	echo "<button onclick=\"openPlaylist({$id})\">$title</button><br>";
	    	echo "Created by: " . $uname . "<br>";
	    	

	    	echo "</td>";
	    	echo "</tr>";
	    	$valid = $stmt->fetch();
		}
		echo "</table>";
		$stmt->close();
		$mysqli->close();
	}

	


?>
	<?php
	$keyword = $_POST['key'];
	$usr = $_SESSION['login_user'];
	if (!empty($keyword)) {
		showArtists($keyword);
		showTracks($keyword);
		showAlbums($keyword);
		showPlaylists($keyword);
		showUsers($keyword);
	}
	?>

	

</body>
</html>