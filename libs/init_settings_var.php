<?php   
    $res = mQuery("SELECT name,value FROM settings");
    while($row = mysql_fetch_row($res)){
        $$row[0] = $row[1];
        $GLOBALS[$row[0]] =  $row[1]; 
        //echo "$row[0] = ".$$row[0]."<br>";
    }
?>