<html>
<head>
	<title> Results </title>
	<h1> Top Search Results </h1>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>
    <style>
    	table {
    border-collapse: collapse;
    width: 75%;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         button.link {
	-moz-user-select: text;
	background: none;
	border: none;
	color: black;
	cursor: pointer;
	font-size: 1em;
	margin: 0;
	padding: 0;
	text-align: left;
}
 
button.link:hover span {
	text-decoration: underline;
}
    </style>
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

    	function insFan(id) {
    		$.post('insertFan.php', {'id':id});
    		alert("You are now a fan!");
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

		echo "<h2><b> Artists: </b></h2>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		//echo "<div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\"><b>Artist Name</b></div>";
		echo "<tr><td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Artist Name</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Become a Fan</b></div> </td></tr>";		
		while( $valid ) {
			echo "<tr>";
		   	echo "<td>";
		   	echo "<button onclick=\"redirArt({$id})\" align=\"center\" class=\"link\"><u>{$name}</u></button>";
		   	echo "</td>";
		   	echo "<td>";
		   	echo "<br><button onclick=\"insFan('$id')\" align=\"center\">Become a Fan</button>";
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

		
		$statement = "select distinct(trackID), ttitle, tduration, tgenre, aname, aid from Track natural join Artist" .
		" where ttitle like '%{$keyword}%' or tgenre like '%{$keyword}%' or aname like '%{$keyword}%'";
		$stmt = $mysqli->prepare($statement);
		$stmt->execute();
		$stmt->bind_result($trackId, $title, $duration, $genre, $name, $id);
		$valid = $stmt->fetch();

		$uname = $_SESSION['login_user'];
		$temp = $uname;
		echo "<h2><b> Tracks: </b></h2>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		echo "<tr><td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Track Name</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Artist Name</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Duration</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Play</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Rate</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Add to Playlist</b></div> </td></tr>";

		$i = 0;
		while( $valid ) {
			$minutes = floor($duration/60);
			$seconds = $duration%60;
	    	echo "<tr>";
		   	echo "<td>";
	    	echo $title;
	    	echo "</td>";
	    	echo "<td>";
		   	echo "<button onclick=\"redirArt({$id})\" align=\"center\" class=\"link\"><u>{$name}</u></button>";
	    	echo "</td>";
	    	echo "<td>";
	    	echo $minutes . "m " . $seconds . "s";
	    	echo "</td>";
	    	echo "<td>";

		   	echo "<button onclick=\"insPlay({$trackId})\" >Play</button><br>";
		   	echo "</td>";
		   	echo "<td>";

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
		   	echo "<br><button onclick=\"insRate('formRate$i', {$trackId})\">Submit Rating</button><br>";  	
		   	echo "</td>";
		   	echo "<td>";

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


		echo "<h2><b> Users: </b></h2>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		echo "<tr><td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Name</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Username</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>City</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Follow</b></div> </td></tr>";

		while( $valid ) {
	    	echo "<tr>";
		   	echo "<td>";
		 	echo $name;
			echo "</td>";
		   	echo "<td>";
		 	echo  $usr;
		 	echo "</td>";
		   	echo "<td>";
		   	echo $city;
		   	echo "</td>";
		   	echo "<td>";
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

		echo "<h2><b> Albums: </b></h2>";
		if (!$valid) {
			echo "No Results Found";
		}
		echo "<table border=\"1\">";
		echo "<tr><td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Album Name</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Artist</b></div> </td></tr>";

		while( $valid ) {
	    	echo "<tr>";
		   	echo "<td>";
		   	echo "<button onclick=\"redir({$id})\" class=\"link\"><u>{$title}</u></button>";
		    echo "</td>";
		   	echo "<td>";
		   	echo "<button onclick=\"redirArt({$id})\" class=\"link\"><u>{$name}</u></button>";
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

		echo "<h2><b> Playlists: </b></h2>";
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
		echo "<tr><td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Playlist Name</b></div> </td>";
		echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Created By User</b></div> </td></tr>";

		while( $valid ) {
			echo "<tr>";
		   	echo "<td>";
		   	echo "<button onclick=\"openPlaylist({$id})\" class=\"link\"><u>$title</u></button>";
		   	echo "</td>";
		   	echo "<td>";
	    	echo $uname . "<br>";
	    	

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