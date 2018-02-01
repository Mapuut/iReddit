<?php 

if (!isset($_REQUEST['name']) || !isset($_REQUEST['password']) || !isset($_REQUEST['fullname']) || !isset($_REQUEST['email'])) return;

$con = mysqli_connect("localhost","censored","censored","censored");
if (!$con) die('Could not connect: ' . mysql_error());


$name = mysqli_real_escape_string($con, $_REQUEST['name']);
$password = mysqli_real_escape_string($con, $_REQUEST['password']);
$fullname = mysqli_real_escape_string($con, $_REQUEST['fullname']);
$email = mysqli_real_escape_string($con, $_REQUEST['email']);

if (strlen($name) < 1 || strlen($password) < 1 || strlen($fullname) < 1 || strlen($email) < 1){
	echo "Some of the fields are not filled";
	return;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	echo "Bad E-Mail";
	return;
}

$q = "SELECT * from t164221v2_users where username='$name'";

$result=mysqli_query($con,$q);
$values=mysqli_fetch_assoc($result);

if (isset($values)) {
	echo "User already excist";
	return;
} else {
	$q = "INSERT INTO t164221v2_users (username, password, fullname, email) VALUES('$name', '$password', '$fullname', '$email')";
	mysqli_query($con,$q);
	echo "Registration successful!";
	return;
}
?>