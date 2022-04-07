<?php
session_start();

$sname= "sql102.epizy.com";

$unmae= "epiz_30548035";

$password = "jNdZ73D4XOMEj";

$db_name = "epiz_30548035_bakalarka";


$con = mysqli_connect($sname, $unmae, $password, $db_name);


include('DBconnect.php');
$username = $_POST['user'];
$password = $_POST['pass'];

//to prevent from mysqli injection
$username = stripcslashes($username);
$password = stripcslashes($password);
$username = mysqli_real_escape_string($con, $username);
$password = mysqli_real_escape_string($con, $password);

$sql = "select * from login where username = '$username' and password = '$password'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);

if($count == 1){
    echo "<h1> Login successful </h1>";
    $_SESSION["login"] = true;
}
else{
    echo "<h1> Login failed. Invalid username or password.</h1>";
}


mysqli_close($con);
?>

<link rel = "stylesheet" type = "text/css" href = "../style/style.css">

<a href="index.php">Back</a>
