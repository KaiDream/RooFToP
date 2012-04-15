<? 
/*
 * RooFToP - Remote FTP Client
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

if($HTTP_COOKIE_VARS["authen"] != "INVALID") { 
require("config.php"); ?>
<html>
        <head>
                <title>RuFToP - PHP FTP Client (Connection)</title>
                <LINK REL=stylesheet HREF="<? print($scriptCSS); ?>" TYPE="text/css">
        </head>
<body>


<form method="post" action="remote.php" target="remote" name="connect">
<table width=100%>
<tr>
	<td width=1%>Server:</td>
	<td width=5%><input type="text" name="connServer"></td>
	<td width=1%>Port:</td>
	<td width=5%><input type="text" name="connPort" value="21"></td>
        <td width=5%>Passive Mode:</td>
        <td width=1%><input type="checkbox" name="connPasv"></td>
	<td align=right><input type="reset" name="connReset" value="Reset Connection" id="inputbutton"></td>	
</tr>
<tr>
        <td width=1%>UserName:</td>
        <td width=5%><input type="text" name="connUser"></td>
        <td width=1%>Password:</td>
        <td width=5%><input type="password" name="connPass"></td>
        <td width=5%>Anonymous:</td>
        <td width=1%><input type="checkbox" name="connAnon" onClick="connUser.disabled=this.checked;connPass.disabled=this.checked;";></td>
	<td align=right><input type="submit" name="connMake" value="Connect to Server" id="inputbutton"></td>
</tr>	
</table> 
<table width=100%>
<tr>
	<td width=100% align=right></td>
</tr>
</table>
<table width=100%><tr><td align=left width=50%>
<input type="button" name="Upload" value="Upload to Remote" OnClick="top.localUploadFile();"; id="inputbutton">
<input type="button" name="Delete" value="Delete" id="inputbutton" onClick="top.localDeleteFile();";>
<input type="button" name="Rename" value="Rename" id="inputbutton" onClick="top.localRenameFile();";>
<input type="button" name="Refresh" value="Refresh" id="inputbutton" onClick="top.frames['local'].document.local.submit();";>
</td><td> -
</td><td align=right width=50%>
<input type="button" name="Download" value="Download to Local" id="inputbutton" OnClick="if(top.checkRemoteConn()) top.remoteDownloadFile();";>
<input type="button" name="Delete" value="Delete" id="inputbutton" OnClick="if(top.checkRemoteConn())top.remoteDeleteFile();";>
<input type="button" name="Rename" value="Rename" id="inputbutton" OnClick="if(top.checkRemoteConn())top.remoteRenameFile();";>
<input type="button" name="Refresh" value="Refresh" id="inputbutton" onClick="top.frames['remote'].document.remote.submit();";>
</td></tr></table>
</body>
</html>
<? } ?>
