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
class DaftarPensiun
{
    public $nip;
    public $nama;
    
    public function __construct()
    {
        $this->nip = $_REQUEST['nip'];

        $sql = "SELECT TRIM(CONCAT(IFNULL(gelarawal,''), ' ' , nama, ' ', IFNULL(gelarakhir,''))) AS nama FROM pegawai WHERE nip='$this->nip'";
        $result = QueryDb($sql);
        $row = mysqli_fetch_row($result);
        $this->nama = $row[0];
        
        $op = $_REQUEST['op'];
        if ($op == "1dn09387120n89x713891203712089312") 
        {
            $id = $_REQUEST['id'];
            $sql = "DELETE FROM jadwal WHERE replid=$id";
            QueryDb($sql);
        } 
    }
}
?>