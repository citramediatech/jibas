<?
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 32.0 (Feb 05, 2025)
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
session_name("jbsakad");
session_start();

$SI_USER_LANDLORD = 0;
$SI_USER_MANAGER = 1;
$SI_USER_STAFF = 2;
$STAFF_DEPT = $_SESSION['departemen'];

function SI_USER_NAME()
{
	return $_SESSION['namasimaka'];
}

function SI_USER_ID()
{
	return $_SESSION['login'];
}

function SI_USER_THEME()
{
	return $_SESSION['temasimaka'];
}

function SI_USER_LEVEL()
{
	switch ($_SESSION['tingkatsimaka']){
	case 0:
		{
	global $SI_USER_LANDLORD;
	return $SI_USER_LANDLORD;
	break;
		}
		case 1:
		{
	global $SI_USER_MANAGER;
	return $SI_USER_MANAGER;
	break;
		}
		case 2:
		{
	global $SI_USER_STAFF;
	return $SI_USER_STAFF;
	break;
		}
	}
}

function SI_USER_ACCESS() {
	if ($_SESSION['tingkatsimaka']==3){
		return '';
	} else if ($_SESSION['tingkatsimaka']==2){
		return $_SESSION['departemensimaka'];
		
	} else {
		return "ALL";
	}
}
?>