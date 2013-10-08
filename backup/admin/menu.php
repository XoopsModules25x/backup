<?php
// $Id: menu.php,v 1.7 2003/04/17 12:45:28 okazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

$module_handler =& xoops_gethandler('module');
$xoopsModule =& XoopsModule::getByDirname('backup');
$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathIcon32 = $moduleInfo->getInfo('icons32');

$i = 1;
$adminmenu[$i]['title'] = _MI_BACKUP_ADMIN_HOME;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['desc']  = _MI_BACKUP_ADMIN_HOME_DESC;
$adminmenu[$i]['icon']  = '../../'.$pathIcon32.'/home.png' ;
$i++;
$adminmenu[$i]['title'] = _MI_BACKUP_ADMENU2;
$adminmenu[$i]['link'] = "admin/main.php?op=backup"; 
$adminmenu[$i]['icon']  = 'images/admin/database.png';
$i++;
$adminmenu[$i]['title'] = _MI_BACKUP_ADMENU3;
$adminmenu[$i]['link'] = "admin/other.php"; 
$adminmenu[$i]['icon']  = 'images/admin/database_add.png';
$i++;
$adminmenu[$i]['title'] = _MI_BACKUP_ADMENU4;
$adminmenu[$i]['link'] = "admin/main.php?op=restore"; 
$adminmenu[$i]['icon']  = 'images/admin/restore.png';
$i++;
$adminmenu[$i]['title'] = _MI_BACKUP_ADMENU5;
$adminmenu[$i]['link'] = "admin/main.php?op=delete"; 
$adminmenu[$i]['icon']  = 'images/admin/delete.png';
$i++;
$adminmenu[$i]['title'] = _MI_BACKUP_ADMENU6;
$adminmenu[$i]['link'] = "admin/main.php?op=show"; 
$adminmenu[$i]['icon']  = 'images/admin/show.png';
$i++;
$adminmenu[$i]['title'] = _MI_BACKUP_ADMENU7;
$adminmenu[$i]['link'] = "admin/main.php?op=del_db"; 
$adminmenu[$i]['icon']  = 'images/admin/del.png';
$i++;
$adminmenu[$i]['title'] = _MI_BACKUP_ADMIN_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['desc']  = _MI_BACKUP_ADMIN_ABOUT_DESC;
$adminmenu[$i]['icon']  = '../../'.$pathIcon32.'/about.png';
?>
