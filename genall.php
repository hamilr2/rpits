<?
mysql_connect("localhost","root","");
mysql_select_db("rpihockey");

$cache = $_GET["cache"];
if ($cache)
{
  $query = "TRUNCATE TABLE cache";
  $result = mysql_query($query) or die("<b>YOU DID SOMETHING WRONG YOU IDIOT</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
}?>
<h3>genall.php</h3>
<form action="genall.php" method="GET">
  Clear Cache?<input type="submit" value="Empty" name="cache">
</form>


<form action="genall.php" method="GET">
Team 1: <select name="team1">
<?

$query = "SELECT * from teams";
$result = mysql_query($query) or die("<b>YOU DID SOMETHING WRONG YOU IDIOT</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
while($row = mysql_fetch_array($result)){
	echo("  <option>" . $row["name"] . "</option>");
}?>
</select>
Team 2: <select name="team2">
<?
$result = mysql_query($query) or die("<b>YOU DID SOMETHING WRONG YOU IDIOT</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
while($row = mysql_fetch_array($result)){
	echo("  <option>" . $row["name"] . "</option>");
}?>
</select>
<input type="submit" name="Submit">
</form>
<?
if ($team1 = $_GET["team1"]){
	$query="SELECT * from players WHERE team = '$team1' ORDER BY num";
	$result = mysql_query($query) or die("<b>YOU DID SOMETHING WRONG YOU IDIOT</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
	echo("<h3>Team 1: " . $team1 . "</h3>\n");
	while($row = mysql_fetch_array($result)){
		echo("<img src=\"statscard.php?id=" . $row["id"] . "\"><br>");
                echo("<img src=\"im_render_statscard.php?id=" . $row["id"] . "\" style=\"margin-left:-310px;margin-top:-795px;margin-right:-310px;margin-bottom:-35pxwidth\"><br><br>");
	}
}
if ($team2 = $_GET["team2"]){
	$query="SELECT * from players WHERE team = '$team2' ORDER BY num";
	$result = mysql_query($query) or die("<b>YOU DID SOMETHING WRONG YOU IDIOT</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
	echo("<h3>Team 2: " . $team2 . "</h3>\n");
	while($row = mysql_fetch_array($result)){
		echo("<img src=\"statscard.php?id=" . $row["id"] . "\"><br><br>");
	}
}
