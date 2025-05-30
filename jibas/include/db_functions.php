<?
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 23.0 (November 12, 2020)
 * @notes: 
 * 
 * Copyright (C) 2024 JIBAS (http://www.jibas.net)
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 **[N]**/ ?>
<?
$mysqlconnection = NULL;

$mysqlclosed = false;

//Buka koneksi ke Database
function OpenDb() 
{
	global $db_host, $db_user, $db_pass, $db_name, $mysqlconnection;

	$mysqlconnection = @mysqli_connect($db_host, $db_user, $db_pass) or trigger_error("Can not connect to database server", E_USER_ERROR);
	$select = @mysqli_select_db($mysqlconnection, $db_name) or trigger_error("Can not open the database", E_USER_ERROR);
	
	return $mysqlconnection;
}	

function OpenDbi() 
{
	global $db_host, $db_user, $db_pass, $db_name, $conni;

	$conni = @mysqli_connect($db_host, $db_user, $db_pass) or trigger_error("Can not connect to database server", E_USER_ERROR);
	$select = @mysqli_select_db($conni, $db_name) or trigger_error("Can not open the database", E_USER_ERROR);
	
	return $conni;
}

 //Buat query
function QueryDbi($sql) 
{
    global $mysqlconnection;

	$result = mysqli_query($mysqlconnection, $sql) or trigger_error("Failed to execute sql query: $sql", E_USER_ERROR);
	
	return $result;
}

//Tutup koneksi
function CloseDb() 
{
	global $mysqlconnection;
	global $mysqlclosed;

	if ($mysqlconnection == null)
	    return;

	if ($mysqlclosed)
	    return;

	@mysqli_close($mysqlconnection);

	$mysqlclosed = true;
}

//Buat query
function QueryDb($sql) 
{
	global $mysqlconnection;
	
	$result = mysqli_query($mysqlconnection, $sql) or trigger_error("<br>&nbsp;&nbsp;Failed to execute sql query: <br>&nbsp;&nbsp;$sql", E_USER_ERROR);
	
	return $result;
}

function QueryDbTrans($sql, &$success) 
{
	global $mysqlconnection;
	
	$result = @mysqli_query($mysqlconnection, $sql);
	$success = ($result && 1); //&& (mysqli_affected_rows($mysqlconnection) > 0));
	
	return $result;
}

function OpenDbEx()
{
    global $db_host, $db_user, $db_pass, $db_name, $mysqlconnection;

    $mysqlconnection = @mysqli_connect($db_host, $db_user, $db_pass);
    if (mysqli_errno($mysqlconnection) > 0)
        throw new Exception(mysqli_error($mysqlconnection), mysqli_errno($mysqlconnection));

    $select = @mysqli_select_db($mysqlconnection, $db_name);
    if (mysqli_errno($mysqlconnection) > 0)
        throw new Exception(mysqli_error($mysqlconnection), mysqli_errno($mysqlconnection));

    return $mysqlconnection;
}

function QueryDbEx($sql)
{
    global $mysqlconnection;

    $result = @mysqli_query($mysqlconnection, $sql);
    if (mysqli_errno($mysqlconnection) > 0)
         throw new Exception(mysqli_error($mysqlconnection), mysqli_errno($mysqlconnection));

    return $result;
}

function BeginTrans() 
{
	global $mysqlconnection;
	
	@mysqli_query($mysqlconnection, "SET AUTOCOMMIT=0");
	@mysqli_query($mysqlconnection, "BEGIN");
}

function CommitTrans() 
{
	global $mysqlconnection;
	
	@mysqli_query($mysqlconnection,"COMMIT");
	@mysqli_query($mysqlconnection,"SET AUTOCOMMIT=1");
}

function RollbackTrans() 
{
	global $mysqlconnection;
	
	@mysqli_query($mysqlconnection,"ROLLBACK");
	@mysqli_query($mysqlconnection,"SET AUTOCOMMIT=1");
}

function GetValue($tablename, $column, $where) 
{
	$sql = "SELECT $column FROM $tablename WHERE $where";
	$result_get_value = QueryDb($sql);
	$row_get_value = mysqli_fetch_row($result_get_value);
	
	return $row_get_value[0];
}
?>