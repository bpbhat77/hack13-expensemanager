<?php 
include 'dbc.php';
$req = "SELECT user_name "
	."FROM users "
	."WHERE user_name LIKE '%".$_REQUEST['term']."%' "; 
$query = mysql_query($req);

while($row = mysql_fetch_array($query))
{
	$results[] = array('label' => $row['user_name']);
}
echo json_encode($results);
?>