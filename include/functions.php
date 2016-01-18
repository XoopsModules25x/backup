<?php
// $Id: functions.php,v 1.5 2004/09/20 22:36:31 phppp Exp $
//  ------------------------------------------------------------------------ //
//                        DIGEST for XOOPS                                   //
//             Copyright (c) 2004 Xoops China Community                      //
//                    <http://www.xoops.org.cn/>                             //
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
// Author: D.J.(phppp) php_pp@hotmail.com                                    //
// URL: http://www.xoops.org.cn                                              //
// ------------------------------------------------------------------------- //

function backup_export($configs=null)
{
    if(!is_array($configs) || count($configs)==0){
        $module_handler =& xoops_gethandler('module');
        $xoopsModule =& $module_handler->getByDirname('backup');
        $config_handler = & xoops_gethandler( 'config' );
        $configs = & $config_handler->getConfigsByCat( 0, $xoopsModule->getVar( 'mid' ) );
    }
    if(!is_array($configs) || count($configs)==0){
        return false;
    }
    
    $export_file = XOOPS_CACHE_PATH.'/backup.php';
    if(!$fp = fopen($export_file,'w')) {
        echo "<br /> the update file can not be created";

        return false;
    }
    $file_content = "<?php";
    $file_content .= "\n	return \$config = '".serialize($configs)."';\n";
    $file_content .= "?>";
    fputs($fp,$file_content);
    fclose($fp);

    return true;
}

function &backup_import()
{
    $import_file = XOOPS_CACHE_PATH.'/backup.php';
    if(!is_readable($import_file) && !backup_export()) {
        echo "<br />the imported file can not be read: ".$import_file;

        return false;
    }
    $config = include($import_file);
    $configs = unserialize($config);

    return $configs;
}

function drop_table($datbase,$c_set)
{
    @mysql_select_db($datbase);
    $sql = "SHOW TABLES FROM ".$datbase;
    $tables = mysql_query($sql);
    $num_tables = @mysql_numrows($tables);
    if($num_tables>0) {
    for($i=0; $i<$num_tables; $i++){
        $name = mysql_tablename($tables, $i);
        $narray[]=$name;
        }
    $sql = implode(', ', $narray);

    @mysql_query("DROP TABLE $sql");
    }
    @mysql_query("ALTER DATABASE $datbase charset=".$c_set);
}
