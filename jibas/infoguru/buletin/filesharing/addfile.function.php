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
if (isset($_REQUEST['iddir']))
	$iddir = $_REQUEST['iddir'];
	
OpenDb();
$sql = "SELECT dirfullpath FROM jbsvcr.dirshare WHERE idroot = 0";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$rootname = $row[0];

$sql = "SELECT * FROM jbsvcr.dirshare WHERE replid = '$iddir'";
$result = QueryDb($sql);
$row = @mysqli_fetch_array($result);
$dirfullpath = $row['dirfullpath'];
CloseDb();

$fullpath = str_replace($rootname, "", $dirfullpath);
$cek = 0;
$ERROR_MSG = "";

if (isset($_REQUEST['Simpan']))
{
    $dir = $_REQUEST['dir']; 
    $iddir = $_REQUEST['iddir'];
	
    $FileShareDir = "$FILESHARE_UPLOAD_DIR/fileshare/";
    $destinationdir = str_replace($rootname, $FileShareDir, $dir);
	
    OpenDb();
    
    $success = true;
    BeginTrans();
    
    for($i = 1; $success && $i <= 7; $i++)
    {
        $file = $_FILES["file$i"];
		
        $uploadedsizefile = (int)$file['size'];
        if ($uploadedsizefile == 0)
            continue;
        
        $filename = $file['name'];
        SecurePhpExtension($filename);
		
        $newfile = true;
        $targetfile = $destinationdir . $filename;
        if (file_exists($targetfile))
        {
            unlink($targetfile);
            $newfile = false;
        }
				
        $uploadedfile = $file['tmp_name'];
        move_uploaded_file($uploadedfile, $targetfile);
		
        if ($newfile)
        {
           $sql = "INSERT INTO jbsvcr.fileshare
                      SET iddir='$iddir',
                          filename='$filename',
                          filetime=NOW(),
                          filesize='$uploadedsizefile'";
        }
        else
        {
           $sql = "UPDATE jbsvcr.fileshare
                      SET filetime=NOW(),
                          filesize='$uploadedsizefile'
                    WHERE iddir='$iddir' 
                      AND filename='$filename'";
        }
        QueryDbTrans($sql, $success);
    }
   
    if ($success)
    {
        CommitTrans();
        CloseDb();
        ShowMessageClose("Berhasil");
    }
    else
    {
        RollbackTrans();
        CloseDb();
        ShowMessageClose("Gagal mengunggah data!");
    }
}    

// FUNCTIONS DEFINITION =========================================

function SecurePhpExtension(&$filename)
{
    $lastpos = -1; $startpos = 0;
    $pos = strpos($filename, ".", $startpos);
    while($pos !== FALSE)
    {
        $lastpos = $pos;
        
        $startpos = $pos + 1;
        $pos = strpos($filename, ".", $startpos);
    }
    
    if ($lastpos != -1)
    {
        $ext = strtolower(trim(substr($filename, $lastpos)));
        if ($ext == ".php")
            $filename = $filename . ".txt";
    }
}

function ShowMessageClose($message)
{ ?>
    <script language="javascript">
        alert('<?=$message?>');
        
        opener.get_fresh();
        window.close();
    </script>
<?    
}
?>
