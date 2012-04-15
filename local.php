<?
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
if($scriptLocalDrive) $dir = $scriptLocalDrive; 
if($connDir)  @$fp = ftpObject(trim($connUser), trim($connPass), trim($connServer),trim($connPort),trim($connAnon),trim($connPasv));

/*
	Download FIle to Client
*/

if($action == "download") {

                //$handle=opendir($dir);
                //$directory = getcwd();
                $fp = @fopen("$dir/$file", "r");
		if($fp) {
	                header("Content-type: application/octetstream");
        	        Header("Content-Length: ".filesize($file));
        	        header("Content-disposition: filename=".$file."[1]");
        	        header("Pragma: no-cache");
        	        header("Expires: 0");
        	        fpassthru($fp);
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
	<LINK REL=stylesheet HREF="<? print($scriptCSS); ?>" TYPE="text/css">
	</head>
<body>
<form action=local.php?formsub=1 method="post" target="local" name="local">
<?
print("<center><table width=100%><tr><td><center>");
/*
	Upload fle to Remote 

*/
if($connDir)  {
	@chdir($dir);
	$localpathdir = getcwd();
	if(@ftp_put($fp, "$connDir/$filemod", "$localpathdir/$filemod", FTP_BINARY)) {
		print("<font size=-1>File <b>$filemod</b> uploaded.</font>");
                print("<script language=javascript>");
                print("top.frames['remote'].document.remote.submit();");
                print("</script>");
	} else {
		print("<font size=-1 color>Unable to upload <b>$filemod</b>.</font>");
	}
	@ftp_quit($fp);
}

/*
        Delete Files and directories Actions
*/
if($DeleteConfirm && $DeleteFile) {
	@chdir($dir);
	if(@unlink($DeleteFile)) {
		print("<font size=-1>File <b>$DeleteFile</b> deleted.</font>");
	} else {
		print("<font color=red size=-1>Unable to delete file <b>$DeleteFile</b></font>");
	}
} else if($DeleteConfirm && $DeleteDir) {
	@chdir($dir); 
        if(@rmdir($DeleteDir)) {
                print("<font size=-1>Directory <b>$DeleteDir</b> deleted.</font>");
        } else {
                print("<font color=red size=-1>Unable to delete directory <b>$DeleteDir</b></font>");
        }
}

/*
	Delete Files and directories prompt
*/
if(($action == "delete") && $filemod) {
	print("<font size=-1>Delete file <b>$filemod</b>?<input type=\"submit\" name=\"DeleteConfirm\" value=\"Yes\" id=\"inputbutton\"></font>");
	print("<input type=\"hidden\" name=\"DeleteFile\" value=\"$filemod\"><br>");
	print("</td></tr></table></center>");
} else if(($action == "delete") && $dirmod) {
        print("<font size=-1>Delete directory <b>$dirmod</b>?<input type=\"submit\" name=\"DeleteConfirm\" value=\"Yes\" id=\"inputbutton\"></font>");
        print("<input type=\"hidden\" name=\"DeleteDir\" value=\"$dirmod\"><br>");
}


/*
        Rename Files and directories Actions
*/
if($RenameConfirm && $RenameFile && $RenameFileNew) {
	$pathdir = getcwd();
        if(rename("$pathdir/$RenameFile", "$pathdir/$RenameFileNew")) {
                print("<font size=-1>Renamed <b>$RenameFile</b> to <b>$RenameFileNew</b>.</font>");
        } else {
                print("<font color=red>Unable to rename <b>$RenameFile</b></font>");
        }
} else if($RenameConfirm && $RenameDir && $RenameDirNew) {
	$pathdir = getcwd();
        if(@rename("$pathdir/$RenameDir", "$pathdir/$RenameDirNew")) {
                print("<font size=-1>Directory <b>$RenameDir</b> renamed to <b>$RenameDirNew</b>.</font>");
        } else {
                print("<font color=red size=-1>Unable to rename directory <b>$RenameDir</b></font>");
        }
}

/*
        Rename Files and directories prompt
*/
if(($action == "rename") && $filemod) {
        print("<font size=-1>Rename file <b>$filemod</b> to <input type=text name=\"RenameFileNew\" value=\"$filemod\"></font>");
        print("<input type=\"submit\" name=\"RenameConfirm\" value=\"Yes\" id=\"inputbutton\">");
        print("<input type=\"hidden\" name=\"RenameFile\" value=\"$filemod\"><br>");
} else if(($action == "rename") && $dirmod) {
        print("<font size=-1>Rename directory<b>$dirmod</b> to <input type=text name=\"RenameDirNew\" value=\"$dirmod\"></font>");
	print("<input type=\"submit\" name=\"RenameConfirm\" value=\"Yes\" id=\"inputbutton\">");
        print("<input type=\"hidden\" name=\"RenameDir\" value=\"$dirmod\"><br>");
} 
print("</center></td></tr></table></center>");


?>
<? if(!$scriptLocalDrive) { ?>
<table width=100%>
<tr>
<td><font size=-1>Local Directory:</font><input type=text name=dir value="<? print($dir); ?>"></td>
<td><input type=submit name="Change" value="Change" id="inputbutton"></td>
</tr>
</table>
<? 	
}
	diskStats($scriptStats);
	print(dirHeader());
	print(dirTable());
	print(dirGatherLocal($dir));
	print(dirTable());
	print(dirFooter());
	diskStats($scriptStats);

?>
<input type="hidden" name="connFile" value="nonsel">
<input type="hidden" name="connUser" value="">
<input type="hidden" name="connPass" value="">
<input type="hidden" name="connServer" value="">
<input type="hidden" name="connPort" value="">
<input type="hidden" name="connAnon" value="">
<input type="hidden" name="connPasv" value="">
<input type="hidden" name="connDir" value="">
<input type="hidden" name="connMake" value="">
<input type="hidden" name="action" value="">
<input type="hidden" name="localDir" value="<? print(getcwd()); ?>">
</form>
</body>
<? } ?>
