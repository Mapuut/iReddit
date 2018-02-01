<?php 
// Start the session
session_start();

if (!isset($_REQUEST['name']) || !isset($_REQUEST['password'])) return;

$con = mysqli_connect("localhost","censored","censored","censored");
if (!$con) die('Could not connect: ' . mysql_error());


$name = mysqli_real_escape_string($con, $_REQUEST['name']);
$password = mysqli_real_escape_string($con, $_REQUEST['password']);

if (strlen($name) < 1 || strlen($password) < 1){
	echo "Username or Password field is not filled";
	return;
}

$q = "SELECT * from t164221v2_users where username='$name'";

$result=mysqli_query($con,$q);
$values=mysqli_fetch_assoc($result);

if (!isset($values)) {
	echo "User dosen't excist!";
	return;
}

if ($values['password'] === $password) {
	$_SESSION['name'] = $name;
	echo "Login successful!";
} else {
	echo "Wrong password";
}

?>