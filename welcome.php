<?php
    include("sidenav/sidenav.html");
	/*session_start();

// Check if user is logged in
if(isset($_SESSION["username"])) {
    $fname = $_SESSION["username"];
} else {
    // Redirect user to login page if not logged in
    header("Location: login.html");
    exit();
}*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard </title>
    <link rel = "icon" href = "./images/hands.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    
    <style>
        .test{
            margin-left:16%;
        }
        #logout{
            float:right;
        }
    </style>
</head>
<body>
    <div class="test">
    <div class = "dash-head">
        <h1>Welcome To your dash board</h1><br>
        <div>
            <button id = "logout">Log Out</button>
        </div>
    </div>
</body>
</html>