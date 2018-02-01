<?php 
if (!isset($_REQUEST['id'])) return;

$con = mysqli_connect("localhost","censored","censored","censored");
if (!$con) die('Could not connect: ' . mysql_error());

$id = mysqli_real_escape_string($con, $_REQUEST['id']);
$q = "SELECT * from t164221v3_news where id='$id'";


$result=mysqli_query($con,$q);
$values=mysqli_fetch_assoc($result);

$title = htmlspecialchars($values["title"]);
$text = htmlspecialchars($values["text"]);
$id = $values["id"];

echo "	<table>
			<tr>
				<td class='post-open-title'>$title</td>
			</tr>
			<tr>
				<td class='post-open-text'><div class='wordwrap'>$text</div></td>
			</tr>
			<tr>
				<td class='post-open-comments-title noselect'>Comments</td>
			</tr>
			<tr>
				<td class='post-open-comments-container'>There will be comments</td>
			</tr>
		</table>";

?>