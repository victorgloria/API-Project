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
$fp = fopen( "/var/www/html/equipment.txt", "r" );
$count = 0;
$time_start = microtime( true );
echo "<p>Start time is: $time_start</p>\n";
$sql="Set autocommit=0";
$dblink->query( $sql ) or
  die( "Something went wrong with $sql<br>\n".$dblink->error );
while ( ( $row = fgetcsv( $fp ) ) !== FALSE ) {
  $sql = "Insert into `equipment2` (`type`,`manufacture`,`serialNum`) values ('$row[0]','$row[1]','$row[2]')";
  $dblink->query( $sql ) or
  die( "Something went wrong with $sql<br>\n".$dblink->error );
  $count++;
}
$sql="Commit";
$dblink->query( $sql ) or
  die( "Something went wrong with $sql<br>\n".$dblink->error );
$time_end = microtime( true );
echo "<p>End Time: $time_end</p>\n";
$seconds = $time_end - $time_start;
$execution_time = ( $seconds ) / 60;
echo "<p>Execution time: $execution_time minutes or $seconds seconds</p>\n";
$rowsPerSecond = $count / $seconds;
echo "<p>Insert rate $rowsPerSecond per second</p>\n";
fclose( $fp );
?>