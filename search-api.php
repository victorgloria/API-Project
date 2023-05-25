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
if(isset($_POST['submit_results']) && ($_POST['submit_results']=="submit_results")){
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$query=$_POST['type'];
	if($query == 'all'){
		$type = 'all';
	}
	else{
		$sql="select auto_id from type where name_type='$query'";
		$type_num=$dblink->query($sql) or
			die("Something went wrong: $sql<br>".$dblink->error);
		$type=$type_num->fetch_array(MYSQLI_ASSOC);
		$type=$type['auto_id'];
	}
	$querymanu=$_POST['manufacturer'];
	if($querymanu == 'all'){
		$manufacturer = 'all';
	}
	else{
		$sql="select auto_id from manufacturer where name_manu='$querymanu'";
		$manu_num=$dblink->query($sql) or
			die("Something went wrong: $sql<br>".$dblink->error);
		$manufacturer = $manu_num->fetch_array(MYSQLI_ASSOC);
		$manufacturer = $manufacturer['auto_id'];
	}
	$curl = curl_init();
	curl_setopt_array($curl,array(
		CURLOPT_URL => "https://ec2-18-222-91-70.us-east-2.compute.amazonaws.com/api/search?manufacturer=$manufacturer&type=$type",
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
		$data=json_decode($tmp[1],true);
		echo '<table id="results" class="display" cellspacing="0" width="100%">';
		echo '<thead>';
		echo '<th>Type</th>';
		echo '<th>Manufacturer</th>';
		echo '<th>Serial Number</th>';
		echo '</thead>';
		echo '<tbody>';
        foreach($data as $inner){
        	echo '<tr>';
        		foreach($inner as $value){
					$tmp=explode(",",$value);
					echo '<td>'.$tmp[0].'</td>';
				}
			echo '</tr>';
                
		}
        echo '</tbody>';
        echo '</table>';
   }

}
else{
	$dblink=db_iconnect("ase");
	$time_start = microtime( true );
	$sql="Select `name_type` from `type`";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	echo '<form method="post" action="">';
	echo '<p>Type: </p>';
	echo '<select name="type">';
	echo '<option value=all>All</option>';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	echo '<p>Manufacturer: </p>';
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
	echo '<button type="submit" name="submit_results" value="submit_results">Submit</button>';
	echo '</form>';
	$time_end = microtime( true );
	$seconds = $time_end - $time_start;
	$execution_time = ( $seconds ) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
}
?> 