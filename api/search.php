<?php
if (!isset($_REQUEST['manufacturer'])){
	$output[]='Status: Error';
	$output[]='MSG: Manufacturer Endpoint Not Found';
	$output[]='Action: Resend Manufacturer Data';
	$responseData=json_encode($output);
	echo $responseData;
	die();
}
if (!isset($_REQUEST['type'])){
	$output[]='Status: Error';
	$output[]='MSG: Type Endpoint Not Found';
	$output[]='Action: Resend Type Data';
	$responseData=json_encode($output);
	echo $responseData;
	die();
}
if ($_REQUEST['manufacturer']=="all")
	$manu="`manufacturer` like '%'";
else
	$manu="`manufacturer`='$_REQUEST[manufacturer]'";
if ($_REQUEST['type']=="all")
	$type="`type` like '%'";
else
	$type="`type`='$_REQUEST[type]'";

$info=array();
$time_start=microtime(true);
$dblink=db_iconnect("ase");
$sql="Select * from `equipment_prod` where $manu and $type limit 1000";
$result=$dblink->query($sql) or
	die("Something went wrong: $sql<br>".$dblink->error);
while ($data=$result->fetch_array(MYSQLI_ASSOC)){
	$sql="Select `name_type` from `type` where `auto_id`='$data[type]'";
	$rst=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$tmp=$rst->fetch_array(MYSQLI_ASSOC);
	$type=$tmp['name_type'];
	$sql="Select `name_manu` from `manufacturer` where `auto_id`='$data[manufacturer]'";
	$rst=$dblink->query($sql) or
		die("Something went wrong: $sql<br>".$dblink->error);
	$tmp=$rst->fetch_array(MYSQLI_ASSOC);
	$manufacturer=$tmp['name_manu'];
	$info[]=array($type,$manufacturer,$data['serialNum']);
}
$infoJson=json_encode($info);
$time_end=microtime(true);
$seconds=$time_end-$time_start;
$execution_time=($seconds)/60;
	$output[]='Status: Success';
	$output[]='MSG: '.$infoJson;
	$output[]='Action: '.$execution_time.'';
	$responseData=json_encode($output);
	echo $responseData;
?>