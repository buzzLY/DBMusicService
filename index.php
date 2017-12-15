<?php
session_start();
include "dbconnection.php";
if($_SERVER["REQUEST_METHOD"] == "POST") {

   $myusername = mysqli_real_escape_string($connection,trim($_POST['username']));
   $mypassword = mysqli_real_escape_string($connection,trim($_POST['password']));
   $sql = "SELECT * FROM User WHERE username = '$myusername' and upassword = '$mypassword'";
   //$sql = "select * from User";
   $result = mysqli_query($connection,$sql);
   $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
   $count = mysqli_num_rows($result);
   if($count == 1) {
         //session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         header("location: welcome.php");
      } else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
<html>
   
   <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <title>Login To Music Service</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
   
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "right">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
            
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>
               <button id="signup" type="button" onClick="document.location.href='signup.php'">Sign Up</button>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px</div> 
               
            </div>
            
         </div>
         
      </div>

   </body>
</html>