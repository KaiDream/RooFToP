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

function localUploadFile() {
	if(top.frames['remote'].document.remote.connected.value == 1) {
		if(top.frames['local'].document.local.connFile.value == 1) {       
	      		top.frames['local'].document.local.connUser.value = top.frames['remote'].document.remote.connUser.value;
	      		top.frames['local'].document.local.connPass.value = top.frames['remote'].document.remote.connPass.value;
	      		top.frames['local'].document.local.connServer.value = top.frames['remote'].document.remote.connServer.value;
	      		top.frames['local'].document.local.connPort.value = top.frames['remote'].document.remote.connPort.value;
	      		top.frames['local'].document.local.connAnon.value = top.frames['remote'].document.remote.connAnon.value;
	      		top.frames['local'].document.local.connPasv.value = top.frames['remote'].document.remote.connPasv.value;
	      		top.frames['local'].document.local.connDir.value = top.frames['remote'].document.remote.connDir.value;
	      		top.frames['local'].document.local.submit();
			//return true;
		} else {
			alert('You must choose a file to upload.');
			//return false;
		}	
	} else {
	     alert("Please establish a connection to upload the file to.");
	     //return false;
	}
}

function localDeleteFile() {
	if(top.frames['local'].document.local.connFile.value == 1) {
		top.frames['local'].document.local.action.value = "delete";
		top.frames['local'].document.local.submit();			
	} else {
        	alert('You must choose a file to delete.');
                return false;		
	}
}

function localRenameFile() {
        if(top.frames['local'].document.local.connFile.value == 1) {
                top.frames['local'].document.local.action.value = "rename";
                top.frames['local'].document.local.submit();
        } else {
                alert('You must choose a file to rename.');        
                return false;          
        }
}

function checkRemoteConn() {
	if(top.frames['remote'].document.remote.connected.value == 1) {
		return true;
	} else {
		alert("Please establish an ftp  connection");
		return false;
	}
	
}

function remoteDeleteFile() {
        if(top.frames['remote'].document.remote.downFile.value == 1) {
                top.frames['remote'].document.remote.action.value = "delete";
                top.frames['remote'].document.remote.submit();
        } else {
                alert('You must choose a file to delete.');
                return false;
        }
}

function remoteRenameFile() {
        if(top.frames['remote'].document.remote.downFile.value == 1) {
                top.frames['remote'].document.remote.action.value = "rename";
                top.frames['remote'].document.remote.submit();
        } else {
                alert('You must choose a file to rename.');
                return false;
        }
}
function remoteDownloadFile() {
	if(top.frames['remote'].document.remote.downFile.value == 1) {
		top.frames['remote'].document.remote.localDir.value = top.frames['local'].document.local.localDir.value;
		top.frames['remote'].document.remote.submit();
	} else {
		alert('You must choose a file to download.');
		return false;
	}
}

function clientDownloadFile(filenam) {
                top.frames['remote'].document.remote.localDir.value = top.frames['local'].document.local.localDir.value;
		top.frames['remote'].document.remote.clientFile.value = filenam;
		top.frames['remote'].document.remote.action.value = "download";
		top.frames['remote'].document.remote.submit();
}
