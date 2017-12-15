
<doctype! html>
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

    	function insRate(rate, id) {
    		$.post('insertRating.php', {'rate':rate, 'id':id});
    		alert("Thank you for your rating!");
    	}

    	function insFollow(temp) {
    		alert("Now following user");
    		$.post('insertFollow.php', {'uname':temp});

    	}

    	function openPlay(id) {
    		$.redirect('playList.php', {'id':id});
    	}

    	function playLists(id, str) {
    		if (str == 1) {
    			$.redirect('createPlaylist.php', {'id':id})
    		}
    		else {
    			$.redirect('selectPlaylist.php', {'id':id})
    		}
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
		$stmt->bind_result($id, $title, $duration, $genre, $name);
		$valid = $stmt->fetch();

		$uname = $_SESSION['login_user'];
		$temp = $uname;
		echo "<p><b> Tracks: </b></p>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		while( $valid ) {
			$minutes = floor($duration/60);
			$seconds = $duration%60;
	    	echo "<tr>";
		   	echo "<td>";
	    	echo $title . "<br>" . $name . "<br>" . $minutes . "m " . $seconds . "s<br>";

		   	echo "<button onclick=\"insPlay({$id})\">Play</button><br>";

	    	echo " 
	    	<select id='formRate' name='formRate'> 
	    		<option value=''>Rate Track</option>
	    		<option value='1'>1 STAR</option>
	    		<option value='2'>2 STARS</option>
	    		<option value='3'>3 STARS</option>
	    		<option value='4'>4 STARS</option>
	    		<option value='5'>5 STARS</option>
	    	</select>
	    	";
		   	echo "<button onclick=\"insRate(5, {$id})\">Submit Rating</button><br>";



 /*
		   	$sttemp = "SELECT ptitle FROM PlaylistInfo WHERE username = " . $temp . "";
		   	$stm = $mysqli->prepare($sttemp);
		   	$stm->execute();
		   	$stm->bind_result($pnames);
		   	$val = $stm->fetch();

		  
		   	echo " <select id='playForm' name='playForm'> ";
		   	echo "<option value=''>Add to Playlist</option>";
		   	echo "echo <option value='1'>Create New PlayList</option>";
		   	$t = 1;
		   	while ($val) {
		   		echo "<option value='" . t ."'>" . $pnames . "</option>"; 
		   		$t++;
		   	}
	    			
	    	echo "</select>";
	 */   	

	    	echo " 
	    	<select id='formRate' name='formRate'> 
	    		<option value=''>Add To Playlist</option>
	    		<option value='1'>Create New Playlist</option>
	    		<option value='2'>Add to Existing Playist</option>
	    	</select>
	    	";
	    	echo "<button onclick=\"playLists({$id},2)\">Submit</button><br>";
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

		   	echo "<br><button onclick=\"insFollow({$id})\">Follow User</button>";
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
		   	echo "<button onclick=\"openPlay({$id})\">$title</button><br>";
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