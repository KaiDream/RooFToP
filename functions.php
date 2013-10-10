<?php
/*
 * RuFToP - Remote FTP Client
 * Copyright (C) 2001 Ray Lopez (http://www.TheDreaming.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/*
	Random Keys for Cyrpt
*/
$ralphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=./-";
$alphabet = $ralphabet . $ralphabet;

function ftpencrypt ($password,$strtoencrypt) {
                global $ralphabet;
                global $alphabet;

                for( $i=0; $i<strlen($password); $i++ ) {
                        $cur_pswd_ltr = substr($password,$i,1);
                        $pos_alpha_ary[] = substr(strstr($alphabet,$cur_pswd_ltr),0,strlen($ralphabet));
                }
                $i=0;
                $n = 0;
                $nn = strlen($password);
                $c = strlen($strtoencrypt);
                 while($i<$c) {
		   if(substr($strtoencrypt,$i,1) == "&") {
			   $encrypted_string .= "$";
		   } else {
	                   $encrypted_string .= substr($pos_alpha_ary[$n],strpos($ralphabet,substr($strtoencrypt,$i,1)),1);
		   }
                   $n++;
                   if($n==$nn) $n = 0;
                $i++;
                }
        return $encrypted_string;
        }

function ftpdecrypt ($password,$strtodecrypt) {
                global $ralphabet;
                global $alphabet;

                for( $i=0; $i<strlen($password); $i++ ) {
                        $cur_pswd_ltr = substr($password,$i,1);
                        $pos_alpha_ary[] = substr(strstr($alphabet,$cur_pswd_ltr),0,strlen($ralphabet));
                }
                $i=0;
                $n = 0;
                $nn = strlen($password);
                $c = strlen($strtodecrypt);
                while($i<$c) {
                   if(substr($strtodecrypt,$i,1) == "$") {
                           $decrypted_string .= "&";
                   } else {
                        $decrypted_string .= substr($ralphabet,strpos($pos_alpha_ary[$n],substr($strtodecrypt,$i,1)),1);
		  }
                        $n++;
                        if($n==$nn) $n = 0;
                        $i++;
                }
        return $decrypted_string;
}

function dirHeader() {
        $content  = "<table width=100% nowrap>";
        return $content;
}
 
function dirTable() {
        $content = "<tr><td>Type</td><td width=50%>Name</td><td>Size</td><td>Modified</td></tr>";
        return $content;
}
 

function dirFooter() {
        $content  = "</table>";
        return $content;
}

function fType($file) {
        $varFileType = filetype($file);
        if($varFileType != "dir") {
                $curdir = getcwd();
                $pInfo = pathinfo("$curdir/$file");
                $varFileType = $pInfo["extension"];
        }
        return $varFileType;
}
 
function analysedir($dirline)  { 
	// Array -> 0 = Switch (0=Total, 1=Directory, 2 File)
	// Array -> 1 = FileSize
	// Array -> 2 = FileDate
	// Array -> 3 = FileName

	global $fp;
	$systype = ftp_systype($fp); // System Type
        if( (substr($dirline,0,1) == "d") || (substr($dirline,0,1) == "l") || (substr($dirline,0,1) == "-") ) {
		$systype = "UNIX";
        } else {
		$systype = ftp_systype($fp);
	}
	if($systype == "UNIX") {
		if(substr($dirline,0,5) == "total") {
			$arrList[] = 0;
		} else if(substr($dirline,0,1) == "d") {
			$arrList[] = 1;
		} else if(substr($dirline,0,1) == "l") {
			$arrList[] = 1;
			$symlink = 1;
		} else if(substr($dirline,0,1) == "-") {
			$arrList[] = 2;
		}
		// Directory Settings
		$newDir = split(" ", $dirline,2);
		$dirSettings = trim($newDir[0]);
		$dirline = trim($newDir[1]);
		
		// Directtory Number
		$newDir = split(" ", $dirline,2);
                $dirNumber = trim($newDir[0]);
                $dirline = trim($newDir[1]);		

		// Directory User
		$newDir = split(" ", $dirline,2);
                $dirUser = trim($newDir[0]);  
                $dirline = trim($newDir[1]);

		// Directory Group
                $newDir = split(" ", $dirline,2);
                $dirGroup = trim($newDir[0]);  
                $dirline = trim($newDir[1]);

		
		// Directory File Size
                $newDir = split(" ", $dirline,2);
                $dirSize = trim($newDir[0]);
                $dirline = trim($newDir[1]);


                // Directory Month
                $newDir = split(" ", $dirline,2);
                $dirMonth = trim($newDir[0]);  
                $dirline = trim($newDir[1]);

                // Directory Day
                $newDir = split(" ", $dirline,2);
                $dirDay = trim($newDir[0]);
                $dirline = trim($newDir[1]);

                // Directory YearTime
                $newDir = split(" ", $dirline,2);
                $dirYearTime = trim($newDir[0]);
                $dirline = trim($newDir[1]);

                // Directory File Name
		$dirFileName = $dirline;

		$arrList[] = $dirSize;
                $arrList[] = "$dirMonth $dirDay $dirYearTime"; 
		if($symlink) {
			$n = sscanf($dirFileName, "%s -> %s", &$linkname, &$linkdest);
			$arrList[] = $linkname;
		} else {
	                $arrList[] = $dirFileName;
		}
	} else if($systype == "Windows_NT") {	
		// Directory Date
		$newDir = split(" ", $dirline,2);
                $dirDate = trim($newDir[0]);
                $dirline = trim($newDir[1]);
		
                // Directory Time
                $newDir = split(" ", $dirline,2);
                $dirTime = trim($newDir[0]);    
                $dirline = trim($newDir[1]);

                // Directory Size
                $newDir = split(" ", $dirline,2);
                $dirSize = trim($newDir[0]);
                $dirline = trim($newDir[1]);

                // Directory Name
		$dirName = $dirline;
		
		if($dirSize > 0) {
			$arrList[] = 2;
		} else {
			$arrList[] = 1; 
		}

                $arrList[] = $dirSize;
                $arrList[] = "$dirDate $dirTime";
                $arrList[] = $dirName;		

	} 
return $arrList; 

} 


function display_size($file_size){
    if($file_size >= 1073741824) {
        $file_size = round($file_size / 1073741824 * 100) / 100 . "g";
    } elseif($file_size >= 1048576) {
        $file_size = round($file_size / 1048576 * 100) / 100 . "m";
    } elseif($file_size >= 1024) {
        $file_size = round($file_size / 1024 * 100) / 100 . "k";
    } else {
        $file_size = $file_size . "b";
    }
    return $file_size;
}
        
function dirGatherLocal($directory = "") {
	if($directory) {
		if(!@chdir($directory)) {
			print("<font color=red>Unable to change to Directory</font>");
		}
	}
	$directory = getcwd();
	$handle=opendir($directory);
	$directory = getcwd();
        $content = "";
        while (($file = readdir($handle)) != false) {
                        $lastchanged = filectime($file);
                        $changeddate = date("d-m-Y H:i:s", $lastchanged);
                        $filesize = display_size(filesize($file));
                        $filetype = strtolower(trim(fType($file)));
			$filedirection = "";
			if($filetype != "dir") {
				$filedirection = "local.php?dir=$directory&file=$file&action=download&from=local";
				$filecontent .= "<tr><td>file</td>";
	                        $filecontent .= "<td><input type=radio name=\"filemod\" value=\"$file\" onClick=\"connFile.value=1\";>"; 
				$filecontent .= "<a href=\"$filedirection\">$file</a></td>";
        	                $filecontent .= "<td>$filesize</td>";
                	        $filecontent .= "<td>$changeddate</td></tr>";
			} else {
				$filedirection = "local.php?dir=$directory/$file/";
				$content .= "<tr><td>$filetype</td>";
				$content .= "<td>";
				if($file == ".") { 
					$filedirection = "local.php?dir=$directory";
				} else if($file == ".."){
					$filedirection = "local.php?dir=$directory/..";
				} else {
		                        $content .= "<input type=radio name=\"dirmod\" value=\"$file\">";
				}
				$content .= "<a href=\"$filedirection\">$file</a></td>";
        	                $content .= "<td>$filesize</td>";
                	        $content .= "<td>$changeddate</td></tr>";				
			} 
        }
	$content .= $filecontent;
        return $content;
}

function genRemoteURL($addURL) {
	global $fp ,$connUser, $connPass, $connServer, $connPort, $connAnon, $connPasv, $crypto, $varCyptKey;
	$connURL = ftpencrypt($varCyptKey,"connMake=connMake&connUser=$connUser&connPass=$connPass&connServer=$connServer&connPort=$connPort&connAnon=$connAnon&connPasv=$connPasv$addURL");
	return $connURL;
}

function dirGatherRemote($directory = "") {
	global $fp;
        if($directory) {
                if(!@ftp_chdir($fp, $directory)) {
                        print("<font color=red>Unable to change to Directory</font>");
                }
        }
        $directory = ftp_pwd($fp);
	$dirlist =  ftp_rawlist($fp, $directory);
		// print("<tr><td colspan4>".ftp_systype($fp)."</td></tr>"); 
		$connURL = genRemoteURL("&dir=$directory");
                $content .= "<tR><td>dir</td>";
                $content .= "<td><A href=\"remote.php?ftpCrypt=$connURL\">.</a></td>";
                $content .= "<td>&nbsp;</td>";
                $content .= "<td>&nbsp;</td></tr>";
		$connURL = genRemoteURL("&dir=$directory/..");
                $content .= "<tR><td>dir</td>";
                $content .= "<td><a href=\"remote.php?ftpCrypt=$connURL\">..</a></td>";
                $content .= "<td>&nbsp;</td>";
                $content .= "<td>&nbsp;</td></tr>";
	for($i=0; $i<count($dirlist); $i++) {

		$dirItem = analysedir($dirlist[$i]);
		if($dirItem[0] == 0) {
                        $endcontent .= "<tr><td>total</td>";     
                        $endcontent .= "<td>$dirItem[3]</td>";
                        $endcontent .= "<td>$dirItem[1]</td>";
                        $endcontent .= "<td>$dirItem[2]</td></tr>";
		} else if($dirItem[0] == 1) {
			$connURL = genRemoteURL("&dir=$directory/$dirItem[3]");
	                $content .= "<tr><td>dir</td>"; 
        	        $content .= "<td><input type=radio name=\"dirmod\" value=\"$dirItem[3]\">";
			$content .= "<a href=\"remote.php?ftpCrypt=$connURL\">$dirItem[3]</a></td>";     
                	$content .= "<td>".display_size($dirItem[1])."</td>";     
                	$content .= "<td>$dirItem[2]</td></tr>";	
		} else if($dirItem[0] == 2) {
			$connURL = genRemoteURL("&dir=$directory&file=$dirItem[3]&from=remote"); 
	                $filecontent .= "<tr><td>file</td>"; 
        	        $filecontent .= "<td><input type=radio name=\"filemod\" value=\"$dirItem[3]\" onClick=\"downFile.value=1\">";
                        $filecontent .= "<a href=\"javascript:top.clientDownloadFile('$dirItem[3]');\">$dirItem[3]</a></td>";     
                	$filecontent .= "<td>".display_size($dirItem[1])."</td>";     
                	$filecontent .= "<td>$dirItem[2]</td></tr>";	 
		}

	
	}
	$content .= $filecontent;
	$content .= $endcontent;
        return $content;
} 

function diskStats($scriptStats) {
        if($scriptStats) {
//              $diskTotal = display_size(disk_total_space("/"));
                $diskFree  = display_size(diskfreespace("/"));
                $content  = "<table width=100%>";
                $content .= "<tr><td width=150>Free Disk Space:</td><td>$diskFree</td></tr>";
//              $content .= "<tr><td width=150>Total Disk Space:</td><td>$diskFree</td></tr>";
                $content .= "</table>";
                print($content);
        }


}


function ftpObject($user, $pass, $host, $port = "21", $anon, $pasv) {
	if(!$host) $ftpError .= "Please Sepcify a Host<br>";
	if(!$anon) { 
		if(!$user) $ftpError .= "Please Sepcify a UserName<br>";
		if(!$pass) $ftpError .= "Please Sepcify a Password<br>"; 
	} else {
		$user = "ftp";
		$pass = "RuFToP@thedreaming.com";
	}
	if((!$fp = ftp_connect($host, $port)) && !$ftpError) $ftpError = "Unable to connect to host.<br>";
	if($pasv && (!$pasvcheck = ftp_pasv($fp, $pasv)) && !$ftpError) $ftpError = "Unable to switch to PASV mode.<br>";
	if(($logintest = !@ftp_login($fp, $user, $pass)) && !$ftpError) $ftpError = "Unable to login, bad username or password.<br>";


	if(!$ftpError) {
		return $fp;
	} else {
		print("<font color=red>$ftpError</font>");
		return 0;
	}
}

?>
