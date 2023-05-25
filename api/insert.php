<?php
if(isset($_REQUEST['manufacturer'])&&isset($_REQUEST['type'])&&isset($_REQUEST['sn'])&&isset($_REQUEST['status'])){
$manufacturer=$_REQUEST['manufacturer'];
$type=$_REQUEST['type'];
$sn=$_REQUEST['sn'];
$status=$_REQUEST['status'];
	$dblink=db_iconnect("ase");
	$sql="Select `auto_id` from `type` where `name_type`='$type'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$data1=$result->fetch_array(MYSQLI_NUM);
	$type=$data1[0];
	$manu=$_POST['manufacturer'];
	$sql="Select `auto_id` from `manufacturer` where `name_manu`='$manufacturer'";
	$result=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$data1=$result->fetch_array(MYSQLI_NUM);
	$manufacturer=$data1[0];
$info=array();
$sql="INSERT INTO `equipment_prod`(`type`, `manufacturer`, `serialNum`, `status`) VALUES ('$type','$manufacturer','$sn','$status')";
try {
    $result=$dblink->query($sql);
} catch (PDOException $e) {
    $data = "Error: " . $e->getMessage();
	$responseData=json_encode($data);
	echo $responseData;
} catch (mysqli_sql_exception $e) {
    $data = "Error: " . $e->getMessage();
	$responseData=json_encode($data);
	echo $responseData;
}
    if ($result == 1)
    {
        $data[] = "Status: Success";
		$data[] = "MSG: Data Saved";
    }
	$responseData=json_encode($data);
	echo $responseData;
}
elseif(isset($_REQUEST['type'])&&isset($_REQUEST['status'])){
$type=$_REQUEST['type'];
$status=$_REQUEST['status'];
$dblink=db_iconnect("ase");
$info=array();
$sql="INSERT INTO `type`(`name_type`,`status`) VALUES ('$type','$status')";
try {
    $result=$dblink->query($sql);
} catch (PDOException $e) {
    $data = "Error: " . $e->getMessage();
	$responseData=json_encode($data);
	echo $responseData;
} catch (mysqli_sql_exception $e) {
    $data = "Error: " . $e->getMessage();
	$responseData=json_encode($data);
	echo $responseData;
}
    if ($result == 1)
    {
        $data[] = "Status: Success";
		$data[] = "MSG: Data Saved";
    }
	$responseData=json_encode($data);
	echo $responseData;
}
elseif(isset($_REQUEST['manufacturer'])&&isset($_REQUEST['status'])){
$manufacturer=$_REQUEST['manufacturer'];
$status=$_REQUEST['status'];
$dblink=db_iconnect("ase");
$info=array();
$sql="INSERT INTO `manufacturer`(`name_manu`,`status`) VALUES ('$manufacturer','$status')";
try {
    $result=$dblink->query($sql);
} catch (PDOException $e) {
    $data = "Error: " . $e->getMessage();
	$responseData=json_encode($data);
	echo $responseData;
} catch (mysqli_sql_exception $e) {
    $data = "Error: " . $e->getMessage();
	$responseData=json_encode($data);
	echo $responseData;
}
    if ($result == 1)
    {
        $data[] = "Status: Success";
		$data[] = "MSG: Data Saved";
    }
	$responseData=json_encode($data);
	echo $responseData;
}
?>