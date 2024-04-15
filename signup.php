<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up | Maharashtra Medical</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel = "stylesheet" href="C:\Users\user\OneDrive\Desktop\Project\CSS\signupp.css">
    <link rel = "icon" href = "./images/hands.png">
    <link rel = "stylesheet" href="./CSS/signupp.css">
    <style>
       /**/
    </style>
</head>
<body>
    <div class = "form-container">
        <form action = "signup.php" method="POST">
          <h1>Sign Up</h1>
          <div class = "lab">
            <label for="name">Name:</label><br>
          </div>
            <input type="text" id="Name" name="firname" placeholder="Enter your name" required><br><br>
          <div class = "lab">
            <label for ="surname">Surname:</label><br>
          </div>
            <input type="text" id="Surname" name="surname"placeholder="Enter your Surname" required><br><br>
          <div class = "lab">
            <label for="email">Email:</label><br>
          </div>
            <input type="email" id="Email" name="email"placeholder="Enter your Email" required><br><br>
          <div class = "lab">
            <label for="phone">Phone:</label><br>
          </div>
            <input type = "text" id="Phone" name="phone"placeholder="Enter your phone number" maxlength="10" required><br><br>
          <div class = "lab">
            <label for="gender">Gender:</label><br>
          </div>
            <select name="gender" id="Gender" required>
                <option disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select> 
              
              <br><br>
              <div class = "lab">
                <label for="dob" id="DOB">Date of Birth:</label><br>
              </div>
              <input type="date" id="DOB" name="dob"><br><br>
              <div class = "lab">
                <label for="qualification" id = "Qualification">Qualification:</label><br>
              </div>
              <select name="qualification" id="Qualification" required>
                <option disabled selected>Select Qualification</option>
                <option value="10p">10th Pass</option>
                <option value="12p">12th Pass</option>
                <option value="BSPS">Bachelor in Pharmaceutical Studies</option>
                <option value="Phd">Masters in Pharmaceutical Studies</option>
              </select><br><br>
              <div class = "lab">
                <label for="password">Enter Password:</label><br>
              </div>
              <input type = "password" id="pwd" name="password" minlength="8" placeholder="Enter Password" required> <br>
              <div>
                <input id = "pass" type="checkbox" onclick="myFunction()" placeholder="Show Password">
                <label for = "showpass">Show Password</label>
              </div>
              
              <script>
                function myFunction() {
          var x = document.getElementById("pwd");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }
            </script>
              <br><br>
            </script>
            <input type="submit" value="Submit" name = "submit">
            <input type="reset" value="Reset">
        </form>
      </div>
</body>
</html>

<?php
    include "database.php";
 
  if($_SERVER["REQUEST_METHOD"] == "POST"){

    $fname = filter_input(INPUT_POST,"firname",FILTER_SANITIZE_SPECIAL_CHARS);
    $sname = filter_input(INPUT_POST,"surname",FILTER_SANITIZE_SPECIAL_CHARS);
    $email = $_POST["email"];
    $phone = filter_input(INPUT_POST,"phone",FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $qualification = $_POST["qualification"];
    $password = $_POST["password"];
    $hash = password_hash($password,PASSWORD_DEFAULT);
    try{
      $sql = "INSERT INTO USER_INFO(FName,SName,Email,Phone,gender,DOB,Qualification,Password)VALUES('$fname','$sname','$email',$phone,'$gender','$dob','$qualification','$hash')";
      $result = mysqli_query($conn,$sql);
      echo "<script>alert('User Created!');</script>";
      if($result){
        echo "<script>window.location.href = 'main.php';</script>";
        exit();
      }
    }
    catch(mysqli_sql_exception $e){
      //echo "An exception occurred: " . $e->getMessage();
      echo "<script>alert('Error :{$e->getMessage()}');</script>";
      //header("signup.html");
    }
  }
  mysqli_close($conn);
?>