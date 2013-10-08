<?php
include_once '../../../include/cp_header.php';
include_once 'admin_header.php';
include_once XOOPS_ROOT_PATH."/modules/" . $xoopsModule->getVar("dirname") . "/include/functions.php";
if ( file_exists("../language/".$xoopsConfig['language']."/admin.php") ) {
	include_once "../language/".$xoopsConfig['language']."/admin.php";
} else  {
include_once "../language/english/admin.php";
}
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
$op  = !empty( $_GET[ 'op' ] ) ? $_GET['op'] :"index";

switch ($op)
{
	case "backup":
		xoops_cp_header(); 
		$index_admin = new ModuleAdmin();
		echo $index_admin->addNavigation('main.php?op=backup');
		if (isset($_POST['backup']) && $_POST['backup']=="confirm_backup")
			{
			header ('location: backup.php?oldurl='.$_SERVER['PHP_SELF']);
			exit();	
		}
		xoops_confirm(array( 'backup' => "confirm_backup" ), 'main.php?op=backup', _AM_DBASE_BACKUP); 
		break;
	

	case "restore":
		xoops_cp_header(); 
		$index_admin = new ModuleAdmin();
		echo $index_admin->addNavigation('main.php?op=restore');
		if (!isset($_POST['db_name'])) {

			$sform = new XoopsThemeForm(_MI_BACKUP_ADMENU4, 'name', '', 'post'); 
			$sform->addElement(new XoopsFormText(_DB_DBASE, 'db_name', 50, 255, ""), true);
			//$sform->addElement(new XoopsFormText(_DB_DBASE, 'testmode', 50, 155, "false"), true);
			//$file_select = new XoopsFormSelect(_DB_TABLES, 'file');
			//$file_select->addOptionArray($file_a);
   			//$sform->addElement($file_select, true);
			$tab_select = new XoopsFormSelect(_DB_CHARSET, 'c_set');
    			$tab_select->addOption('utf8','Utf8');
			$tab_select->addOption('latin1','Latin1');
   			$sform->addElement($tab_select, true);
			$button_tray = new XoopsFormElementTray('' ,'');
			$submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
			$button_tray->addElement($submit_btn);
			$sform->addElement($button_tray);
			$sform->display();
			} else {
			$db_name=$_POST['db_name'];
			$c_set=$_POST['c_set'];
			setcookie('db_name',$db_name,time()+3600,"/");
			setcookie('c_set',$c_set,time()+3600,"/");
			drop_table($db_name,$c_set);
			header ('location: bigdump.php');
			exit;
			}
		break;



	case "delete":
		xoops_cp_header(); 
		$index_admin = new ModuleAdmin();
		echo $index_admin->addNavigation('main.php?op=delete');
		if (isset($_POST['delete']) && $_POST['delete']=="confirm_delete")
			{
			$dirpath=XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['dbfiles_path'].'/';
			$handle = opendir($dirpath);
  			while (($file = readdir($handle)) !== false) {
			if ( $file != ".." && $file != "." && substr($file,0,1)!='.' ) 
    			@unlink($dirpath . $file);
  			}
  			closedir($handle);
			redirect_header("index.php", 2, _AM_DBASE_FILES_DELETED);	
			exit();	
		}
		xoops_confirm(array( 'delete' => "confirm_delete" ), 'main.php?op=delete', _AM_DBASE_DELETE); 
		break;

	case "del_db":
		xoops_cp_header(); 
		$index_admin = new ModuleAdmin();
		echo $index_admin->addNavigation('main.php?op=del_db');
		if(!empty($_POST['db_name_del'])) {
		$db_del_name = $_POST['db_name_del'];
		$charset = $_POST['charset'];
		if($db_del_name==XOOPS_DB_NAME)
			{
			redirect_header('index.php', 3, _NOPERM);
			exit;
			} else {
			$db_selected = mysql_select_db($db_del_name);
			if (!$db_selected) {
  			redirect_header('main.php?op=del_db', 3, 'Database not exist');
			}
			@drop_table($db_del_name,$charset);
			redirect_header('index.php', 3, 'Database was deleted');
			exit;
			}
		} else {
		$sform = new XoopsThemeForm(_MI_BACKUP_ADMENU7, 'name', 'main.php?op=del_db', 'post'); 
		$sform->addElement(new XoopsFormText(_DB_DBASE, 'db_name_del', 50, 255, ""), true);
		$tab_select = new XoopsFormSelect(_DB_CHARSET, 'charset');
		$tab_select->addOption('utf8','Utf8');
		$tab_select->addOption('latin1','Latin1');
   		$sform->addElement($tab_select, true);
		$button_tray = new XoopsFormElementTray('' ,'');
		$submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
		$button_tray->addElement($submit_btn);
		$sform->addElement($button_tray);
		$sform->display();
		}
		break;

	case "index":
		header ('location: index.php');
		exit();	 
		break;

	case "show":
		xoops_cp_header();
    		$indexAdmin = new ModuleAdmin();
    		echo $indexAdmin->addNavigation('main.php?op=show');
		if (!empty($_POST['db_name'])) {
		$db 		= $_POST['db_name'];

		$db_selected = mysql_select_db($db);
		if (!$db_selected) {
  		redirect_header('main.php?op=show', 3, 'Database not exist');
		}

	$sql 		= "SHOW TABLES FROM $db";
	$tables 	= mysql_query($sql);
	$num_tables = @mysql_numrows($tables);
	$value = $db."<br />";	

	for($i=0; $i<$num_tables; $i++){
		$name = mysql_tablename($tables, $i);
		$options[$name] = $name;
	}

	$val=mysql_query("show variables like 'character%'");
	while($re=mysql_fetch_array($val)) {
	$value.=$re['Variable_name']." ".$re['Value']."<br />";
	}
	$sform = new XoopsThemeForm(_DB_VIEW_TABLE, 'name', 'view.php?db='.$db, 'post');
    	$tab_select = new XoopsFormSelect(_DB_TABLES, 'tables', null, 6,false);
    	$tab_select->addOptionArray($options);
   	$sform->addElement($tab_select, true);
	$button_tray = new XoopsFormElementTray('' ,'');
	$submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
	$button_tray->addElement($submit_btn);
	$sform->addElement($button_tray);
	$sform->display();
	} else {

	$sform = new XoopsThemeForm(_DB_VIEW_TABLE, 'name', '', 'post');
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
		break;

}

include "admin_footer.php";
