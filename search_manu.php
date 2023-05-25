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
else{
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$sql="Select distinct(`name_type`) from `type`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql <br>".$dblink->error);
	echo '<form method="post" action="">';
	echo '<p>Search by: <p>';
	echo '<input type="radio" id="type" name="options" value="type">';
	echo '<label for="type">Type</label><br>';
	echo '<input type="radio" id="manufacturer" name="options" value="manufacturer">';
	echo '<label for="manufacturer">Manufacturer</label><br>';
	echo '<input type="radio" id="sn" name="options" value="sn">';
	echo '<label for="sn">Serial Number</label><br>';
	echo '<input type="radio" id="all" name="options" value="all">';
	echo '<label for="all">All</label><br>';
	$answer = $_POST['options'];
	if ($answer === "type"){
		echo '<p>correct</p>';
	}
	else{
		echo '<p>incorrect</p>';
	}
	echo '<select name="manufacture">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	echo '<button type="submit" name="submit" value="submit">Submit</button>';
	echo '</form>';
	$time_end = microtime( true );
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}
?>