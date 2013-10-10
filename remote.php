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

require("config.php");
require("functions.php");


/*
	Setup Vars and Connection
*/
if($ftpCrypt) parse_str(ftpdecrypt($varCyptKey, $ftpCrypt));
if($connMake) {
        if($connAnon == "on") {
                $connUser = "ftp";
                $connPass = "RooFToP@thedreaming.com";
        } else {
                $connAnon = 0;
        }
        if(!$connPort) $connPort = 21;
        if(!$connPasv) $connPasv = 0; 	
	$fp = ftpObject(trim($connUser), trim($connPass), trim($connServer), trim($connPort), trim($connAnon), trim($connPasv));

}
/*
        Download FIle to Client
*/

if($action == "download") {
	@ftp_get($fp, "$localDir/$clientFile.tmp", "$connDir/$clientFile", FTP_BINARY);
	$fsize = filesize("$localDir/$clientFile.tmp");
        $fp2 = @fopen("$localDir/$clientFile", "r");
                if($fp2) {
                        header("Content-type: application/octetstream");
                        Header("Content-Length: ".$fsize);
                        header("Content-disposition: filename=".$clientFile."[1]"); 
                        header("Pragma: no-cache");
                        header("Expires: 0");
                        fpassthru($fp2);
                        flush();
                } else {
			print("<script language=javascript>");
			print("alert('Unable to Download file please try again');");
			print("history.back(1)");
			print("</script>");
		}
		
} else {
?>
<html>
        <head>
                <title>RuFToP - PHP FTP Client (Remote)</title>
                <LINK REL=stylesheet HREF="<?php print($scriptCSS); ?>" TYPE="text/css">
        </head>
<body>
<form action=remote.php method="post" name="remote">
<?php

if($connMake) {
	if($fp > 0) {
        print("<center><table width=100%><tr><td>");
		/*
			Download Files
		*/
		if($localDir) {
			if(@ftp_get($fp, "$localDir/$filemod", "$connDir/$filemod", FTP_BINARY)) {
				print("<font size=-1>Downloaded file <b>$filemod</b>.</font>");
                                print("<script language=javascript>");
                                print("top.frames['local'].document.local.submit();");
                                print("</script>");
			} else {
				print("<font size=-1 color=red>Unabled to download file <b>$filemod</b>.</font>");
			}
		}

		/*
        		Delete Files and directories Actions
		*/
		if($DeleteConfirm && $DeleteFile) {
		        @ftp_chdir($fp, $dir);
			$dir = ftp_pwd($fp);	
        		if(@ftp_delete($fp, "$dir/$DeleteFile")) {
        		        print("<font size=-1>File <b>$DeleteFile</b> deleted.</font>");
       			 } else {
        		        print("<font color=red size=-1>Unable to delete file <b>$DeleteFile</b></font>");
       			 }
		} else if($DeleteConfirm && $DeleteDir) {
                        @ftp_chdir($fp, $dir);
                        $dir = ftp_pwd($fp);
        		if(@ftp_rmdir($fp, "$dir/$DeleteDir")) {
                		print("<font size=-1>Directory <b>$DeleteDir</b> deleted.</font>");
        		} else {
                		print("<font color=red size=-1>Unable to delete directory <b>$DeleteDir</b></font>");
        		}
		}

		/*
        		Delete Files and directories prompt
		*/
		if($Delete && $filemod) {
		        print("<font size=-1>Delete file <b>$filemod</b>?<input type=\"submit\" name=\"DeleteConfirm\" value=\"Yes\" id=\"inputbutton\"></font>");
		        print("<input type=\"hidden\" name=\"DeleteFile\" value=\"$filemod\"><br>");
		} else if($Delete && $dirmod) {
        		print("<font size=-1>Delete directory <b>$dirmod</b>?<input type=\"submit\" name=\"DeleteConfirm\" value=\"Yes\" id=\"inputbutton\"></font>");
		        print("<input type=\"hidden\" name=\"DeleteDir\" value=\"$dirmod\"><br>");
		}

		/*
        		Rename Files and directories Actions
		*/
		if($RenameConfirm && $RenameFile && $RenameFileNew) {
		        $pathdir = ftp_pwd($fp);
		        if(@ftp_rename($fp, "$pathdir/$RenameFile", "$pathdir/$RenameFileNew")) {
        		        print("<font size=-1>Renamed <b>$RenameFile</b> to <b>$RenameFileNew</b>.</font>");
       			 } else {
                		print("<font color=red>Unable to rename <b>$RenameFile</b></font>");
        		}
		} else if($RenameConfirm && $RenameDir && $RenameDirNew) {
        		$pathdir = ftp_pwd($fp);
        		if(@ftp_rename($fp, "$pathdir/$RenameDir", "$pathdir/$RenameDirNew")) {
                		print("<font size=-1>Directory <b>$RenameDir</b> renamed to <b>$RenameDirNew</b>.</font>");
        		} else {
               			 print("<font color=red size=-1>Unable to rename directory <b>$DeleteDir</b></font>");
        		} 
		}
         
		/*
		        Rename Files and directories prompt
		*/
		if($Rename && $filemod) {
        		print("<font size=-1>Rename file <b>$filemod</b> to <input type=text name=\"RenameFileNew\" value=\"$filemod\"></font>");
        		print("<input type=\"submit\" name=\"RenameConfirm\" value=\"Yes\" id=\"inputbutton\">");
        		print("<input type=\"hidden\" name=\"RenameFile\" value=\"$filemod\"><br>");
		} else if($Rename && $dirmod) {
        		print("<font size=-1>Rename directory <b>$dirmod</b> to <input type=text name=\"RenameDirNew\" value=\"$dirmod\"></font>");
        		print("<input type=\"submit\" name=\"RenameConfirm\" value=\"Yes\" id=\"inputbutton\">");
        		print("<input type=\"hidden\" name=\"RenameDir\" value=\"$dirmod\"><br>");
		}
	print("</td></tr></table></center>");

?>
<table width=100%><tr><td>
<font size=-1>Remote Directory:</font><input type=text name=dir value="<?php print($dir); ?>">
</td><td>
<input type=submit name="Change" value="Change" id="inputbutton">
</td></tr></table>
<?php
	        print(dirHeader());
        	print(dirTable());
        	print(dirGatherRemote($dir));
        	print(dirTable());
        	print(dirFooter());
?>
<input type="hidden" name="connUser" value="<?php print($connUser); ?>">
<input type="hidden" name="connPass" value="<?php print($connPass); ?>">
<input type="hidden" name="connServer" value="<?php print($connServer); ?>">
<input type="hidden" name="connPort" value="<?php print($connPort); ?>">
<input type="hidden" name="connAnon" value="<?php print($connAnon); ?>">
<input type="hidden" name="connPasv" value="<?php print($connPasv); ?>">
<input type="hidden" name="connMake" value="<?php print($connMake); ?>">
<input type="hidden" name="connDir" value="<?php print(ftp_pwd($fp)); ?>">
<input type="hidden" name="clientFile" value=""> 
<input type="hidden" name="localDir" value="">
<input type="hidden" name="action" value="">
<input type="hidden" name="downFile" value="0">
<input type="hidden" name="connected" value="1"> 
<?php
	@ftp_quit($fp);
	}
} else { ?>
Please establish FTP connetion.. 
<input type="hidden" name="connected" value="0">
<?php } ?>
</form>
</body>
</html>
<?php } ?>
