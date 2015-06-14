<?php
// $Id: admin_forum_prune.php,v 1.3 2005/10/19 17:20:32 phppp Exp $
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      //
// Copyright (c) 2000 XOOPS.org                           //
// <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
include_once '../../../include/cp_header.php';
include 'admin_header.php';
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

    xoops_cp_header();
    $indexAdmin = new ModuleAdmin();
    echo $indexAdmin->addNavigation('other.php');
    if (!empty($_POST['db_name'])) {
    $db        = $_POST['db_name'];

        $db_selected = mysql_select_db($db);
        if (!$db_selected) {
        redirect_header('other.php', 3, 'Database not exist');
        }

    $sql        = "SHOW TABLES FROM $db";
    $tables    = mysql_query($sql);
    $num_tables = @mysql_numrows($tables);
    $value = $db."<br />";

    $options = array(0=>_NONE, 1=>_ALL);
    for($i=0; $i<$num_tables; $i++){
        $name = mysql_tablename($tables, $i);
        $options[$name] = $name;
    }

    $val=mysql_query("show variables like 'character%'");
    while($re=mysql_fetch_array($val)) {
    $value.=$re['Variable_name']." ".$re['Value']."<br />";
    }
    $sform = new XoopsThemeForm(_DB_BACKUP_TITLE, 'name', 'backup.php?oldurl='.$_SERVER['PHP_SELF'].'&db_name='.$db, 'post');
        $tab_select = new XoopsFormSelect(_DB_TABLES, 'tables', null, 6,true);
        $tab_select->addOptionArray($options);
    $sform->addElement($tab_select, true);
    $tarea = new XoopsFormLabel($value);
    $sform->addElement($tarea);
    $button_tray = new XoopsFormElementTray('' ,'');
    $submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
    $button_tray->addElement($submit_btn);
    $sform->addElement($button_tray);
    $sform->display();
    } else {

    $sform = new XoopsThemeForm(_DB_BACKUP_TITLE, 'name', 'other.php', 'post');
    $sform->addElement(new XoopsFormText(_DB_DBASE, 'db_name', 50, 255, ""), true);
    $button_tray = new XoopsFormElementTray('' ,'');
    $submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
    $button_tray->addElement($submit_btn);
    $sform->addElement($button_tray);
    $sform->display();
    }
    //$submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
    //$button_tray->addElement($submit_btn);
    //$sform->addElement($button_tray);
    //$sform->display();
include 'admin_footer.php';
