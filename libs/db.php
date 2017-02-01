<?php
function DBConnect($DBHost, $DBUser, $DBPass, $DBName)
{
if(isset($dbh))
{
 return $dbh;
}
	# Соединяемся, выбираем базу данных
        $dbh = mysql_connect("$DBHost","$DBUser","$DBPass")
		or MsgDie("Could not connect: " . mysql_error());
	mysql_select_db("$DBName")
		or MsgDie("Could not select DB: " . mysql_error());
	return $dbh;
}
function mQuery($query)
{
    global $dbh;

//echo"$query<br>";
    if ($result = mysql_query($query, $dbh))
    {

        return $result;
    }
    else
    {
/*
    echo"$query<br>";
        $error = mysql_error();
        MsgDie("MySQL error logged: " . $error);
*/        
    }
}
function MsgDie ($msg)
{
    die("<br><font color=red>$msg</font><br>\n");
}
?>
