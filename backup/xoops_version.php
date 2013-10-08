<?php
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

$modversion['name'] = _DB_BACKUP_NAME;
$modversion['version'] = 3.3;
$modversion['description'] = _DB_BACKUP_DESC;
$modversion['author'] = "Peter Nagl";
$modversion['credits'] = "The XOOPS Project";
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = "www.gnu.org/licenses/gpl-2.0.html/";
$modversion['official'] = 0;
$modversion['image'] = "images/slogo.png";
$modversion['dirname'] = "backup";
$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16'] = 'Frameworks/moduleclasses/icons/16';
$modversion['icons32'] = 'Frameworks/moduleclasses/icons/32';

//about
$modversion['status_version'] = 'Final';
$modversion['release_date'] = '2012/12/16';
$modversion["module_website_url"] = "www.xoops.org/";
$modversion["module_website_name"] = "XOOPS";
$modversion["module_status"] = "Final";
$modversion["author_website_url"] = "http://www.metalslug.altervista.org/";
$modversion["author_website_name"] = "Metalaslug";
$modversion['min_php']=5.2;
$modversion['min_xoops']="2.5.5";
$modversion['min_admin']= "1.1";
$modversion['min_db']= array('mysql'=>'5.0.7', 'mysqli'=>'5.0.7');
$modversion['system_menu'] = 1;


// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 0;

//Config
$i=1;
$modversion['config'][$i]['name'] = 'cfgBackupTarget';
$modversion['config'][$i]['title'] = '_DB_TARGET';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'email';
$modversion['config'][$i]['options'] = array('Download' => 'download', 'E-Mail' => 'email', 'Save on server' => 'cache');
$i++;
$modversion['config'][$i]['name'] = 'drop';
$modversion['config'][$i]['title'] = '_DB_ALLOWDROP';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'cfgZipType';
$modversion['config'][$i]['title'] = '_DB_ZIPTYPE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'zip';
//$modversion['config'][3]['options'] = array('gzip' => 'gzip', 'bzip' => 'bzip', 'zip' => 'zip', 'Sql' => 'sql');
$modversion['config'][$i]['options'] = array('gzip' => 'gzip', 'Sql' => 'sql');
$i++;
$modversion['config'][$i]['name'] = 'cfgExecTimeLimit';
$modversion['config'][$i]['title'] = '_DB_EXECTIMELIMIT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 300;
$i++;
$modversion['config'][$i]['name'] = 'use_backquotes';
$modversion['config'][$i]['title'] = '_DB_ALLOWBACKQUOTES';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'email_to';
$modversion['config'][$i]['title'] = '_DB_EMAILTO';
$modversion['config'][$i]['description'] = '_DB_EMAILTO_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = $xoopsConfig['adminmail'];
$i++;
$modversion['config'][$i]['name'] = 'email_attach';
$modversion['config'][$i]['title'] = '_DB_EMAILATTACH';
$modversion['config'][$i]['description'] = '_DB_EMAILATTACH_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'dbfiles_store';
$modversion['config'][$i]['title'] = '_DB_DBFILES';
$modversion['config'][$i]['description'] = '_DB_DBFILES_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 2;
$i++;
$modversion['config'][$i]['name'] = 'dbfiles_path';
$modversion['config'][$i]['title'] = '_DB_DBFILES_PATH';
$modversion['config'][$i]['description'] = '_DB_DBFILES_PATH_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = "uploads/backup";
$i++;
$modversion['config'][$i]['name'] = 'split';
$modversion['config'][$i]['title'] = '_DB_SINGLE_SELECT';
$modversion['config'][$i]['description'] = '_DB_SINGLE_SELECT_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$sql = "SHOW TABLES FROM ".XOOPS_DB_NAME;
$tables = mysql_query($sql);
$num_tables = @mysql_numrows($tables);
$options = array(_NONE=>"0", _ALL=>"1");
for($i=0; $i<$num_tables; $i++){
	$name = mysql_tablename($tables, $i);
	$options[$name] = $name;
}
$i++;
$modversion['config'][$i]['name'] = 'dbfiles_split';
$modversion['config'][$i]['title'] = '_DB_DBFILES_SPLIT';
$modversion['config'][$i]['description'] = '_DB_DBFILES_SPLIT_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['options'] = $options;
$modversion['config'][$i]['default'] = "1";
$i++;
$modversion['config'][$i]['name'] = 'pos_line';
$modversion['config'][$i]['title'] = '_DB_POSLINE';
$modversion['config'][$i]['description'] = '_DB_POSLINE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

if(!file_exists(XOOPS_ROOT_PATH."/uploads/backup")) {
mkdir(XOOPS_ROOT_PATH."/uploads/backup", 0755);
}
?>
