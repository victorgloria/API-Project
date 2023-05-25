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
	$time_end = microtime( true );
	$type=$_POST['type'];
	$sql="Select `auto_id` from `type` where `name_type`='$type'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$data=$result->fetch_array(MYSQLI_NUM);
	$type=$data[0];
	$manu=$_POST['manufacturer'];
	$sql="Select `auto_id` from `manufacturer` where `name_manu`='$manu'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$data=$result->fetch_array(MYSQLI_NUM);
	$manu=$data[0];
	$sn=$_POST['sn'];
	$stat=$_POST['status'];
	$sql="INSERT INTO `equipment_prod`(`type`, `manufacturer`, `serialNum`, `status`) VALUES ('$type','$manu','$sn','$stat')";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	
	if ($result === false) {
		echo "Error: " . mysqli_error($dblink);
	} else {
		echo mysqli_affected_rows($dblink) . " rows inserted";
	}
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}
elseif(isset($_POST['submit2']) && ($_POST['submit2']=="submit2"))
{
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$time_end = microtime( true );
	$type=$_POST['type'];
	$stat=$_POST['status'];
	$sql="INSERT INTO `type`(`name_type`,`status`) VALUES ('$type','$stat')";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	
	if ($result === false) {
		echo "Error: " . mysqli_error($dblink);
	} else {
		echo mysqli_affected_rows($dblink) . " rows inserted";
	}
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";

}
elseif(isset($_POST['submit3']) && ($_POST['submit3']=="submit3"))
{
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$time_end = microtime( true );
	$type=$_POST['manufacturer'];
	$stat=$_POST['status'];
	$sql="INSERT INTO `manufacturer`(`name_manu`,`status`) VALUES ('$type','$stat')";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	
	if ($result === false) {
		echo "Error: " . mysqli_error($dblink);
	} else {
		echo mysqli_affected_rows($dblink) . " rows inserted";
	}
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";

}
elseif(isset($_POST['submit4']) && ($_POST['submit4']=="submit4"))
{
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$time_end = microtime( true );
	$id=$_POST['id'];
	$type=$_POST['type'];
	$sql="Select `auto_id` from `type` where `name_type`='$type'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$data=$result->fetch_array(MYSQLI_NUM);
	$type=$data[0];
	$manu=$_POST['manufacturer'];
	$sql="Select `auto_id` from `manufacturer` where `name_manu`='$manu'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$data=$result->fetch_array(MYSQLI_NUM);
	$manu=$data[0];
	$stat=$_POST['status'];
	$sql="UPDATE `equipment_prod` SET `type`='$type',`manufacturer`='$manu',`status`='$stat' WHERE `auto_id`='$id'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	
	if ($result === false) {
		echo "Error: " . mysqli_error($dblink);
	} else {
		echo mysqli_affected_rows($dblink) . " rows inserted";
	}
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";

}
elseif(isset($_POST['submit5']) && ($_POST['submit5']=="submit5"))
{
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$time_end = microtime( true );
	$type=$_POST['type'];
	$newname=$_POST['newname'];
	$stat=$_POST['status'];
	$sql="UPDATE `type` SET `name_type`='$newname',`status`='$stat' WHERE `name_type`='$type'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	
	if ($result === false) {
		echo "Error: " . mysqli_error($dblink);
	} else {
		echo mysqli_affected_rows($dblink) . " rows inserted";
	}
	$sql="Select `auto_id` from `type` where `name_type`='$type'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$data=$result->fetch_array(MYSQLI_NUM);
	$type=$data[0];
	$sql="UPDATE `equipment_prod` SET `status`='$stat' WHERE `type`='$type'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";

}
elseif(isset($_POST['submit6']) && ($_POST['submit6']=="submit6"))
{
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$time_end = microtime( true );
	$manu=$_POST['manufacturer'];
	$newname=$_POST['newname'];
	$stat=$_POST['status'];
	$sql="UPDATE `manufacturer` SET `name_manu`='$newname',`status`='$stat' WHERE `name_manu`='$manu'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	
	if ($result === false) {
		echo "Error: " . mysqli_error($dblink);
	} else {
		echo mysqli_affected_rows($dblink) . " rows inserted";
	}
	$sql="Select `auto_id` from `manufacturer` where `name_manu`='$manu'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$data=$result->fetch_array(MYSQLI_NUM);
	$manu=$data[0];
	$sql="UPDATE `equipment_prod` SET `status`='$stat' WHERE `manufacturer`='$manu'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";

}
else{
	
echo '<h1>Add New Device: </h1>
  <form method="POST" action="">';
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$sql="Select `name_type` from `type`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo '<label>Type:</label>';
	echo '<select name="type">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	$sql="Select `name_manu` from `manufacturer`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo' <label>Manufacturer:</label>';
	echo '<select name="manufacturer">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	echo'
    <label>Status:</label>
    <input type="text" name="status" required>
	<label>SN:</label>
    <input type="text" name="sn" required>
    <button type="submit" name="submit" value="submit">Submit</button>
  </form>';
	echo '<h1>Add New Type: </h1>
    <form method="POST" action="">
	<label>Add New Type:</label>
    <input type="text" name="type" required>
	<label>Status:</label>
    <input type="text" name="status" required>
    <button type="submit" name="submit2" value="submit2">Submit</button>
    </form>';
	echo '<h1>Add New Manufacturer: </h1>
    <form method="POST" action="">
	<label>Add new manufacturer:</label>
    <input type="text" name="manufacturer" required>
	<label>Status:</label>
    <input type="text" name="status" required>
    <button type="submit" name="submit3" value="submit3">Submit</button>
    </form>';
	echo '<h1>Modify device: </h1>
    <form method="POST" action="">
	<label>Device ID:</label>
    <input type="number" name="id" required>';
	$sql="Select `name_type` from `type`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo '<label>Type:</label>';
	echo '<select name="type">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	$sql="Select `name_manu` from `manufacturer`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo' <label>Manufacturer:</label>';
	echo '<select name="manufacturer">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	echo'<label>Status:</label>
    <input type="text" name="status" required>
	<button type="submit" name="submit4" value="submit4">Submit</button>
    </form>';
	echo '<h1>Modify type: </h1>
    <form method="POST" action="">';
	$sql="Select `name_type` from `type`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo '<label>Type:</label>';
	echo '<select name="type">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo'</select>
	<label>New name type:</label>
    <input type="text" name="newname" required>
	<label>Status:</label>
    <input type="text" name="status" required>
    <button type="submit" name="submit5" value="submit5">Submit</button>
    </form>';
	echo '<h1>Modify Manufacturer: </h1>
    <form method="POST" action="">';
	$sql="Select `name_manu` from `manufacturer`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo' <label>Manufacturer:</label>';
	echo '<select name="manufacturer">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	echo'<label>New manufacturer name</label>
    <input type="text" name="newname" required>
	<label>Status:</label>
    <input type="text" name="status" required>
    <button type="submit" name="submit6" value="submit6">Submit</button>
    </form>';
	$time_end = microtime( true );
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}
?>