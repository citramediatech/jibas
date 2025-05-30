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
function ValidateInputNotesLogin($dept, $login, $password, &$type, &$info)
{
    $sql = "SELECT COUNT(replid)
              FROM jbsakad.siswa
             WHERE nis = '$login'
               AND aktif = 1
               AND alumni = 0";
    $ndata = (int)FetchSingleEx($sql);

    if ($ndata == 0)
    {
        $sql = "SELECT COUNT(replid)
                  FROM jbssdm.pegawai
                 WHERE nip = '$login'
                   AND aktif = 1";
        $ndata = (int)FetchSingleEx($sql);
        
        if ($ndata == 0)
        {
            $info = "Tidak ditemukan siswa/pegawai dengan nomor $login!";
            return false;    
        }
        else
        {
            $type = "P";
        }
    }
    else
    {
        $type = "S";
    }
    
    if ($type == "S")
    {
        $sql = "SELECT a.departemen
                  FROM jbsakad.siswa s, jbsakad.angkatan a
                 WHERE s.idangkatan = a.replid
                   AND s.nis = '$login'";
        $res = QueryDb($sql);
        if (mysqli_num_rows($res) > 0)
        {
            $row = mysqli_fetch_row($res);
            $d = $row[0];
            
            if ($d != $dept)
            {
                $info = "Anda tidak memiliki hak akses di departemen $dept!";
                return false;
            }
        }
        else
        {
            $info = "Tidak ditemukan data departemen!";
            return false;
        }
    }
    
    if ($type == "S")
    {
        $sql = "SELECT COUNT(replid)
                  FROM jbsakad.siswa
                 WHERE nis = '$login'
                   AND pinsiswa = '$password'";
    }
    else
    {
        $sql = "SELECT COUNT(replid)
                  FROM jbsuser.login
                 WHERE login = '$login'
                   AND password = md5('$password')";
    }
    
    $ndata = (int)FetchSingleEx($sql);
    if ($ndata == 0)
    {
        $info = "Password salah!";
        return false;
    }
    
    return true;
}
?>