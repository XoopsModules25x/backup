<?php
/**
 * ****************************************************************************
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  XOOPS Project
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package
 * @author metalslug
 *
 * Version : $Id:
 * ****************************************************************************
 */

require_once '../../../include/cp_header.php';
include 'admin_header.php';
xoops_cp_header();
$indexadmin = new ModuleAdmin();
$tot_file=0;
   if ($handle = opendir(XOOPS_ROOT_PATH.'/uploads/backup/')) {
   while (false !== ($file = readdir($handle))) {
       if ( $file == ".." || $file == "." || substr($file,0,1)=='.' || $file=="convert") continue;
   $tot_file++;
   }
   closedir($handle);
}

$val=mysql_query("SHOW VARIABLES LIKE 'character%'");
$val2=mysql_query("SHOW VARIABLES LIKE 'collation%'");
 $sql = "SHOW TABLES";
 $result = mysql_query($sql);
 $tot_tables = mysql_num_rows($result);
    $indexadmin->addInfoBox(_DB_BACKUP_BOX1);
    if ( 0 < $tot_file ) {
        $indexadmin->addInfoBoxLine(_DB_BACKUP_BOX1, _MD_BACKUP_TOTALFILES, $tot_file, 'Red');
    } else {
        $indexadmin->addInfoBoxLine(_DB_BACKUP_BOX1, _MD_BACKUP_TOTALFILES, $tot_file, 'Green');
    }
    $indexadmin->addInfoBox(_DB_BACKUP_BOX2);
    if ( 0 == $tot_tables ) {
        $indexadmin->addInfoBoxLine(_DB_BACKUP_BOX2, _MD_BACKUP_TOTALDB_TABLES, $tot_tables, 'Red');
    } else {
        $indexadmin->addInfoBoxLine(_DB_BACKUP_BOX2, _MD_BACKUP_TOTALDB_TABLES, $tot_tables, 'Green');
    }
    $a=0;
    while($re=mysql_fetch_array($val)) {
    $value[]=$re['Value'];
    $var_name[]=$re['Variable_name'];
    $indexadmin->addInfoBoxLine(_DB_BACKUP_BOX2, $var_name[$a]." %s", $value[$a], 'Green');
    $a++;
    }
    $a=0;
    unset($value);
    unset($var_name);
    while($re=mysql_fetch_array($val2)) {
    $value[]=$re['Value'];
    $var_name[]=$re['Variable_name'];
    $indexadmin->addInfoBoxLine(_DB_BACKUP_BOX2, $var_name[$a]." %s", $value[$a], 'Green');
    $a++;
    }
    echo $indexadmin->addNavigation('index.php') ;
        echo $indexadmin->renderIndex();
    
include "admin_footer.php";
