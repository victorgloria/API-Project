<?php
function db_iconnect($dbName)
{
    $un="root";
    $pw="Vg139671";
    $db=$dbName;
    $hostname="localhost";
    $dblink=new mysqli($hostname,$un,$pw,$db);
    return $dblink;
}

if(isset($_POST['submit']) && ($_POST['submit']=="submit"))
{
$dblink=db_iconnect("ase");
$time_start = microtime( true );
$query=$_POST['manufacture'];
$sql="Select `type`,`serialNum` from `equipment_prod` where `manufacture`='$query'";
$result=$dblink->query($sql) or
	die("Something went wrong: $sql<br>".$dblink->error);
echo '<h3>Search by manufacturer: '.$query.'</h3>';
echo '<table>';
echo '<tr><td>Type</td><td>Serial Number</td></tr>';
while ($data=$result->fetch_array(MYSQLI_ASSOC)){
	echo '<tr>';
	echo '<td>'.$data['type'].'</td>';
	//echo "<td>$data[manufacture]</td>";
	echo "<td>$data[serialNum]</td>";
	echo "</tr>";
}
echo "</table>";
$time_end = microtime( true );
$seconds = $time_end - $time_start;
$execution_time = ( $seconds ) / 60;
echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}
else
{
	echo '<h3>No Post Data Recieved</h3>';
}
?>