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
if(isset($_POST['submit']) && ($_POST['submit']=="submit")){
	$manufacturer=$_POST['manufacturer'];
	$type=$_POST['type'];
	$sn=$_POST['sn'];
	$status=$_POST['status'];
	$curl = curl_init();
	curl_setopt_array($curl,array(
		CURLOPT_URL => "https://ec2-18-222-91-70.us-east-2.compute.amazonaws.com/api/insert?manufacturer=$manufacturer&type=$type&sn=$sn&status=$status",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_SSL_VERIFYPEER => false
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	if($err){
			echo"<h3>Curl Error Search API #: $err</h3>";
			die();
	}
	else
		$results = json_decode($response, true);
	$tmp=explode(":",$results[0]);
	$status=trim($tmp[1]);
	if ($status=="Success")
	{
		$tmp=explode(":",$results[1]);
		$data=trim($tmp[1]);
		echo $data;
	}
	else{
		echo $results;
	}
}
elseif(isset($_POST['submit1']) && ($_POST['submit1']=="submit1")){
	$type=$_POST['type'];
	$status=$_POST['status'];
	$curl = curl_init();
	curl_setopt_array($curl,array(
		CURLOPT_URL => "https://ec2-18-222-91-70.us-east-2.compute.amazonaws.com/api/insert?type=$type&status=$status",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_SSL_VERIFYPEER => false
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	if($err){
			echo"<h3>Curl Error Search API #: $err</h3>";
			die();
	}
	else
		$results = json_decode($response, true);
	$tmp=explode(":",$results[0]);
	$status=trim($tmp[1]);
	if ($status=="Success")
	{
		$tmp=explode(":",$results[1]);
		$data=trim($tmp[1]);
		echo $data;
	}
	else{
		echo $results;
	}
}
elseif(isset($_POST['submit2']) && ($_POST['submit2']=="submit2")){
	$manufacturer=$_POST['manufacturer'];
	$status=$_POST['status'];
	$curl = curl_init();
	curl_setopt_array($curl,array(
		CURLOPT_URL => "https://ec2-18-222-91-70.us-east-2.compute.amazonaws.com/api/insert?manufacturer=$manufacturer&status=$status",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_SSL_VERIFYPEER => false
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	if($err){
			echo"<h3>Curl Error Search API #: $err</h3>";
			die();
	}
	else
		$results = json_decode($response, true);
	$tmp=explode(":",$results[0]);
	$status=trim($tmp[1]);
	if ($status=="Success")
	{
		$tmp=explode(":",$results[1]);
		$data=trim($tmp[1]);
		echo $data;
	}
	else{
		echo $results;
	}
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
    <button type="submit" name="submit1" value="submit1">Submit</button>
    </form>';
	echo '<h1>Add New Manufacturer: </h1>
    <form method="POST" action="">
	<label>Add new manufacturer:</label>
    <input type="text" name="manufacturer" required>
	<label>Status:</label>
    <input type="text" name="status" required>
    <button type="submit" name="submit2" value="submit2">Submit</button>
    </form>';
	$time_end = microtime( true );
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}

?>