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
$sql="SELECT * from `type`";
$result=$dblink->query($sql) or
	die( "Something went wrong with $sql<br>\n".$dblink->error );
while ($item=$result->fetch_array(MYSQLI_ASSOC)) 
{
  $sql="SELECT * FROM `equipment_prod` where `type`='$item[name]'";
  $rst=$dblink->query($sql) or
  		die( "Something went wrong with $sql<br>\n".$dblink->error );
  while($data=$rst->fetch_array(MYSQLI_ASSOC))
  {
	  echo"<p>ABOUT TO UPDATE $data[auto_id] with new type:$item[name] from $data[type]</p>";
	  $sql="Update `equipment_prod` set `type`='$item[auto_id]' where `auto_id`='$data[auto_id]'";
	  $dblink->query($sql) or
		  die("Something went wrong with: $sql<br>".$dblink->error);
  }
}
echo "<p>Done</P>";
?>