<?php 
session_start();

if (!isset($_REQUEST['vote']) || !isset($_REQUEST['id'])) return;
if(!isset($_SESSION['name'])) {echo "You are not logged in"; return;}

$con = mysqli_connect("localhost","censored","censored","censored");
if (!$con) die('Could not connect: ' . mysql_error());

$name = $_SESSION['name'];
$vote = mysqli_real_escape_string($con, $_REQUEST['vote']);
$postid = mysqli_real_escape_string($con, $_REQUEST['id']);



$q = "SELECT * from t164221_votes where voter='$name' and postid='$postid'";

$result=mysqli_query($con,$q);
$values=mysqli_fetch_assoc($result);

if (!isset($values)) {
	$q = "INSERT INTO t164221_votes (postid, voter, vote) VALUES('$postid', '$name', '$vote')";
	mysqli_query($con,$q);
	echo "Voted!";
	return;
} else {
	$voteid=$values['id'];
	$q = "UPDATE t164221_votes SET vote='$vote' WHERE id='$voteid'";
	mysqli_query($con,$q);
	echo "Voted!";
	return;
}
?>