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
<?php
require_once("include/config.php");
require_once("../include/cbe.config.php");
require_once("include/session.php");
require_once("include/db_functions.php");
require_once("library/genericreturn.php");
require_once("library/httprequest.php");
require_once("library/httpmanager.php");
require_once("library/cbe.state.php");
require_once("library/cbe.system.php");
require_once("library/cbe.session.php");
require_once("library/cbe.protocol.php");
require_once("library/debugger.php");
require_once("library/requestpilihandata.php");
require_once("library/requestdaftardata.php");
require_once("library/startujiandata.php");
require_once("library/ujiandatatag.php");
require_once("common.func.php");

function getDaftarPelajaran($viewDaftarUjian)
{
    try
    {
        $jsonSession = $_SESSION["Json"];

        $pilihan = new RequestPilihanData();
        $pilihan->ViewDaftarUjian = $viewDaftarUjian;
        $jsonPilihan = $pilihan->toJson();

        $http = new HttpManager();
        $http->setData("pelajaran", CbeState::PilihanUjianKhusus, "0", $jsonSession, $jsonPilihan);
        $result = $http->send();

        if ((int) $result->Code < 0)
            return sendConnectError($result->Message); // Tidak dapat koneksi ke CBE Server

        $jsonData = $result->Data;
        $protocol = CbeDataProtocol::fromJson($jsonData);

        if ((int) $protocol->Status < 0)
            return sendCbeServerError($protocol->Data); // CBE Server Application send Error

        $jsonPelajaran = trim($protocol->Data);
        if (strlen($jsonPelajaran) == 0)
        {
            $arr["0"] = "(tidak ada pelajaran)";
            $jsonPelajaran = json_encode($arr);
        }

        $select = createSelectPelajaran($jsonPelajaran);

        return GenericReturn::createJson(1, "OK", $select);
    }
    catch (Exception $ex)
    {
        return GenericReturn::createJson(-99, $ex->getMessage(), "");
    }
}

function createSelectPelajaran($jsonPelajaran)
{
    $pelInfo = json_decode($jsonPelajaran);

    $select = "<select id='uks_cbPelajaran' class='inputbox' style='width: 220px' onchange='uks_changeCbPelajaran()'>";
    foreach($pelInfo as $key => $value)
    {
        $select .= "<option value='$key'>$value</option>";
    }
    $select .= "</select>";

    return urlencode($select);
}

function getDaftarUjian($viewDaftarUjian, $idPelajaran)
{
    try
    {
        $jsonSession = $_SESSION["Json"];

        $info = new RequestDaftarData();
        $info->ViewDaftarUjian = $viewDaftarUjian;
        $info->IdPelajaran = $idPelajaran;

        $http = new HttpManager();
        $http->setData("daftar", CbeState::DaftarUjianKhusus, "0", $jsonSession, $info->toJson());
        $result = $http->send();

        if ((int) $result->Code < 0)
            return sendConnectError($result->Message); // Tidak dapat koneksi ke CBE Server

        $jsonData = $result->Data;
        $protocol = CbeDataProtocol::fromJson($jsonData);

        $jsonUjian = trim($protocol->Data);
        if (strlen($jsonUjian) == 0)
            return GenericReturn::createJson(1, "Tidak ada data ujian", "Tidak ada data ujian");

        $table = createTableUjian($jsonUjian);

        return GenericReturn::createJson(1, "OK", $table);
    }
    catch (Exception $ex)
    {
        return GenericReturn::createJson(-99, $ex->getMessage(), "");
    }
}

function createTableUjian($jsonUjian)
{
    $ujianArr = json_decode($jsonUjian);

    $table  = "<table border='1' cellpadding='5' cellspacing='0' style='border-width: 1px; border-collapse: collapse; border-color: #0a6aa1;' >";
    $table .= "<tr style='background-color: #0a6aa1; height: 30px; color: white;'>";
    $table .= "<td align='center' valign='middle' width='20'>No</td>";
    $table .= "<td align='center' valign='middle' width='300'>Ujian</td>";
    $table .= "<td align='center' valign='middle' width='200'>Pelajaran/Peserta</td>";
    $table .= "<td align='center' valign='middle' width='250'>Jadwal</td>";
    $table .= "<td align='center' valign='middle' width='100'>&nbsp;</td>";
    $table .= "</tr>";
    for ($i = 0; $i < count($ujianArr); $i++)
    {
        $bgcolor = $i % 2 == 0 ? "#FFF" : "#EBFAFF";
        $no = $i + 1;
        $ujianInfo = $ujianArr[$i];

        $tag = new UjianDataTag();
        $tag->IdUjian = $ujianInfo->IdUjian;
        $tag->IdUjianSerta = $ujianInfo->IdUjianSerta;
        $tag->IdRemedUjian = $ujianInfo->IdRemedUjian;
        $tag->IdJadwalUjian = $ujianInfo->IdJadwalUjian;
        $tag->StatusUjian = $ujianInfo->StatusUjian;
        $tag->JumlahSoal = $ujianInfo->JumlahSoal;
        $tag->Judul = str_replace("\"", "'", $ujianInfo->Judul);

        $jsonTag = $tag->toJson();
        $jsonTag = str_replace("\"", "`", $jsonTag);


        $table .= "<tr style='background-color: $bgcolor'>";
        $table .= "<td align='center' valign='top'>";
        $table .= "<input type=\"hidden\" id=\"tag-$no\" value=\"$jsonTag\">";
        $table .= "$no</td>";
        $table .= "<td align='left' valign='top'>";
        $table .= nlToBr($ujianInfo->UjianInfo) . "<br>";
        $table .= "</td>";
        $table .= "<td align='left' valign='top'>";
        $table .= nlToBr($ujianInfo->Pelajaran) . "<br>";
        $table .= "</td>";
        $table .= "<td align='left' valign='top'>";
        $table .= nlToBr($ujianInfo->JadwalInfo) . "<br>";
        $table .= "</td>";
        $table .= "<td align='center' valign='top'>";
        $table .= "<input type='button' value='Mulai' class='BtnPrimary' name='btMulai' ";
        $table .= "onclick='uks_startUjian($no)'><br>";
        $table .= "<span style='color: blue' id='lbInfo-$no'></span>";
        $table .= "</td>";
        $table .= "</tr>";
    }
    $table .= "</table>";

    return $table;
}

function startUjian($idUjian, $idRemedUjian, $idUjianSerta, $idJadwalUjian)
{
    try
    {
        $jsonSession = $_SESSION["Json"];

        $info = new StartUjianData();
        $info->IdUjian = $idUjian;
        $info->IdRemedUjian = $idRemedUjian;
        $info->IdUjianSerta = $idUjianSerta;
        $info->IdJadwalUjian = $idJadwalUjian;

        $http = new HttpManager();
        $http->setTimeout(30000);
        $http->setData("startujian", CbeState::StartUjian, "0", $jsonSession, $info->toJson());
        $result = $http->send();

        if ((int) $result->Code < 0)
            return sendConnectError($result->Message); // Tidak dapat koneksi ke CBE Server

        $protocol = CbeDataProtocol::fromJson($result->Data);
        if ((int) $protocol->Status < 0)
            return sendCbeServerInfo($protocol->Data);

        $ujianData = json_decode($protocol->Data);
        $_SESSION["UserName"] = $ujianData->Info->UserName;
        $_SESSION["IdUjian"] = $ujianData->Info->IdUjian;
        $_SESSION["IdUjianRemed"] = $ujianData->Info->IdUjianRemed;
        $_SESSION["IdRemedUjian"] = $ujianData->Info->IdRemedUjian;
        $_SESSION["IdUjianSerta"] = $ujianData->Info->IdUjianSerta;
        $_SESSION["IdJadwalUjian"] = $ujianData->Info->IdJadwalUjian;
        $_SESSION["Judul"] = $ujianData->Info->Judul;
        $_SESSION["UjianStarted"] = true;

        $userid = $_SESSION["UserId"];
        $sessionid = $_SESSION["SessionId"];
        $intent = $protocol->Data;
        $intent = str_replace("'", "`", $intent);

        OpenDb();
        $sql = "SELECT COUNT(*) 
                  FROM jbscbe.webuserintent 
                 WHERE userid='$userid' 
                   AND sessionid='$sessionid' 
                   AND type='ujian'";
        $nData = (int) FetchSingle($sql);
        if ($nData == 0)
        {
            $sql = "INSERT INTO jbscbe.webuserintent 
                       SET userid='$userid', 
                           sessionid='$sessionid', 
                           intent='$intent', 
                           type='ujian'";
            QueryDb($sql);
        }
        CloseDb();

        return GenericReturn::createJson(1, "OK", $result->Data);
    }
    catch (Exception $ex)
    {
        return GenericReturn::createJson(-99, $ex->getMessage(), "");
    }
}
?>