<?php
function db_iconnect( $dbName ) {
  $un = "root";
  $pw = "Vg139671";
  $db = $dbName;
  $hostname = "localhost";
  $dblink = new mysqli( $hostname, $un, $pw, $db );
  return $dblink;
}
$dblink = db_iconnect( "ase" );
$sql="SELECT `auto_id` from `type` where `name`='television'";
$time_start=microtime(true);
$result=$dblink->query($sql) or
	die( "Something went wrong with $sql<br>\n".$dblink->error );
$tmp=$result->fetch_array(MYSQLI_ASSOC);
$sql="SELECT `auto_id` from `equipment_prod` where `type`='$tmp[auto_id]'";
$result=$dblink->query($sql) or
	die( "Something went wrong with $sql<br>\n".$dblink->error );
$count=$result->num_rows;
$time_end=microtime(true);
$seconds=$time_end-$time_start;
$execution_time=($seconds)/60;
echo"<p>NUMBER OF ROWS FOR TYPE NAME: $tmp[auto_id]: $count</p>";
echo"<p>$seconds seconds</p>"
?>