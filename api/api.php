<?php
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');

$url=$_SERVER['REQUEST_URI'];
$path=parse_url($url,PHP_URL_PATH);
$pathComp=explode("/",trim($path,"/"));
$endPoint=$pathComp[1];
function db_iconnect($dbName)
{
    $un="root";
    $pw="Vg139671";
    $db=$dbName;
    $hostname="localhost";
    $dblink=new mysqli($hostname,$un,$pw,$db);
    return $dblink;
}
switch($endPoint)
{
	case "search":
		include("search.php");
		break;
	case "insert":
		include("insert.php");
		break;
	default:
		$output[]='Status: Error';
		$output[]='MSG: '.$endPoint.' Endpoint Not Found';
		$output[]='Action: None';
		$responseData=json_encode($output);
		echo $responseData;
}
?>