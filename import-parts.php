<?php
$files=array('equip.txt'); //USE WHATEVER FILES YOU CREATED IN THE FILE SPLIT
foreach($files as $key=>$value)
{
    shell_exec("/usr/bin/php /var/www/html/import-arg.php $key $value > /var/www/html/$value.log 2>/var/www/html/$value.log &");
}
echo "Main Process Done\n";
?>