<?php
?>
<html>
   
   <head>
      <title>Sign Up To Music Service</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script>
      function signUp() {
         var username = $("#username").val();
         var name = $("#name").val();
         var city = $("#city").val();
         var pass = $("#pass").val();
         var cpass = $("#cpass").val();
         var email = $("#email").val();
         $.post("insertUser.php",
            {  username: username,
               name: name,
               city: city,
               pass: pass,
               email: email
            },
            function(data){
               window.location.href = "welcome.php";
            });
      }

      </script>
      
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
         <div style = "width:350px; border: solid 1px #333333; " align = "right">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Sign Up</b></div>
            
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>UserName*  :</label><input type = "text" id = "username" name = "username" class = "box"/><br /><br />
                  <label>Name  :</label><input type = "text" id = "name" name = "name" class = "box"/><br /><br />
                  <label>City  :</label><input type = "text" id = "city" name = "city" class = "box"/><br /><br />
                  <label>Password*  :</label><input type = "password" id = "pass" name = "password" class = "box" /><br/><br />
                  <label>Confirm Password*  :</label><input id = "cpass" type = "password" name = "confirmpassword" class = "box" /><br/><br />
                  <label>Email*  :</label><input type = "text" id = "email" name = "username" class = "box"/><br /><br />
                  <input type = "submit" onclick="signUp()" value = " Submit "/><br />
               </form>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
               
            </div>
            
         </div>
         
      </div>

   </body>
</html>