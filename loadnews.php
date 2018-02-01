<?php 
session_start();

if (!isset($_REQUEST['tag'])) return;

$con = mysqli_connect("localhost","censored","censored","censored");
if (!$con) die('Could not connect: ' . mysql_error());

$q = "SELECT * from t164221v3_news";


$result=mysqli_query($con,$q);
$all_data = array();
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$all_data[] = $row;
}

function countScore($post) {
	$id = $post["id"];
	$q = "SELECT * from t164221_votes where postid='$id' and vote='+'";
	$result = mysqli_query($GLOBALS['con'],$q);
	$ups=mysqli_num_rows($result);
	$q = "SELECT * from t164221_votes where postid='$id' and vote='-'";
	$result = mysqli_query($GLOBALS['con'],$q);
	$downs=mysqli_num_rows($result);
	return $ups - $downs;
}


function calcHotness($votes, $age) {
	$curTime = date_timestamp_get(date_create()) / 3600;
	$item_hour_age = $curTime - $age;
	if ($votes < 1) {
		return ($votes - 1) * pow(($item_hour_age+2), 1.8);
	}
	return ($votes - 1) / pow(($item_hour_age+2), 1.8);
}

function sortHot($a, $b) {

	$datea = date_timestamp_get(date_create_from_format('Y-m-d H:i:s', $a["added"])) / 3600;
	$dateb = date_timestamp_get(date_create_from_format('Y-m-d H:i:s', $b["added"])) / 3600;

	$votesa = countScore($a);
	$votesb = countScore($b);

	$hotnessa = calcHotness($votesa, $datea);
	$hotnessb = calcHotness($votesb, $dateb);

    if ($hotnessa == $hotnessb) {
        return 0;
    }
    return ($hotnessa < $hotnessb) ? 1 : -1;
}

function sortBest($a, $b) {
	$scorea = countScore($a);
	$scoreb = countScore($b);
    if ($scorea == $scoreb) {
        return 0;
    }
    return ($scorea < $scoreb) ? 1 : -1;
}
function sortNew($a, $b) {
    return ((int)$a["id"] < (int)$b["id"]) ? 1 : -1;
}

if ($_REQUEST['tag'] === "New") {
	uasort($all_data, 'sortNew');
} elseif ($_REQUEST['tag'] === "Best") {
	uasort($all_data, 'sortBest');
} else {
	uasort($all_data, 'sortHot');
}




foreach ($all_data as $post) {
	$id = $post["id"];
	$title = htmlspecialchars($post["title"]);
	$time = $post["added"];
	$adder = htmlspecialchars($post["adder"]);

	$score = countScore($post);
	echo "	<table class='post'>
				<tr>
					<td class='post-vote noselect'>
						<table>
							<tr>
								<td class='post-vote-counter' colspan='2' id='post-vote-counter-$id'>$score</td>
							</tr>

							<tr>
								<td class='post-vote-up' onclick=\"vote('+', $id)\">+</td>
								<td class='post-vote-down' onclick=\"vote('-', $id)\">-</td>
							</tr>
						</table>
					</td>
					<td class='post-content-wrapper'>
						<table class='post-content'>
							<tr>
								<td class='post-title' onclick=\"openPost('$id')\">$title</td>
							</tr>
							<tr>
								<td class='post-comments'>x comments</td>
							</tr>
							<tr>
								<td class='post-time'>Submitted $time by $adder</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>";
}

?>