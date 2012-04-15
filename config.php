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


/*
History: 
+ Added
- Remove
! Fixed
* Release

	12/07/01 * Released 1.0.1
		 ! Fixed Local directory loop

	12/06/01 * Released 1.0.0 	
	

*/

/*
 * Location of the Style Sheet for Application (must be web accessable)
 * Remote File: "http://www.domain.com/style.css"
 * Local Files: "/stlye.css"
 */

$scriptCSS = "/style.css"; 

/*
 * Key Definaion for URL Encryption 
 * Can be Anything you want
*/

$varCyptKey = "RooFToP"; // Key Definaion for URL Encryption

/*
 * You can limit access to the local drive by assigning a directory to
 * use with RooFToP. If no value is specified access to drive on the local
 * server will be depended on Web Server access. This directory must allow 
 * access from the user.group of the webserver
 *
 * * CAUTION * - Allowing Full access to your drive is a severe security risk. If mutiple 
 * people will have access to RooFTop it is recomened you specify a directory to keep 
 * people fromaccessing your drive.
 *
 * It is also recomened that you put in proper security measures to insure that outsiders
 * do not take advantage of your system.
 */

$scriptLocalDrive = "";

?>
