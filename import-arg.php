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
echo "Hello from php process $argv[1] about to process file:$argv[2]\n";
$dblink=db_iconnect("ase");
$fp=fopen("/var/www/html/$argv[2]","r");
$count=0;
$time_start=microtime(true); 
echo "PHP ID:$argv[1]-Start time is: $time_start\n";
while (($row=fgetcsv($fp)) !== FALSE) 
{
    $sql="Insert into `equipment3` (`type`,`manufacture`,`serialNum`) values ('$row[0]','$row[1]','$row[2]')";
    $dblink->query($sql) or
        die("Something went wrong with $sql<br>\n".$dblink->error);
    $count++;
}
$time_end=microtime(true);
echo "PHP ID:$argv[1]-End Time:$time_end\n";
$seconds=$time_end-$time_start;
$execution_time=($seconds)/60;
echo "PHP ID:$argv[1]-Execution time: $execution_time minutes or $seconds seconds.\n";
$rowsPerSecond=$count/$seconds;
echo "PHP ID:$argv[1]-Insert rate: $rowsPerSecond per second\n";
fclose($fp);
?>