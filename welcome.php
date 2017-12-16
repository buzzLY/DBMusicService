<?php
   include "session.php";
   function recentSongs(){
   	$mysqli = new mysqli(DB_SERVER,DB_USERNAME,'',DB_DATABASE); 
   	if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}
   	$loggedInUser = $_SESSION['login_user'];
   	$statement = "SELECT distinct trackID, ttitle from Plays natural join Track WHERE username = '{$loggedInUser}';";
   	
	$stmt = $mysqli->prepare($statement);
	$stmt->execute();
	$stmt->bind_result($id, $name);
	$valid = $stmt->fetch();
	echo "<h2><b> Recently Played: </b></h2>";
   	if(!$valid){
   		echo "No Results Found";
   	}
   	else {
   		echo "<table border=\"1\">";
      echo "<tr><td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Track Name</b></div> </td>";
      echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Play</b></div> </td></tr>";


   		while($valid){
   			echo "<tr>";
		   	echo "<td>";
	    	echo $name . "<br>";
        echo "</td>";
        echo "<td>";
        echo "<button onclick=\"insPlay({$id})\">Play</button><br>";
	    	echo "</td>";
	    	echo "</tr>";
		   	$valid = $stmt->fetch();
   		}
   		echo "</table>";
   		$stmt->close();
   	}
   	$mysqli->close();
   }

   function topPlays(){
   	$mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 
   	if (mysqli_connect_errno()) {
			die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
		}


   	$statement = "SELECT trackID, ttitle, count(*) from Plays natural join Track group by trackID,ttitle order by count(*) desc limit 3";
   	$stmt = $mysqli->prepare($statement);
	$stmt->execute();
	$stmt->bind_result($id,$title,$count);
	$valid = $stmt->fetch();
	echo "<h2><b>  Top Most Played: </b></h2>";
   	if(!$valid){
   		echo "No Results Found";
   	}
   	else {
   		echo "<table border=\"1\">";
      echo "<tr><td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Track Name</b></div> </td>";
      echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Play</b></div> </td></tr>";

   		while($valid){
   			echo "<tr>";
		   	echo "<td>";
	    	echo $title . "<br>";
        echo "</td>";
        echo "<td>";
        echo "<button onclick=\"insPlay({$id})\">Play</button><br>";
	    	echo "</td>";
	    	echo "</tr>";
		   	$valid = $stmt->fetch();
   		}
   		echo "</table>";
   		$stmt->close();
   	}
   	$mysqli->close();
   }

   function usersIfollow(){
      $mysqli = new mysqli(DB_SERVER,DB_USERNAME,'',DB_DATABASE); 
    if (mysqli_connect_errno()) {
      die("Connect to db failed: " . "<br>" . mysqli_connect_error() );
    }

    $loggedInUser = $_SESSION['login_user'];
    $statement = "SELECT u.uname, u.username from Follows f ,User u where (u.username = f.followee) and f.username = ?";
    $stmt = $mysqli->prepare($statement);
    $stmt->bind_param("s",$loggedInUser);
    $stmt->execute();
    $stmt->bind_result($name, $uname);
    $valid = $stmt->fetch();
      echo "<h2><b> Users You follow </b></h2>";
    if(!$valid){
      echo "No Results Found";
    }
    else {
      echo "<table border=\"1\">";
      echo "<tr><td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Name</b></div> </td>";
      echo "<td> <div style = \"background-color:#333333; color:#FFFFFF; padding:3px;\" align=\"center\"><b>Username</b></div> </td></tr>";

      while($valid){
        echo "<tr>";
        echo "<td>";
        echo $name;
        echo "</td>";
        echo "<td>";
        echo $uname;
        echo "</td>";
        echo "</tr>";
        $valid = $stmt->fetch();
      }
      echo "</table>";
      $stmt->close();
    }
    $mysqli->close();

   }
?>
<html>
   
   <head>
      <title>Welcome </title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>
      <script>
      function insPlay(id) {
        $.post('insertPlay.php', {'id':id});
        alert("Playing!");
      
      }
      function search(){
      	var key = $("#searchbar").val()
      	if((typeof key != "undefined") /*&& (key.valueOf() == "string")*/ && key.length > 0){
      		$.redirect('searchkeyword.php',{'key': key});
      	}
      	else {
      		alert("Please enter some search value");
      	}
      }
      </script>
      <style> 
	input[type=text] {
    width: 130px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    background-color: white;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.9s ease-int-out;
    transition: width .5s ease-in-out;
}

input[type=text]:focus {
    width: 100%;
}
</style>
   </head>
   
   <body>
      <h1>Welcome <?php echo $login_session; ?></h1><h5><a href = "logout.php">Sign Out</a></h5>
      <input id = "searchbar" type="text" name="search" placeholder="Search.."><br/><br/>
      <button id="search" onclick="search()">Search</button>
      <?php
      recentSongs();
      topPlays();
      usersIfollow();
      ?>
      
   </body>
</html>