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

if(isset($_POST['submit']) && ($_POST['submit']=="submit") && isset($_POST['options']) && ($_POST['options']=="type")){
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$sql="Select `name_type` from `type`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo '<form method="post" action="">';
	echo '<p>Type: </p>';
	echo '<select name="type">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	echo '<p>Filter by: </p>';
	$sql="Select `name_manu` from `manufacturer`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo '<select name="manufacturer">';
	echo '<option value=all>All</option>';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select><br><br>';
	echo '<input type="number" name="startnum" value=0><br>';
	echo '<p>Use number box to set from which number id to start displaying (Results display 10,000 records at a time)</p>';
	echo '<button type="submit" name="submit_results" value="submit_results">Submit</button>';
	echo '</form>';
	$time_end = microtime( true );
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}
elseif(isset($_POST['submit']) && ($_POST['submit']=="submit") && isset($_POST['options']) && ($_POST['options']=="manufacturer")){
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$sql="Select `name_manu` from `manufacturer`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo '<form method="post" action="">';
	echo '<p>Manufacturer: </p>';
	echo '<select name="manufacturer">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	echo '<p>Filter by: </p>';
	$sql="Select `name_type` from `type`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo '<select name="type">';
	echo '<option value=all>All</option>';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select><br><br>';
	echo '<input type="number" name="startnum" value=0><br>';
	echo '<p>Use number box to set from which number id to start displaying (Results display 10,000 records at a time)</p>';
	echo '<button type="submit" name="submit_results_manu" value="submit_results_manu">Submit</button>';
	echo '</form>';
	$time_end = microtime( true );
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}
elseif(isset($_POST['submit']) && ($_POST['submit']=="submit") && isset($_POST['options']) && ($_POST['options']=="all")){
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$current = $_POST['startnum'];
	$sql="SELECT equipment_prod.auto_id AS `id`, type.name_type AS `type`, equipment_prod.serialNum AS `sn`, manufacturer.name_manu AS `manufacturer` FROM ((equipment_prod INNER JOIN type ON equipment_prod.type = type.auto_id) INNER JOIN manufacturer ON equipment_prod.manufacturer = manufacturer.auto_id) where equipment_prod.auto_id >= $current ORDER BY equipment_prod.auto_id ASC LIMIT 10000";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);

	echo '<h2>ALL</h2>';
	echo '<table>';
	echo '<tr><td>ID</td><td>Type</td><td>Serial Number</td><td>Manufacturer</td></tr>';
	while ($data=$result->fetch_array(MYSQLI_ASSOC)){
		echo '<tr>';
		echo '<td>'.$data['id'].'</td>';
		echo '<td>'.$data['type'].'</td>';
		echo '<td>'.$data['sn'].'</td>';
		echo '<td>'.$data['manufacturer'].'</td>';
		echo "</tr>";
	}
	echo "</table>";
	$time_end = microtime( true );
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}
elseif(isset($_POST['submit']) && ($_POST['submit']=="submit") && isset($_POST['options']) && ($_POST['options']=="sn")){
	echo '<form method="post" action="">';
	echo '<h1>Search by SN: </h1>';
	echo '<input type="text" id="sn" name="sn" value="SN-">';
	echo '<label for="sn">Serial Number</label><br>';
	echo '<button type="submit_sn" name="submit_sn" value="submit_sn">Submit</button>';
	echo '</form>';
}
elseif(isset($_POST['submit_sn']) && ($_POST['submit_sn']=="submit_sn")){
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$query=$_POST['sn'];
	$sql="SELECT equipment_prod.auto_id AS `id`, type.name_type AS `type`, manufacturer.name_manu AS `manufacturer` FROM ((equipment_prod INNER JOIN type ON equipment_prod.type = type.auto_id) INNER JOIN manufacturer ON equipment_prod.manufacturer = manufacturer.auto_id) where equipment_prod.serialNum = '$query'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo '<h2>Serial Number '.$query.'</h2>';
	echo '<table>';
	echo '<tr><td>ID</td><td>Type</td><td>Manufacturer</td></tr>';
	while ($data=$result->fetch_array(MYSQLI_ASSOC)){
		echo '<tr>';
		echo '<td>'.$data['id'].'</td>';
		echo '<td>'.$data['type'].'</td>';
		echo '<td>'.$data['manufacturer'].'</td>';
		echo "</tr>";
	echo "</table>";
	}
	$time_end = microtime( true );
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}
elseif(isset($_POST['submit_results']) && ($_POST['submit_results']=="submit_results")){
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$query=$_POST['type'];
	$current = $_POST['startnum'];
	$querymanu=$_POST['manufacturer'];
	$sql="select auto_id from type where name_type='$query'";
	$type_num=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$type_data=$type_num->fetch_array(MYSQLI_ASSOC);
	if($querymanu == 'all'){
		$sql="SELECT equipment_prod.auto_id AS `id`, manufacturer.name_manu AS `name`, equipment_prod.serialNum AS `sn` FROM equipment_prod INNER JOIN manufacturer ON equipment_prod.manufacturer = manufacturer.auto_id WHERE equipment_prod.type = '$type_data[auto_id]' AND equipment_prod.auto_id >= $current ORDER BY equipment_prod.auto_id ASC LIMIT 10000";
	}
	else{
		$sql="SELECT equipment_prod.auto_id AS `id`, manufacturer.name_manu AS `name`, equipment_prod.serialNum AS `sn` FROM equipment_prod INNER JOIN manufacturer ON equipment_prod.manufacturer = manufacturer.auto_id WHERE equipment_prod.type = '$type_data[auto_id]' AND manufacturer.name_manu = '$querymanu' AND equipment_prod.auto_id >= $current ORDER BY equipment_prod.auto_id ASC LIMIT 10000";
	}
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo '<h2>Searching Type: '.$query.'</h2>';
	echo '<h2>Filtering by: '.$querymanu.'</h2>';
	echo '<table>';
	echo '<tr><td>ID</td><td>Type</td><td>Serial Number</td></tr>';
	while ($data=$result->fetch_array(MYSQLI_ASSOC)){
		echo '<tr>';
		echo '<td>'.$data['id'].'</td>';
		echo '<td>'.$data['name'].'</td>';
		echo '<td>'.$data['sn'].'</td>';
		echo "</tr>";
	}
	echo "</table>";
	$time_end = microtime( true );
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}
elseif(isset($_POST['submit_results_manu']) && ($_POST['submit_results_manu']=="submit_results_manu")){
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$query=$_POST['manufacturer'];
	$querytype=$_POST['type'];
	$current = $_POST['startnum'];
	$sql="select auto_id from manufacturer where name_manu='$query'";
	$manu_num=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$manu_data=$manu_num->fetch_array(MYSQLI_ASSOC);
	if($querytype == 'all'){
		$sql="SELECT equipment_prod.auto_id AS `id`, type.name_type AS `name`, equipment_prod.serialNum AS `sn` FROM equipment_prod INNER JOIN type ON equipment_prod.type = type.auto_id WHERE equipment_prod.manufacturer = '$manu_data[auto_id]' AND equipment_prod.auto_id >= $current ORDER BY equipment_prod.auto_id ASC LIMIT 10000";
	}
	else{
		$sql="SELECT equipment_prod.auto_id AS `id`, type.name_type AS `name`, equipment_prod.serialNum AS `sn` FROM equipment_prod INNER JOIN type ON equipment_prod.type = type.auto_id WHERE equipment_prod.manufacturer = '$manu_data[auto_id]' AND type.name_type = '$querytype' AND equipment_prod.auto_id >= $current ORDER BY equipment_prod.auto_id ASC LIMIT 10000";
	}
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo '<h2>Searching Type: '.$query.'</h2>';
	echo '<h2>Filtering by: '.$querytype.'</h2>';
	echo '<table>';
	echo '<tr><td>ID</td><td>Type</td><td>Serial Number</td></tr>';
	while ($data=$result->fetch_array(MYSQLI_ASSOC)){
		echo '<tr>';
		echo '<td>'.$data['id'].'</td>';
		echo '<td>'.$data['name'].'</td>';
		echo '<td>'.$data['sn'].'</td>';
		echo "</tr>";
	}
	echo "</table>";
	$time_end = microtime( true );
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}
else{
	echo '<form method="post" action="">';
	echo '<h1>Search by: </h1>';
	echo '<input type="radio" id="type" name="options" value="type">';
	echo '<label for="type">Type</label><br>';
	echo '<input type="radio" id="manufacturer" name="options" value="manufacturer">';
	echo '<label for="manufacturer">Manufacturer</label><br>';
	echo '<input type="radio" id="sn" name="options" value="sn">';
	echo '<label for="sn">Serial Number</label><br>';
	echo '<input type="radio" id="all" name="options" value="all">';
	echo '<label for="all">All </label>';
	echo '<input type="number" name="startnum" value=0><br>';
	echo '<button type="submit" name="submit" value="submit">Submit</button>';
	echo '<p>Use number box to set from which number id to start displaying (Results display 10,000 records at a time)</p>';
	echo '</form>';
}
?>