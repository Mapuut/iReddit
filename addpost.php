<?php 
session_start();

if (!isset($_REQUEST['title']) || !isset($_REQUEST['text'])) return;
if(!isset($_SESSION['name'])) {echo "You are not logged in"; return;}

$con = mysqli_connect("localhost","censored","censored","censored");
if (!$con) die('Could not connect: ' . mysql_error());


$title = mysqli_real_escape_string($con, $_REQUEST['title']);
$text = mysqli_real_escape_string($con, $_REQUEST['text']);
$name = $_SESSION['name'];

if (strlen($title) < 1 || strlen($text) < 1){
	echo "Some of the fields are not filled";
	return;
}
if (strlen($text) > 500) {
	echo "Too long post, 500 chars max. You have " . strlen($text);
	return;
}

$q = "INSERT INTO t164221v3_news (title, text, adder) VALUES('$title', '$text', '$name')";

mysqli_query($con,$q);
echo "Post added!";
?>